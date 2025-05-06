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
    public $startDate = '';
    public $endDate = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCar' => ['except' => ''],
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
    ];

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
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
            ->when($this->startDate, function ($query) {
                $query->whereDate('date', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                $query->whereDate('date', '<=', $this->endDate);
            })
            ->latest();

        return view('livewire.expenses.index', [
            'expenses' => $query->paginate(10),
            'cars' => Car::all(),
        ])->layout('components.layouts.app');
    }
} 