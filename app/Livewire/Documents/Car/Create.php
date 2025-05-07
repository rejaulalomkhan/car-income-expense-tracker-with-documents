<?php

namespace App\Livewire\Documents\Car;

use App\Models\CarDocument;
use App\Models\Car;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use WithFileUploads;

    public $car_id = '';
    public $document_type = '';
    public $document_expiry_date = '';
    public $document_image;
    public $document_comment = '';

    public function mount()
    {
        $this->document_type = array_key_first(CarDocument::DOCUMENT_TYPES);
        $this->document_expiry_date = now()->format('Y-m-d');
    }

    public function save()
    {
        try {
            $validatedData = $this->validate([
                'car_id' => 'required|exists:cars,id',
                'document_type' => 'required|in:' . implode(',', array_keys(CarDocument::DOCUMENT_TYPES)),
                'document_expiry_date' => 'required|date',
                'document_image' => 'required|file|max:10240', // 10MB max
                'document_comment' => 'nullable|string|max:255',
            ]);

            if (!$this->document_image) {
                session()->flash('error', 'Document image is required.');
                return null;
            }

            $filePath = $this->document_image->store('car-documents', 'public');

            CarDocument::create([
                'car_id' => $this->car_id,
                'document_type' => $this->document_type,
                'document_expiry_date' => $this->document_expiry_date,
                'document_image' => $filePath,
                'document_comment' => $this->document_comment,
            ]);

            session()->flash('message', 'Car document created successfully.');
            return redirect()->route('documents.car.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create document. Please try again.');
            return null;
        }
    }

    public function render()
    {
        return view('livewire.documents.car.create', [
            'cars' => Car::all(),
            'documentTypes' => CarDocument::DOCUMENT_TYPES,
        ]);
    }
}
