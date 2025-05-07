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
    public $startDate = '';
    public $endDate = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCar' => ['except' => ''],
        'selectedCategory' => ['except' => ''],
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
    ];

    public function mount()
    {
        // Initialize with empty date range to show all records by default
        // Only set date range if it's not already set (from query parameters)
        if (empty($this->startDate) && empty($this->endDate)) {
            $this->startDate = now()->subMonths(3)->format('Y-m-d'); // Show last 3 months by default
            $this->endDate = now()->format('Y-m-d');
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'selectedCar', 'selectedCategory', 'startDate', 'endDate']);
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

    public function render()
    {
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
            ->when($this->startDate, function ($query) {
                $query->whereDate('date', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                $query->whereDate('date', '<=', $this->endDate);
            })
            ->latest('date'); // Order by date instead of created_at

        $expenses = $query->paginate(10);

        return view('livewire.expenses.index', [
            'expenses' => $expenses,
            'cars' => Car::all(),
        ]);
    }
}
