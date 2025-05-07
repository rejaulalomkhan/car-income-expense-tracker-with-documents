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

    public $dateFilter = 'this_month';
    public $startDate;
    public $endDate;
    public $selectedCar = 'all';
    public $stats = [];
    public $chartData = [];
    public $records = [];

    protected $queryString = ['dateFilter', 'startDate', 'endDate', 'selectedCar'];

    public function boot()
    {
        $now = Carbon::now();
        $this->startDate = $now->startOfMonth()->format('Y-m-d');
        $this->endDate = $now->endOfMonth()->format('Y-m-d');
    }

    public function mount()
    {
        $this->updateStats();
    }

    public function updatedDateFilter($value)
    {
        $now = Carbon::now();

        switch ($value) {
            case 'today':
                $this->startDate = $now->format('Y-m-d');
                $this->endDate = $now->format('Y-m-d');
                break;
            case 'yesterday':
                $this->startDate = $now->subDay()->format('Y-m-d');
                $this->endDate = $now->format('Y-m-d');
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
        $this->updateStats();
    }

    public function updatedEndDate()
    {
        $this->updateStats();
    }

    public function updatedSelectedCar()
    {
        $this->updateStats();
    }

    public function updateStats()
    {
        // Calculate total income
        $incomeQuery = Income::query()
            ->whereBetween('date', [$this->startDate, $this->endDate]);

        if ($this->selectedCar !== 'all') {
            $incomeQuery->where('car_id', $this->selectedCar);
        }

        $totalIncome = $incomeQuery->sum('amount');

        // Calculate total expenses
        $expenseQuery = Expense::query()
            ->whereBetween('date', [$this->startDate, $this->endDate]);

        if ($this->selectedCar !== 'all') {
            $expenseQuery->where('car_id', $this->selectedCar);
        }

        $totalExpense = $expenseQuery->sum('amount');
        $netIncome = $totalIncome - $totalExpense;

        $this->stats = [
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'net_income' => $netIncome,
            'profit_margin' => $totalIncome > 0 ? ($netIncome / $totalIncome) * 100 : 0,
        ];

        // Update chart data
        $this->generateChartData();

        // Get records for the table
        $this->getRecords();

        // Emit chart data updated event
        $this->dispatch('chartDataUpdated', $this->chartData);
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
            // Daily data for periods up to a month
            for ($date = clone $start; $date <= $end; $date->addDay()) {
                $labels[] = $date->format('M d');

                $incomeQuery = Income::whereDate('date', $date);
                $expenseQuery = Expense::whereDate('date', $date);

                if ($this->selectedCar !== 'all') {
                    $incomeQuery->where('car_id', $this->selectedCar);
                    $expenseQuery->where('car_id', $this->selectedCar);
                }

                $incomeData[] = $incomeQuery->sum('amount');
                $expenseData[] = $expenseQuery->sum('amount');
            }
        } else {
            // Monthly data for longer periods
            for ($date = clone $start; $date <= $end; $date->addMonth()) {
                $labels[] = $date->format('M Y');
                $monthEnd = (clone $date)->endOfMonth();

                $incomeQuery = Income::whereBetween('date', [
                    $date->format('Y-m-d'),
                    $monthEnd->format('Y-m-d')
                ]);

                $expenseQuery = Expense::whereBetween('date', [
                    $date->format('Y-m-d'),
                    $monthEnd->format('Y-m-d')
                ]);

                if ($this->selectedCar !== 'all') {
                    $incomeQuery->where('car_id', $this->selectedCar);
                    $expenseQuery->where('car_id', $this->selectedCar);
                }

                $incomeData[] = $incomeQuery->sum('amount');
                $expenseData[] = $expenseQuery->sum('amount');
            }
        }

        $this->chartData = [
            'labels' => $labels,
            'income' => $incomeData,
            'expense' => $expenseData,
        ];
    }

    protected function getRecords()
    {
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);

        $records = collect();
        for ($date = clone $start; $date <= $end; $date->addDay()) {
            $dayIncomes = Income::with('car')
                ->whereDate('date', $date)
                ->when($this->selectedCar !== 'all', function ($query) {
                    return $query->where('car_id', $this->selectedCar);
                })
                ->get();

            $dayExpenses = Expense::with('car')
                ->whereDate('date', $date)
                ->when($this->selectedCar !== 'all', function ($query) {
                    return $query->where('car_id', $this->selectedCar);
                })
                ->get();

            if ($dayIncomes->isNotEmpty() || $dayExpenses->isNotEmpty()) {
                $record = (object)[
                    'date' => clone $date,
                    'incomes' => $dayIncomes,
                    'expenses' => $dayExpenses,
                    'total_income' => $dayIncomes->sum('amount'),
                    'total_expense' => $dayExpenses->sum('amount')
                ];
                $records->push($record);
            }
        }

        $this->records = $records;
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
        $cars = Car::all();
        $recentIncomes = Income::with('car')
            ->latest('date')
            ->take(5)
            ->get();
        $recentExpenses = Expense::with('car')
            ->latest('date')
            ->take(5)
            ->get();

        return view('livewire.dashboard', [
            'cars' => $cars,
            'recentIncomes' => $recentIncomes,
            'recentExpenses' => $recentExpenses,
        ]);
    }
}
