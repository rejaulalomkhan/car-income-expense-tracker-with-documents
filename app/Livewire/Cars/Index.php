<?php

namespace App\Livewire\Cars;

use Livewire\Component;
use App\Models\Car;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class Index extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $sortField = 'created_at';

    #[Url(history: true)]
    public $sortDirection = 'desc';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function delete($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();

        session()->flash('message', 'Car deleted successfully');
    }

    public function render()
    {
        return view('livewire.cars.index', [
            'cars' => Car::query()
                ->when($this->search, function ($query) {
                    $query->where(function($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('plate_number', 'like', '%' . $this->search . '%')
                          ->orWhere('model', 'like', '%' . $this->search . '%')
                          ->orWhere('color', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10)
        ])->layout('components.layouts.app');
    }
}
