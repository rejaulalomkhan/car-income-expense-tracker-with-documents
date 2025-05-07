<?php

namespace App\Livewire\Incomes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Income;
use App\Models\Car;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCar = '';
    public $dateFilter = 'this_month';
    public $perPage = 25;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCar' => ['except' => ''],
        'dateFilter' => ['except' => 'this_month'],
        'perPage' => ['except' => 25],
    ];

    public function mount()
    {
        // Default date filter is already set
    }

    public function resetFilters()
    {
        $this->reset(['search', 'selectedCar', 'dateFilter', 'perPage']);
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getDateRange()
    {
        $now = now();

        return match ($this->dateFilter) {
            'today' => [
                $now->startOfDay(),
                $now->clone()->endOfDay()
            ],
            'this_week' => [
                $now->startOfWeek(),
                $now->clone()->endOfWeek()
            ],
            'last_week' => [
                $now->subWeek()->startOfWeek(),
                $now->subWeek()->endOfWeek()
            ],
            'this_month' => [
                $now->startOfMonth(),
                $now->clone()->endOfMonth()
            ],
            'last_month' => [
                $now->subMonth()->startOfMonth(),
                $now->subMonth()->endOfMonth()
            ],
            'last_3_months' => [
                $now->subMonths(3)->startOfMonth(),
                $now->clone()->endOfMonth()
            ],
            'this_year' => [
                $now->startOfYear(),
                $now->clone()->endOfYear()
            ],
            'last_year' => [
                $now->subYear()->startOfYear(),
                $now->subYear()->endOfYear()
            ],
            'all_time' => [
                now()->subYears(50), // Effectively "all time"
                now()
            ],
            default => [
                $now->startOfMonth(),
                $now->clone()->endOfMonth()
            ]
        };
    }

    public function delete(Income $income)
    {
        $income->delete();
        session()->flash('message', 'Income deleted successfully.');
    }

    public function render()
    {
        [$startDate, $endDate] = $this->getDateRange();

        $query = Income::query()
            ->with('car')
            ->when($this->search, function ($query) {
                $query->where('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedCar, function ($query) {
                $query->where('car_id', $this->selectedCar);
            })
            ->whereBetween('date', [$startDate, $endDate])
            ->latest();

        $totalAmount = $query->sum('amount');

        $dateRangeText = match ($this->dateFilter) {
            'today' => 'Today',
            'this_week' => 'This Week',
            'last_week' => 'Last Week',
            'this_month' => 'This Month',
            'last_month' => 'Last Month',
            'last_3_months' => 'Last 3 Months',
            'this_year' => 'This Year',
            'last_year' => 'Last Year',
            'all_time' => 'All Time',
            default => 'This Month'
        };

        return view('livewire.incomes.index', [
            'incomes' => $query->paginate($this->perPage),
            'cars' => Car::all(),
            'totalAmount' => $totalAmount,
            'dateRangeText' => $dateRangeText
        ])->layout('components.layouts.app');
    }
}
