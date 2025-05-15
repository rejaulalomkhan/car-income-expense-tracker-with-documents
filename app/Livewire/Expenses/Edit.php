<?php

namespace App\Livewire\Expenses;

use Livewire\Component;
use App\Models\Expense;
use App\Models\Car;

class Edit extends Component
{
    public $expense;
    public $car_id;
    public $date;
    public $amount;
    public $category;
    public $description;

    // Predefined expense categories
    public $categories = [
        'Maintenance',
        'Fuel',
        'Driver',
        'Fines',
        'Tolls',
        'Garage Rent',
        'Spare Parts',
        'Documents Update'
    ];

    protected function rules()
    {
        return [
            'car_id' => 'required|exists:cars,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ];
    }

    public function mount(Expense $expense)
    {
        $this->expense = $expense;
        $this->car_id = $expense->car_id;
        $this->date = $expense->date->format('Y-m-d');
        $this->amount = $expense->amount;
        $this->category = $expense->category;
        $this->description = $expense->description;
    }

    public function save()
    {
        $this->validate();

        $this->expense->update([
            'car_id' => $this->car_id,
            'date' => $this->date,
            'amount' => $this->amount,
            'category' => $this->category,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Expense updated successfully.');
        return redirect()->route('expenses.index');
    }

    public function render()
    {
        return view('livewire.expenses.edit', [
            'cars' => Car::all(),
        ]);
    }
}
