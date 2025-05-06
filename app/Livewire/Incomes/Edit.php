<?php

namespace App\Livewire\Incomes;

use Livewire\Component;
use App\Models\Income;
use App\Models\Car;

class Edit extends Component
{
    public $income;
    public $car_id;
    public $date;
    public $amount;
    public $source;
    public $description;

    protected function rules()
    {
        return [
            'car_id' => 'required|exists:cars,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'source' => 'required|string|max:100',
            'description' => 'required|string|max:255',
        ];
    }

    public function mount(Income $income)
    {
        $this->income = $income;
        $this->car_id = $income->car_id;
        $this->date = $income->date->format('Y-m-d');
        $this->amount = $income->amount;
        $this->source = $income->source;
        $this->description = $income->description;
    }

    public function save()
    {
        $this->validate();

        $this->income->update([
            'car_id' => $this->car_id,
            'date' => $this->date,
            'amount' => $this->amount,
            'source' => $this->source,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Income updated successfully.');
        return redirect()->route('incomes.index');
    }

    public function render()
    {
        return view('livewire.incomes.edit', [
            'cars' => Car::all(),
        ])->layout('components.layouts.app');
    }
}
