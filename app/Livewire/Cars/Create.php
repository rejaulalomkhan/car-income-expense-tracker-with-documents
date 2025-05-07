<?php

namespace App\Livewire\Cars;

use Livewire\Component;
use App\Models\Car;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Lazy;

#[Lazy]
class Create extends Component
{
    use WithFileUploads;

    #[Rule('required|string|max:255')]
    public $name = '';

    #[Rule('required|string|max:20|unique:cars')]
    public $plate_number = '';

    #[Rule('nullable|string|max:255')]
    public $model = '';

    #[Rule('nullable|integer|min:1900|max:2026')]
    public $year;

    #[Rule('nullable|string|max:50')]
    public $color = '';

    #[Rule('nullable|image|max:1024')]
    public $photo;

    public function save()
    {
        try {
            $validatedData = $this->validate();

            $car = new Car();
            $car->name = $this->name;
            $car->plate_number = $this->plate_number;
            $car->model = $this->model;
            $car->year = $this->year;
            $car->color = $this->color;

            if ($this->photo) {
                $car->photo = $this->photo->store('cars', 'public');
            }

            $car->save();

            session()->flash('message', 'Car created successfully.');
            return $this->redirect(route('cars.index'), navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create car. Please try again.');
            return null;
        }
    }

    public function render()
    {
        return view('livewire.cars.create')->layout('components.layouts.app');
    }
}
