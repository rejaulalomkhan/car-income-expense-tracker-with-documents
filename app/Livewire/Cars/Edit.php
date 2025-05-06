<?php

namespace App\Livewire\Cars;

use Livewire\Component;
use App\Models\Car;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;

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
        // Add plate_number unique rule with exception for the current car
        $this->validate([
            'name' => 'required|string|max:255',
            'plate_number' => 'required|string|max:20|unique:cars,plate_number,' . $this->car->id,
            'model' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'nullable|string|max:50',
            'new_photo' => 'nullable|image|max:1024',
        ]);

        if ($this->new_photo) {
            if ($this->photo && Storage::disk('public')->exists($this->photo)) {
                Storage::disk('public')->delete($this->photo);
            }
            $this->photo = $this->new_photo->store('cars', 'public');
        }

        $this->car->update([
            'name' => $this->name,
            'plate_number' => $this->plate_number,
            'model' => $this->model,
            'year' => $this->year,
            'color' => $this->color,
            'photo' => $this->photo,
        ]);

        session()->flash('message', 'Car updated successfully.');
        return redirect()->route('cars.index');
    }

    public function render()
    {
        return view('livewire.cars.edit');
    }
}
