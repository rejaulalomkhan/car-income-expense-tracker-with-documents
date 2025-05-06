<?php

namespace App\Livewire;

use App\Models\Car;
use App\Models\Income;
use App\Models\Expense;
use Livewire\Component;
use Carbon\Carbon;

class FinancialDashboard extends Component
{
    public $selectedMonth;
    public $startDate;
    public $endDate;
    public $filterType = 'month'; // 'month' or 'date_range'
    public $cars;

    public function mount()
    {
        $this->selectedMonth = now()->format('Y-m');
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
        $this->cars = Car::all();
    }

    public function updatedSelectedMonth()
    {
        $this->startDate = Carbon::parse($this->selectedMonth)->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::parse($this->selectedMonth)->endOfMonth()->format('Y-m-d');
    }

    public function getIncomes()
    {
        return Income::whereBetween('date', [$this->startDate, $this->endDate])
            ->get()
            ->groupBy('car_id');
    }

    public function getExpenses()
    {
        return Expense::whereBetween('date', [$this->startDate, $this->endDate])
            ->get()
            ->groupBy('car_id');
    }

    public function getTotalIncome($carId)
    {
        return $this->getIncomes()->get($carId, collect())->sum('amount');
    }

    public function getTotalExpense($carId)
    {
        return $this->getExpenses()->get($carId, collect())->sum('amount');
    }

    public function getGrandTotalIncome()
    {
        return $this->getIncomes()->flatten()->sum('amount');
    }

    public function getGrandTotalExpense()
    {
        return $this->getExpenses()->flatten()->sum('amount');
    }

    public function render()
    {
        return view('livewire.financial-dashboard', [
            'incomes' => $this->getIncomes(),
            'expenses' => $this->getExpenses(),
            'totalIncome' => $this->getGrandTotalIncome(),
            'totalExpense' => $this->getGrandTotalExpense(),
        ]);
    }
} 