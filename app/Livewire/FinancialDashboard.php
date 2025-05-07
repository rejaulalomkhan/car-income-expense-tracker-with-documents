<?php

namespace App\Livewire;

use App\Models\Car;
use App\Models\Income;
use App\Models\Expense;
use Livewire\Component;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FinancialReportExport;

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

    public function previousPeriod()
    {
        if ($this->filterType === 'month') {
            // Move to previous month
            $this->selectedMonth = Carbon::parse($this->selectedMonth)->subMonth()->format('Y-m');
            $this->updatedSelectedMonth();
        } else {
            // For date range, calculate the period length and subtract it
            $start = Carbon::parse($this->startDate);
            $end = Carbon::parse($this->endDate);
            $periodDays = $start->diffInDays($end) + 1;

            $this->endDate = $start->subDay()->format('Y-m-d');
            $this->startDate = $start->subDays($periodDays - 1)->format('Y-m-d');
        }
    }

    public function nextPeriod()
    {
        if ($this->filterType === 'month') {
            // Move to next month
            $this->selectedMonth = Carbon::parse($this->selectedMonth)->addMonth()->format('Y-m');
            $this->updatedSelectedMonth();
        } else {
            // For date range, calculate the period length and add it
            $start = Carbon::parse($this->startDate);
            $end = Carbon::parse($this->endDate);
            $periodDays = $start->diffInDays($end) + 1;

            $this->startDate = $end->addDay()->format('Y-m-d');
            $this->endDate = $end->addDays($periodDays - 1)->format('Y-m-d');
        }
    }

    public function continueToIterate()
    {
        $this->nextPeriod();
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

    public function exportIncome()
    {
        $incomes = $this->getIncomes();
        $fileName = 'income-report-' . now()->format('Y-m-d') . '.xlsx';
        return Excel::download(new FinancialReportExport($this->startDate, $this->endDate, 'income'), $fileName);
    }

    public function exportExpense()
    {
        $expenses = $this->getExpenses();
        $fileName = 'expense-report-' . now()->format('Y-m-d') . '.xlsx';
        return Excel::download(new FinancialReportExport($this->startDate, $this->endDate, 'expense'), $fileName);
    }

    public function exportFullReport()
    {
        $fileName = 'financial-report-' . now()->format('Y-m-d') . '.xlsx';
        return Excel::download(new FinancialReportExport($this->startDate, $this->endDate, 'all'), $fileName);
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
