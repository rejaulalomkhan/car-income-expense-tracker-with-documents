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
                $now->copy()->startOfDay(),
                $now->copy()->endOfDay()
            ],
            'this_week' => [
                $now->copy()->startOfWeek(),
                $now->copy()->endOfWeek()
            ],
            'last_week' => [
                $now->copy()->subWeek()->startOfWeek(),
                $now->copy()->subWeek()->endOfWeek()
            ],
            'this_month' => [
                $now->copy()->startOfMonth(),
                $now->copy()->endOfMonth()
            ],
            'last_month' => [
                $now->copy()->subMonth()->startOfMonth(),
                $now->copy()->subMonth()->endOfMonth()
            ],
            'last_3_months' => [
                $now->copy()->subMonths(3)->startOfMonth(),
                $now->copy()->endOfMonth()
            ],
            'this_year' => [
                $now->copy()->startOfYear(),
                $now->copy()->endOfYear()
            ],
            'last_year' => [
                // Create two separate Carbon instances to avoid modifying the same object
                now()->subYear()->startOfYear(),
                now()->subYear()->endOfYear()
            ],
            'all_time' => [
                now()->subYears(50), // Effectively "all time"
                now()
            ],
            default => [
                $now->copy()->startOfMonth(),
                $now->copy()->endOfMonth()
            ]
        };
    }

    public function delete(Income $income)
    {
        try {
            $income->delete();
            $this->dispatch('income-deleted');
            session()->flash('message', 'Income deleted successfully.');
            $this->render();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete income: ' . $e->getMessage());
        }
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
