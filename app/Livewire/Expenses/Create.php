<?php

namespace App\Livewire\Expenses;

use Livewire\Component;
use App\Models\Expense;
use App\Models\Car;

class Create extends Component
{
    public $car_id = '';
    public $date;
    public $amount;
    public $category = 'Rent';
    public $description = '';

    // Predefined expense categories
    public $categories = [
        'Maintenance',
        'Fuel',
        'Driver',
        'Fines',
        'Tolls',
        'Rent',
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

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
    }

    public function save()
    {
        try {
            $validatedData = $this->validate();

            Expense::create([
                'car_id' => $this->car_id,
                'date' => $this->date,
                'amount' => $this->amount,
                'category' => $this->category,
                'description' => $this->description,
            ]);

            session()->flash('message', 'Expense created successfully.');
            return redirect()->route('expenses.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create expense. Please try again.');
            return null;
        }
    }

    public function render()
    {
        return view('livewire.expenses.create', [
            'cars' => Car::all(),
        ]);
    }
}
