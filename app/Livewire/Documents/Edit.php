<?php

namespace App\Livewire\Documents;

use App\Models\Document;
use App\Models\Car;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public Document $document;
    public $category;
    public $car_id;
    public $type;
    public $name;
    public $expiry_date;
    public $description;
    public $file;
    public $documentTypes = [];

    public function mount(Document $document)
    {
        $this->document = $document;
        $this->category = $document->category;
        $this->car_id = $document->car_id;
        $this->type = $document->type;
        $this->name = $document->name;
        $this->expiry_date = $document->expiry_date->format('Y-m-d');
        $this->description = $document->description;
        $this->documentTypes = Document::getDocumentTypes($this->category);
    }

    public function updatedCategory()
    {
        $this->reset('type');
        $this->documentTypes = Document::getDocumentTypes($this->category);
    }

    public function rules()
    {
        return [
            'category' => 'required|in:car,company',
            'car_id' => 'required_if:category,car|exists:cars,id',
            'type' => 'required|string',
            'name' => 'required|string|max:255',
            'expiry_date' => 'required|date',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240', // 10MB max
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'category' => $this->category,
            'type' => $this->type,
            'name' => $this->name,
            'expiry_date' => $this->expiry_date,
            'description' => $this->description,
        ];

        if ($this->category === 'car') {
            $data['car_id'] = $this->car_id;
        } else {
            $data['car_id'] = null;
        }

        if ($this->file) {
            if ($this->document->file_path) {
                Storage::delete($this->document->file_path);
            }
            $data['file_path'] = $this->file->store('documents');
        }

        $this->document->update($data);

        session()->flash('message', 'Document updated successfully.');

        return redirect()->route('documents.index');
    }

    public function render()
    {
        return view('livewire.documents.edit', [
            'cars' => Car::orderBy('name')->get(),
        ]);
    }
} 