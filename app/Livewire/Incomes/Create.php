<?php

namespace App\Livewire\Incomes;

use Livewire\Component;
use App\Models\Income;
use App\Models\Car;

class Create extends Component
{
    public $car_id = '';
    public $date;
    public $amount;
    public $source = 'Rent';
    public $description = '';

    protected function rules()
    {
        return [
            'car_id' => 'required|exists:cars,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'source' => 'required|string|max:100',
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

            Income::create([
                'car_id' => $this->car_id,
                'date' => $this->date,
                'amount' => $this->amount,
                'source' => $this->source,
                'description' => $this->description,
            ]);

            session()->flash('message', 'Income created successfully.');
            return redirect()->route('incomes.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create income. Please try again.');
            return null;
        }
    }

    public function render()
    {
        return view('livewire.incomes.create', [
            'cars' => Car::all(),
        ])->layout('components.layouts.app');
    }
}
