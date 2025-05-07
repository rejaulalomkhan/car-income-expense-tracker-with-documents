<?php

namespace App\Exports;

use App\Models\Income;
use App\Models\Expense;
use App\Models\Car;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class FinancialReportExport implements FromCollection, WithHeadings, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $type;

    public function __construct($startDate, $endDate, $type = 'all')
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->type = $type;
    }

    public function collection()
    {
        $cars = Car::all();
        $data = new Collection();

        if ($this->type === 'income' || $this->type === 'all') {
            $incomes = Income::with('car')
                ->whereBetween('date', [$this->startDate, $this->endDate])
                ->get()
                ->groupBy('date');

            foreach ($incomes as $date => $dayIncomes) {
                $row = [
                    'Date' => date('d/m/Y', strtotime($date)),
                    'Type' => 'Income',
                ];

                foreach ($cars as $car) {
                    $amount = $dayIncomes->where('car_id', $car->id)->sum('amount');
                    $row[$car->name] = $amount;
                }

                $row['Total'] = $dayIncomes->sum('amount');
                $data->push($row);
            }
        }

        if ($this->type === 'expense' || $this->type === 'all') {
            $expenses = Expense::with('car')
                ->whereBetween('date', [$this->startDate, $this->endDate])
                ->get()
                ->groupBy('date');

            foreach ($expenses as $date => $dayExpenses) {
                $row = [
                    'Date' => date('d/m/Y', strtotime($date)),
                    'Type' => 'Expense',
                ];

                foreach ($cars as $car) {
                    $amount = $dayExpenses->where('car_id', $car->id)->sum('amount');
                    $row[$car->name] = $amount;
                }

                $row['Total'] = $dayExpenses->sum('amount');
                $data->push($row);
            }
        }

        return $data;
    }

    public function headings(): array
    {
        $cars = Car::all();
        $headers = ['Date', 'Type'];

        foreach ($cars as $car) {
            $headers[] = $car->name;
        }

        $headers[] = 'Total';
        return $headers;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
