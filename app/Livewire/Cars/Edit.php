<?php

namespace App\Livewire\Cars;

use Livewire\Component;
use App\Models\Car;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Lazy;

#[Lazy]
class Edit extends Component
{
    use WithFileUploads;

    public $car;

    #[Rule('required|string|max:255')]
    public $name;

    #[Rule('required|string|max:20')]
    public $plate_number;

    #[Rule('nullable|string|max:255')]
    public $model;

    #[Rule('nullable|integer|min:1900|max:2026')]
    public $year;

    #[Rule('nullable|string|max:50')]
    public $color;

    public $photo;

    #[Rule('nullable|image|max:1024')]
    public $new_photo;

    public function mount(Car $car)
    {
        $this->car = $car;
        $this->name = $car->name;
        $this->plate_number = $car->plate_number;
        $this->model = $car->model;
        $this->year = $car->year;
        $this->color = $car->color;
        $this->photo = $car->photo;
    }

    public function save()
    {
        try {
            $validatedData = $this->validate();

            $this->car->name = $this->name;
            $this->car->plate_number = $this->plate_number;
            $this->car->model = $this->model;
            $this->car->year = $this->year;
            $this->car->color = $this->color;

            if ($this->new_photo) {
                if ($this->photo) {
                    Storage::disk('public')->delete($this->photo);
                }
                $this->car->photo = $this->new_photo->store('cars', 'public');
            }

            $this->car->save();

            session()->flash('message', 'Car updated successfully.');
            return $this->redirect(route('cars.index'), navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update car. Please try again.');
            return null;
        }
    }

    public function render()
    {
        return view('livewire.cars.edit')->layout('components.layouts.app');
    }
}
