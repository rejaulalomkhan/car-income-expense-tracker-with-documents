<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\Income;
use App\Models\Expense;
use Carbon\Carbon;

class FinancialReportExport implements FromCollection, WithHeadings, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $carId;

    public function __construct($startDate, $endDate, $carId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->carId = $carId;
    }

    public function collection()
    {
        $incomes = Income::query()
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->when($this->carId, function ($query) {
                return $query->where('car_id', $this->carId);
            })
            ->get()
            ->map(function ($income) {
                return [
                    'Date' => Carbon::parse($income->date)->format('Y-m-d'),
                    'Type' => 'Income',
                    'Amount' => $income->amount,
                    'Description' => $income->description,
                    'Car' => $income->car->name,
                ];
            });

        $expenses = Expense::query()
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->when($this->carId, function ($query) {
                return $query->where('car_id', $this->carId);
            })
            ->get()
            ->map(function ($expense) {
                return [
                    'Date' => Carbon::parse($expense->date)->format('Y-m-d'),
                    'Type' => 'Expense',
                    'Amount' => -$expense->amount,
                    'Description' => $expense->description,
                    'Car' => $expense->car->name,
                ];
            });

        return $incomes->concat($expenses)->sortBy('Date');
    }

    public function headings(): array
    {
        return [
            'Date',
            'Type',
            'Amount',
            'Description',
            'Car',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
} 