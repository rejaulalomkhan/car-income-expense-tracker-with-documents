<?php

namespace App\Livewire\Documents;

use App\Models\Document;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CompanyDocuments extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $type = '';
    public $expiry_status = '';
    public $sortField = 'expiry_date';
    public $sortDirection = 'asc';
    public $showFilters = false;
    public $showCreateModal = false;
    public $showEditModal = false;
    public $editingDocument = null;

    // Form properties
    public $name = '';
    public $document_type = '';
    public $expiry_date = '';
    public $description = '';
    public $file;

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
        'expiry_status' => ['except' => ''],
        'sortField' => ['except' => 'expiry_date'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function mount()
    {
        $this->document_type = array_key_first(Document::COMPANY_DOCUMENT_TYPES);
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
            'name' => 'required|string|max:255',
            'document_type' => 'required|string|in:' . implode(',', array_keys(Document::COMPANY_DOCUMENT_TYPES)),
            'expiry_date' => 'required|date',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        $filePath = $this->file->store('documents', 'public');

        Document::create([
            'category' => 'company',
            'name' => $this->name,
            'type' => $this->document_type,
            'expiry_date' => $this->expiry_date,
            'description' => $this->description,
            'file_path' => $filePath,
        ]);

        $this->resetForm();
        $this->showCreateModal = false;
        session()->flash('message', 'Company document created successfully.');
    }

    public function edit(Document $document)
    {
        $this->editingDocument = $document;
        $this->name = $document->name;
        $this->document_type = $document->type;
        $this->expiry_date = $document->expiry_date->format('Y-m-d');
        $this->description = $document->description;
        $this->showEditModal = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'document_type' => 'required|string|in:' . implode(',', array_keys(Document::COMPANY_DOCUMENT_TYPES)),
            'expiry_date' => 'required|date',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240', // 10MB max
        ]);

        $data = [
            'name' => $this->name,
            'type' => $this->document_type,
            'expiry_date' => $this->expiry_date,
            'description' => $this->description,
        ];

        if ($this->file) {
            if ($this->editingDocument->file_path) {
                Storage::disk('public')->delete($this->editingDocument->file_path);
            }
            $data['file_path'] = $this->file->store('documents', 'public');
        }

        $this->editingDocument->update($data);

        $this->resetForm();
        $this->showEditModal = false;
        session()->flash('message', 'Company document updated successfully.');
    }

    public function delete(Document $document)
    {
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();
        session()->flash('message', 'Company document deleted successfully.');
    }

    public function resetForm()
    {
        $this->reset([
            'name',
            'document_type',
            'expiry_date',
            'description',
            'file',
        ]);
    }

    public function render()
    {
        $query = Document::where('category', 'company')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->type, function ($query) {
                $query->where('type', $this->type);
            })
            ->when($this->expiry_status, function ($query) {
                if ($this->expiry_status === 'expired') {
                    $query->where('expiry_date', '<', now());
                } elseif ($this->expiry_status === 'expiring_soon') {
                    $query->whereBetween('expiry_date', [now(), now()->addDays(30)]);
                } elseif ($this->expiry_status === 'valid') {
                    $query->where('expiry_date', '>', now()->addDays(30));
                }
            })
            ->orderBy($this->sortField, $this->sortDirection);

        return view('livewire.documents.company-documents', [
            'documents' => $query->paginate(10),
            'documentTypes' => Document::COMPANY_DOCUMENT_TYPES,
        ]);
    }
} 