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
    public $percentageChanges = [];

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
        $this->calculatePercentageChanges();
    }

    protected function calculatePercentageChanges()
    {
        $now = Carbon::now();
        $previousStartDate = Carbon::parse($this->startDate)->subDays($now->diffInDays(Carbon::parse($this->startDate)));
        $previousEndDate = Carbon::parse($this->endDate)->subDays($now->diffInDays(Carbon::parse($this->endDate)));

        // Calculate previous period's totals
        $previousIncomeQuery = Income::query()
            ->whereBetween('date', [$previousStartDate, $previousEndDate]);
        $previousExpenseQuery = Expense::query()
            ->whereBetween('date', [$previousStartDate, $previousEndDate]);

        if ($this->selectedCar !== 'all') {
            $previousIncomeQuery->where('car_id', $this->selectedCar);
            $previousExpenseQuery->where('car_id', $this->selectedCar);
        }

        $previousTotalIncome = $previousIncomeQuery->sum('amount');
        $previousTotalExpense = $previousExpenseQuery->sum('amount');
        $previousNetIncome = $previousTotalIncome - $previousTotalExpense;
        $previousProfitMargin = $previousTotalIncome > 0 ? ($previousNetIncome / $previousTotalIncome) * 100 : 0;

        // Calculate percentage changes
        $this->percentageChanges = [
            'income' => $previousTotalIncome > 0 ? 
                (($this->stats['total_income'] - $previousTotalIncome) / $previousTotalIncome) * 100 : 0,
            'expense' => $previousTotalExpense > 0 ? 
                (($this->stats['total_expense'] - $previousTotalExpense) / $previousTotalExpense) * 100 : 0,
            'net_income' => $previousNetIncome != 0 ? 
                (($this->stats['net_income'] - $previousNetIncome) / abs($previousNetIncome)) * 100 : 0,
            'profit_margin' => $previousProfitMargin != 0 ? 
                (($this->stats['profit_margin'] - $previousProfitMargin) / abs($previousProfitMargin)) * 100 : 0,
        ];
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
        $this->calculatePercentageChanges();
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
        try {
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

            // Emit chart data updated event with validation
            if (!empty($this->chartData['labels']) && !empty($this->chartData['income']) && !empty($this->chartData['expense'])) {
                $this->dispatch('chartDataUpdated', $this->chartData);
            } else {
                $this->dispatch('error', 'No data available for the selected period');
            }
        } catch (\Exception $e) {
            $this->dispatch('error', 'Error updating stats: ' . $e->getMessage());
        }
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

    protected function getSummaryByCarAndDate()
    {
        $cars = Car::all();
        $startDate = Carbon::parse($this->startDate);
        $endDate = Carbon::parse($this->endDate);

        $incomes = Income::whereBetween('date', [$startDate, $endDate])
            ->get()
            ->groupBy('car_id');

        $expenses = Expense::whereBetween('date', [$startDate, $endDate])
            ->get()
            ->groupBy('car_id');

        $summary = [];
        foreach ($cars as $car) {
            $carIncome = $incomes->get($car->id, collect())->sum('amount');
            $carExpense = $expenses->get($car->id, collect())->sum('amount');
            $summary[] = [
                'car' => $car,
                'income' => $carIncome,
                'expense' => $carExpense,
                'net' => $carIncome - $carExpense
            ];
        }

        return [
            'cars' => $cars,
            'summary' => $summary,
            'totalIncome' => $incomes->flatten()->sum('amount'),
            'totalExpense' => $expenses->flatten()->sum('amount'),
        ];
    }

    public function getDateRangeText()
    {
        switch ($this->dateFilter) {
            case 'today':
                return 'Today';
            case 'yesterday':
                return 'Yesterday';
            case 'this_month':
                return 'This Month';
            case 'last_month':
                return 'Last Month';
            case 'this_year':
                return 'This Year';
            case 'last_year':
                return 'Last Year';
            case 'custom':
                $start = Carbon::parse($this->startDate);
                $end = Carbon::parse($this->endDate);
                return $start->format('M j, Y') . ' - ' . $end->format('M j, Y');
            default:
                return $this->dateFilter;
        }
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

        $summary = $this->getSummaryByCarAndDate();
        $dateRangeText = $this->getDateRangeText();

        return view('livewire.dashboard', [
            'cars' => $cars,
            'recentIncomes' => $recentIncomes,
            'recentExpenses' => $recentExpenses,
            'summary' => $summary,
            'dateRangeText' => $dateRangeText,
            'stats' => $this->stats,
            'percentageChanges' => $this->percentageChanges,
            'records' => $this->records,
            'chartData' => $this->chartData,
        ]);
    }
}
