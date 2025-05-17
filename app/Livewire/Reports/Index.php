<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\Car;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class Index extends Component
{
    public $dateRange = 'this_month';
    public $startDate;
    public $endDate;
    public $selectedCars = [];
    public $reportTypes = 'all';
    public $groupBy = 'category';
    public $settings;
    public $variant = 'summary';
    public $reportPeriodLabel = '';
    public $customMonth = '';
    public $customYear = '';
    public $summary = [
        'income' => 0,
        'expense' => 0,
        'balance' => 0,
    ];

    public function mount()
    {
        $this->settings = Setting::first();
        
        // Set default month and year to current month/year
        $now = Carbon::now();
        $this->customMonth = $now->format('m');
        $this->customYear = $now->format('Y');
        
        $this->setDateRange();
    }

    public function setDateRange()
    {
        $now = Carbon::now();
        switch ($this->dateRange) {
            case 'today':
                $this->startDate = $now->format('Y-m-d');
                $this->endDate = $now->format('Y-m-d');
                $this->reportPeriodLabel = 'Today (' . $now->format('M d, Y') . ')';
                break;
            case 'yesterday':
                $this->startDate = $now->subDay()->format('Y-m-d');
                $this->endDate = $this->startDate;
                $this->reportPeriodLabel = 'Yesterday (' . $now->format('M d, Y') . ')';
                break;
            case 'this_month':
                $this->startDate = $now->copy()->startOfMonth()->format('Y-m-d');
                $this->endDate = $now->copy()->endOfMonth()->format('Y-m-d');
                $this->reportPeriodLabel = $now->format('F Y');
                break;
            case 'last_month':
                $lastMonth = $now->copy()->subMonth();
                $this->startDate = $lastMonth->startOfMonth()->format('Y-m-d');
                $this->endDate = $lastMonth->endOfMonth()->format('Y-m-d');
                $this->reportPeriodLabel = $lastMonth->format('F Y');
                break;
            case 'this_year':
                $this->startDate = $now->copy()->startOfYear()->format('Y-m-d');
                $this->endDate = $now->copy()->endOfYear()->format('Y-m-d');
                $this->reportPeriodLabel = $now->format('Y');
                break;
            case 'last_year':
                $lastYear = $now->copy()->subYear();
                $this->startDate = $lastYear->startOfYear()->format('Y-m-d');
                $this->endDate = $lastYear->endOfYear()->format('Y-m-d');
                $this->reportPeriodLabel = $lastYear->format('Y');
                break;
            case 'custom':
                // If dates are not set, default to current month
                if (empty($this->startDate) || empty($this->endDate)) {
                    $this->startDate = $now->copy()->startOfMonth()->format('Y-m-d');
                    $this->endDate = $now->copy()->endOfMonth()->format('Y-m-d');
                }
                $startDate = Carbon::parse($this->startDate);
                $endDate = Carbon::parse($this->endDate);
                $this->reportPeriodLabel = $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y');
                break;
            default:
                $this->startDate = $now->copy()->startOfMonth()->format('Y-m-d');
                $this->endDate = $now->copy()->endOfMonth()->format('Y-m-d');
                $this->reportPeriodLabel = $now->format('F Y');
        }
    }

    public function updatedDateRange()
    {
        $this->setDateRange();
        
        // If custom date range is selected, set the dates based on the month/year selection
        if ($this->dateRange === 'custom') {
            $this->setCustomMonthYear();
        }
    }
    
    public function updatedCustomMonth()
    {
        if ($this->dateRange === 'custom') {
            $this->setCustomMonthYear();
        }
    }
    
    public function updatedCustomYear()
    {
        if ($this->dateRange === 'custom') {
            $this->setCustomMonthYear();
        }
    }

    public function updatedReportTypes($value)
    {
        // If 'all' is checked, set both types
        if ($value === 'all') {
            $this->reportTypes = 'all';
        } else {
            // If both expense and income are checked, auto-check 'all'
            $this->reportTypes = $value === 'expense' && $value === 'income' ? 'all' : $value;
        }
    }

    public function generateReport()
    {
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'reportTypes' => 'required|string|in:all,expense,income',
        ]);
        return $this->exportPDF();
    }

    public function getReportData()
    {
        $query = match($this->reportType) {
            'expense' => Expense::query(),
            'income' => Income::query(),
            'summary' => Expense::query(),
        };

        $query->whereBetween('date', [$this->startDate, $this->endDate]);

        if (!empty($this->selectedCars)) {
            $query->whereIn('car_id', $this->selectedCars);
        }

        if ($this->reportType === 'income') {
            return match($this->groupBy) {
                'category' => $this->groupBySource($query),
                'car' => $this->groupByCar($query),
                'date' => $this->groupByDate($query),
            };
        } else {
            return match($this->groupBy) {
                'category' => $this->groupByCategory($query),
                'car' => $this->groupByCar($query),
                'date' => $this->groupByDate($query),
            };
        }
    }

    protected function groupByCategory($query)
    {
        return $query->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();
    }

    protected function groupByCar($query)
    {
        return $query->select('car_id', DB::raw('SUM(amount) as total'))
            ->with('car')
            ->groupBy('car_id')
            ->get();
    }

    protected function groupByDate($query)
    {
        return $query->select(DB::raw('DATE(date) as date'), DB::raw('SUM(amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    protected function groupBySource($query)
    {
        return $query->select('source', DB::raw('SUM(amount) as total'))
            ->groupBy('source')
            ->get();
    }

    public function getSummary()
    {
        $income = Income::query()
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->when(!empty($this->selectedCars), fn($q) => $q->whereIn('car_id', $this->selectedCars))
            ->sum('amount');
        $expense = Expense::query()
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->when(!empty($this->selectedCars), fn($q) => $q->whereIn('car_id', $this->selectedCars))
            ->sum('amount');
        $this->summary = [
            'income' => $income,
            'expense' => $expense,
            'balance' => $income - $expense,
        ];
    }

    public function exportPDF()
    {
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'reportTypes' => 'required|string|in:all,expense,income',
        ]);

        $types = $this->reportTypes === 'all' ? ['expense', 'income'] : [$this->reportTypes];
        $data = [];
        foreach ($types as $type) {
            $data[$type] = $this->getReportDataForType($type);
        }

        $settings = $this->settings;
        $period = $this->reportPeriodLabel;
        $summary = $this->summary;
        $reportTypes = $this->reportTypes;
        $activeTypes = $types;

        // Generate report title based on type and period
        $reportTitle = match($this->reportTypes) {
            'all' => 'Complete Financial Report',
            'income' => 'Income Report',
            'expense' => 'Expense Report',
            default => 'Financial Report'
        };
        $reportTitle .= ' - ' . $this->reportPeriodLabel;

        $pdf = PDF::loadView('reports.pdf', [
            'data' => $data,
            'settings' => $settings,
            'period' => $period,
            'summary' => $summary,
            'reportTypes' => $reportTypes,
            'activeTypes' => $activeTypes,
            'reportTitle' => $reportTitle,
        ]);

        // Create a more descriptive filename based on report type and period
        $typePrefix = match($this->reportTypes) {
            'all' => 'Complete',
            'income' => 'Income',
            'expense' => 'Expense',
            default => 'Financial'
        };
        $filename = $typePrefix . '-Report-' . $this->reportPeriodLabel . '.pdf';
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename);
    }

    public function render()
    {
        $this->getSummary();
        $types = $this->reportTypes === 'all' ? ['expense', 'income'] : [$this->reportTypes];
        $reportData = [];
        foreach ($types as $type) {
            $reportData[$type] = $this->getReportDataForType($type);
        }

        return view('livewire.reports.index', [
            'cars' => Car::all(),
            'reportData' => $reportData,
            'summary' => $this->summary,
            'reportTypes' => $this->reportTypes,
            'activeTypes' => $types,
            'reportPeriodLabel' => $this->reportPeriodLabel,
        ])->layout('layouts.app');
    }

    public function getReportDataForType($type)
    {
        $query = $type === 'expense' ? Expense::query() : Income::query();
        
        // Apply date filter
        $query->whereBetween('date', [$this->startDate, $this->endDate]);
        
        // Apply car filter if selected
        if (!empty($this->selectedCars)) {
            $query->whereIn('car_id', $this->selectedCars);
        }

        // Get all cars first
        $cars = Car::all();
        
        // Initialize the byCar collection with all cars
        $byCar = collect();
        foreach ($cars as $car) {
            $total = $query->clone()
                ->where('car_id', $car->id)
                ->whereBetween('date', [$this->startDate, $this->endDate])
                ->sum('amount');
            
            $byCar->push((object)[
                'car' => $car,
                'total' => $total
            ]);
        }

        if ($type === 'expense') {
            // Get expenses by category
            $byCategory = $query->select('category', DB::raw('SUM(amount) as total'))
                ->groupBy('category')
                ->get();

            return ['byCategory' => $byCategory, 'byCar' => $byCar];
        } else {
            // Get income by source
            $bySource = $query->select('source', DB::raw('SUM(amount) as total'))
                ->groupBy('source')
                ->get();

            return ['bySource' => $bySource, 'byCar' => $byCar];
        }
    }

    public function setCustomMonthYear()
    {
        if (!empty($this->customMonth) && !empty($this->customYear)) {
            $date = Carbon::createFromDate($this->customYear, $this->customMonth, 1);
            $this->startDate = $date->startOfMonth()->format('Y-m-d');
            $this->endDate = $date->endOfMonth()->format('Y-m-d');
            $this->reportPeriodLabel = $date->format('F Y');
        }
    }
} 