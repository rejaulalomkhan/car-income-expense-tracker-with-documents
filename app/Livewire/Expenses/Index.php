<?php

namespace App\Livewire\Expenses;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Expense;
use App\Models\Car;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCar = '';
    public $selectedCategory = '';
    public $dateFilter = 'this_month';
    public $perPage = 25;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCar' => ['except' => ''],
        'selectedCategory' => ['except' => ''],
        'dateFilter' => ['except' => 'this_month'],
        'perPage' => ['except' => 25],
    ];

    public function mount()
    {
        // Default date filter is already set
    }

    public function resetFilters()
    {
        $this->reset(['search', 'selectedCar', 'selectedCategory', 'dateFilter', 'perPage']);
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete(Expense $expense)
    {
        $expense->delete();
        session()->flash('message', 'Expense deleted successfully.');
    }

    protected function getDateRange()
    {
        $now = now();

        return match($this->dateFilter) {
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

    public function render()
    {
        [$startDate, $endDate] = $this->getDateRange();

        $query = Expense::query()
            ->with('car')
            ->when($this->search, function ($query) {
                $query->where('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedCar, function ($query) {
                $query->where('car_id', $this->selectedCar);
            })
            ->when($this->selectedCategory, function ($query) {
                $query->where('category_id', $this->selectedCategory);
            })
            ->whereBetween('date', [
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d')
            ]);

        // Calculate total before applying pagination
        $totalAmount = $query->sum('amount');

        // Get paginated results
        $expenses = $query->latest('date')->paginate($this->perPage);

        return view('livewire.expenses.index', [
            'expenses' => $expenses,
            'cars' => Car::all(),
            'dateRangeText' => $this->getDateRangeText($startDate, $endDate),
            'totalAmount' => $totalAmount,
        ]);
    }

    protected function getDateRangeText($startDate, $endDate)
    {
        return match($this->dateFilter) {
            'today' => 'Today',
            'this_week' => 'This Week',
            'last_week' => 'Last Week',
            'this_month' => 'This Month',
            'last_month' => 'Last Month',
            'last_3_months' => 'Last 3 Months',
            'this_year' => 'This Year',
            'last_year' => 'Last Year',
            'all_time' => 'All Time',
            default => $startDate->format('M j, Y') . ' - ' . $endDate->format('M j, Y')
        };
    }
}
