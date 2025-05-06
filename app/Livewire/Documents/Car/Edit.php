<?php

namespace App\Livewire\Documents\Car;

use App\Models\CarDocument;
use App\Models\Car;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public CarDocument $document;
    public $car_id = '';
    public $document_type = '';
    public $document_expiry_date = '';
    public $document_image;
    public $document_comment = '';

    public function mount(CarDocument $document)
    {
        $this->document = $document;
        $this->car_id = $document->car_id;
        $this->document_type = $document->document_type;
        $this->document_expiry_date = $document->document_expiry_date->format('Y-m-d');
        $this->document_comment = $document->document_comment;
    }

    public function update()
    {
        $this->validate([
            'car_id' => 'required|exists:cars,id',
            'document_type' => 'required|in:' . implode(',', array_keys(CarDocument::DOCUMENT_TYPES)),
            'document_expiry_date' => 'required|date',
            'document_image' => 'nullable|file|max:10240', // 10MB max
            'document_comment' => 'nullable|string|max:255',
        ]);

        $data = [
            'car_id' => $this->car_id,
            'document_type' => $this->document_type,
            'document_expiry_date' => $this->document_expiry_date,
            'document_comment' => $this->document_comment,
        ];

        if ($this->document_image) {
            if ($this->document->document_image) {
                Storage::disk('public')->delete($this->document->document_image);
            }
            $data['document_image'] = $this->document_image->store('car-documents', 'public');
        }

        $this->document->update($data);

        session()->flash('message', 'Car document updated successfully.');
        return redirect()->route('documents.car.index');
    }

    public function delete()
    {
        if ($this->document->document_image) {
            Storage::disk('public')->delete($this->document->document_image);
        }
        $this->document->delete();
        
        session()->flash('message', 'Car document deleted successfully.');
        return redirect()->route('documents.car.index');
    }

    public function render()
    {
        return view('livewire.documents.car.edit', [
            'cars' => Car::all(),
            'documentTypes' => CarDocument::DOCUMENT_TYPES,
        ]);
    }
} 