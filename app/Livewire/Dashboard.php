<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Car;
use App\Models\Income;
use App\Models\Expense;
use Livewire\WithPagination;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FinancialReportExport;

class Dashboard extends Component
{
    use WithPagination;

    public $dateFilter = 'today';
    public $startDate;
    public $endDate;
    public $selectedCar = 'all';
    public $stats = [];
    public $chartData = [];

    protected $queryString = ['dateFilter', 'startDate', 'endDate', 'selectedCar'];

    public function boot()
    {
        $now = Carbon::now();
        $this->startDate = $now->startOfMonth()->format('Y-m-d');
        $this->endDate = $now->endOfMonth()->format('Y-m-d');
        $this->dateFilter = 'this_month';
    }

    public function mount()
    {
        $this->updateStats();
    }

    public function updatedDateFilter()
    {
        $now = Carbon::now();
        switch ($this->dateFilter) {
            case 'today':
                $this->startDate = $now->startOfDay()->format('Y-m-d');
                $this->endDate = $now->endOfDay()->format('Y-m-d');
                break;
            case 'yesterday':
                $this->startDate = $now->subDay()->startOfDay()->format('Y-m-d');
                $this->endDate = $now->endOfDay()->format('Y-m-d');
                break;
            case 'this_month':
                $this->startDate = $now->startOfMonth()->format('Y-m-d');
                $this->endDate = $now->endOfMonth()->format('Y-m-d');
                break;
            case 'last_month':
                $this->startDate = $now->subMonth()->startOfMonth()->format('Y-m-d');
                $this->endDate = $now->endOfMonth()->format('Y-m-d');
                break;
            case 'this_year':
                $this->startDate = $now->startOfYear()->format('Y-m-d');
                $this->endDate = $now->endOfYear()->format('Y-m-d');
                break;
            case 'last_year':
                $this->startDate = $now->subYear()->startOfYear()->format('Y-m-d');
                $this->endDate = $now->endOfYear()->format('Y-m-d');
                break;
        }
        $this->updateStats();
        $this->dispatch('dateRangeUpdated', [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ]);
    }

    public function updatedStartDate()
    {
        if ($this->dateFilter !== 'custom') {
            $this->dateFilter = 'custom';
        }
        $this->updateStats();
    }

    public function updatedEndDate()
    {
        if ($this->dateFilter !== 'custom') {
            $this->dateFilter = 'custom';
        }
        $this->updateStats();
    }

    public function updatedSelectedCar()
    {
        $this->updateStats();
    }

    public function updateStats()
    {
        $query = Income::query()
            ->whereBetween('date', [$this->startDate, $this->endDate]);

        if ($this->selectedCar !== 'all') {
            $query->where('car_id', $this->selectedCar);
        }

        $totalIncome = $query->sum('amount');

        $query = Expense::query()
            ->whereBetween('date', [$this->startDate, $this->endDate]);

        if ($this->selectedCar !== 'all') {
            $query->where('car_id', $this->selectedCar);
        }

        $totalExpense = $query->sum('amount');
        $netIncome = $totalIncome - $totalExpense;

        $this->stats = [
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'net_income' => $netIncome,
            'profit_margin' => $totalIncome > 0 ? ($netIncome / $totalIncome) * 100 : 0,
        ];

        // Generate chart data
        $this->generateChartData();
    }

    protected function generateChartData()
    {
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);
        $diffInDays = $start->diffInDays($end);

        $labels = [];
        $incomeData = [];
        $expenseData = [];

        if ($diffInDays <= 31) {
            // Daily data
            for ($date = $start; $date <= $end; $date->addDay()) {
                $labels[] = $date->format('M d');
                $incomeData[] = Income::whereDate('date', $date)
                    ->when($this->selectedCar !== 'all', function ($query) {
                        return $query->where('car_id', $this->selectedCar);
                    })
                    ->sum('amount');
                $expenseData[] = Expense::whereDate('date', $date)
                    ->when($this->selectedCar !== 'all', function ($query) {
                        return $query->where('car_id', $this->selectedCar);
                    })
                    ->sum('amount');
            }
        } else {
            // Monthly data
            for ($date = $start; $date <= $end; $date->addMonth()) {
                $labels[] = $date->format('M Y');
                $incomeData[] = Income::whereYear('date', $date->year)
                    ->whereMonth('date', $date->month)
                    ->when($this->selectedCar !== 'all', function ($query) {
                        return $query->where('car_id', $this->selectedCar);
                    })
                    ->sum('amount');
                $expenseData[] = Expense::whereYear('date', $date->year)
                    ->whereMonth('date', $date->month)
                    ->when($this->selectedCar !== 'all', function ($query) {
                        return $query->where('car_id', $this->selectedCar);
                    })
                    ->sum('amount');
            }
        }

        $this->chartData = [
            'labels' => $labels,
            'income' => $incomeData,
            'expense' => $expenseData,
        ];
    }

    public function exportReport()
    {
        return Excel::download(
            new FinancialReportExport($this->startDate, $this->endDate, $this->selectedCar),
            'financial-report-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'cars' => Car::all(),
            'recentIncomes' => Income::with('car')
                ->when($this->selectedCar !== 'all', function ($query) {
                    return $query->where('car_id', $this->selectedCar);
                })
                ->whereBetween('date', [$this->startDate, $this->endDate])
                ->latest()
                ->take(5)
                ->get(),
            'recentExpenses' => Expense::with('car')
                ->when($this->selectedCar !== 'all', function ($query) {
                    return $query->where('car_id', $this->selectedCar);
                })
                ->whereBetween('date', [$this->startDate, $this->endDate])
                ->latest()
                ->take(5)
                ->get(),
        ])->layout('components.layouts.app');
    }
}
