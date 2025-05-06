<?php

namespace App\Livewire\Documents\Car;

use App\Models\CarDocument;
use App\Models\Car;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Url;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $type = '';

    #[Url(history: true)]
    public $expiry_status = '';

    #[Url(history: true)]
    public $sortField = 'document_expiry_date';

    #[Url(history: true)]
    public $sortDirection = 'asc';

    public $showFilters = false;
    public $showCreateModal = false;
    public $showEditModal = false;
    public $editingDocument = null;

    // Form properties
    #[Rule('required|exists:cars,id')]
    public $car_id = '';

    #[Rule('required|string')]
    public $document_type = '';

    #[Rule('required|date')]
    public $document_expiry_date = '';

    #[Rule('nullable|string')]
    public $document_comment = '';

    #[Rule('nullable|file|max:10240')]
    public $document_image;

    public function mount()
    {
        $this->document_type = array_key_first(CarDocument::DOCUMENT_TYPES);
    }

    public function updated($property)
    {
        if ($property === 'search' || $property === 'type' || $property === 'expiry_status') {
            $this->resetPage();
        }
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

    public function create()
    {
        $this->validate([
            'car_id' => 'required|exists:cars,id',
            'document_type' => 'required|string|in:' . implode(',', array_keys(CarDocument::DOCUMENT_TYPES)),
            'document_expiry_date' => 'required|date',
            'document_comment' => 'nullable|string',
            'document_image' => 'required|file|max:10240', // 10MB max
        ]);

        $imagePath = $this->document_image->store('documents', 'public');

        CarDocument::create([
            'car_id' => $this->car_id,
            'document_type' => $this->document_type,
            'document_expiry_date' => $this->document_expiry_date,
            'document_comment' => $this->document_comment,
            'document_image' => $imagePath,
        ]);

        $this->resetForm();
        $this->showCreateModal = false;
        session()->flash('message', 'Car document created successfully.');
    }

    public function edit($documentId)
    {
        $document = CarDocument::findOrFail($documentId);
        $this->editingDocument = $document;
        $this->car_id = $document->car_id;
        $this->document_type = $document->document_type;
        $this->document_expiry_date = $document->document_expiry_date->format('Y-m-d');
        $this->document_comment = $document->document_comment;
        $this->showEditModal = true;
    }

    public function update()
    {
        $this->validate([
            'car_id' => 'required|exists:cars,id',
            'document_type' => 'required|string|in:' . implode(',', array_keys(CarDocument::DOCUMENT_TYPES)),
            'document_expiry_date' => 'required|date',
            'document_comment' => 'nullable|string',
            'document_image' => 'nullable|file|max:10240', // 10MB max
        ]);

        $data = [
            'car_id' => $this->car_id,
            'document_type' => $this->document_type,
            'document_expiry_date' => $this->document_expiry_date,
            'document_comment' => $this->document_comment,
        ];

        if ($this->document_image) {
            if ($this->editingDocument->document_image && Storage::disk('public')->exists($this->editingDocument->document_image)) {
                Storage::disk('public')->delete($this->editingDocument->document_image);
            }
            $data['document_image'] = $this->document_image->store('documents', 'public');
        }

        $this->editingDocument->update($data);

        $this->resetForm();
        $this->showEditModal = false;
        session()->flash('message', 'Car document updated successfully.');
    }

    public function delete(CarDocument $document)
    {
        if ($document->document_image && Storage::disk('public')->exists($document->document_image)) {
            Storage::disk('public')->delete($document->document_image);
        }
        $document->delete();
        session()->flash('message', 'Car document deleted successfully.');
    }

    public function resetForm()
    {
        $this->reset([
            'car_id',
            'document_type',
            'document_expiry_date',
            'document_comment',
            'document_image',
        ]);
        $this->editingDocument = null;
    }

    public function render()
    {
        $query = CarDocument::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('car', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('plate_number', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('document_comment', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->type, function ($query) {
                $query->where('document_type', $this->type);
            })
            ->when($this->expiry_status, function ($query) {
                if ($this->expiry_status === 'expired') {
                    $query->where('document_expiry_date', '<', now());
                } elseif ($this->expiry_status === 'expiring_soon') {
                    $query->whereBetween('document_expiry_date', [now(), now()->addDays(30)]);
                } elseif ($this->expiry_status === 'valid') {
                    $query->where('document_expiry_date', '>', now()->addDays(30));
                }
            })
            ->orderBy($this->sortField, $this->sortDirection);

        return view('livewire.documents.car.index', [
            'documents' => $query->paginate(10),
            'cars' => Car::all(),
            'documentTypes' => CarDocument::DOCUMENT_TYPES,
        ]);
    }
}
