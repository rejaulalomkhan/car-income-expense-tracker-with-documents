<?php

namespace App\Livewire\Documents;

use App\Models\Car;
use App\Models\Document;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $car_id = '';
    public $name = '';
    public $category = 'car';
    public $type = '';
    public $expiry_date = '';
    public $description = '';
    public $file;

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'category' => 'required|in:car,company',
            'type' => 'required|string',
            'expiry_date' => 'required|date',
            'file' => 'required|file|max:10240', // 10MB max
            'description' => 'nullable|string|max:1000',
        ];

        if ($this->category === 'car') {
            $rules['car_id'] = 'required|exists:cars,id';
            $rules['type'] .= '|in:' . implode(',', array_keys(Document::CAR_DOCUMENT_TYPES));
        } else {
            $rules['type'] .= '|in:' . implode(',', array_keys(Document::COMPANY_DOCUMENT_TYPES));
        }

        return $rules;
    }

    public function save()
    {
        $this->validate();

        $filePath = $this->file->store('documents', 'public');

        Document::create([
            'car_id' => $this->category === 'car' ? $this->car_id : null,
            'name' => $this->name,
            'category' => $this->category,
            'type' => $this->type,
            'expiry_date' => $this->expiry_date,
            'file_path' => $filePath,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Document created successfully.');
        return redirect()->route('documents.index');
    }

    public function updatedCategory()
    {
        $this->type = '';
        $this->car_id = '';
    }

    public function render()
    {
        return view('livewire.documents.create', [
            'cars' => Car::orderBy('name')->get(),
            'documentTypes' => $this->category === 'car' 
                ? Document::CAR_DOCUMENT_TYPES 
                : Document::COMPANY_DOCUMENT_TYPES,
        ]);
    }
} 