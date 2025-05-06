<?php

namespace App\Livewire\Documents\Company;

use App\Models\CompanyDocument;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Index extends Component
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
    public $document_type_id = '';
    public $title = '';
    public $issue_date = '';
    public $expiry_date = '';
    public $description = '';
    public $document_file;
    public $is_active = true;

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
        'expiry_status' => ['except' => ''],
        'sortField' => ['except' => 'expiry_date'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function mount()
    {
        $this->document_type_id = array_key_first(CompanyDocument::DOCUMENT_TYPES);
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
            'document_type_id' => 'required|exists:document_types,id',
            'title' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'required|date|after:issue_date',
            'description' => 'nullable|string',
            'document_file' => 'required|file|max:10240', // 10MB max
            'is_active' => 'boolean',
        ]);

        $filePath = $this->document_file->store('company-documents', 'public');

        CompanyDocument::create([
            'document_type_id' => $this->document_type_id,
            'title' => $this->title,
            'issue_date' => $this->issue_date,
            'expiry_date' => $this->expiry_date,
            'description' => $this->description,
            'document_file' => $filePath,
            'is_active' => $this->is_active,
        ]);

        $this->resetForm();
        $this->showCreateModal = false;
        session()->flash('message', 'Company document created successfully.');
    }

    public function edit(CompanyDocument $document)
    {
        $this->editingDocument = $document;
        $this->document_type_id = $document->document_type_id;
        $this->title = $document->title;
        $this->issue_date = $document->issue_date->format('Y-m-d');
        $this->expiry_date = $document->expiry_date->format('Y-m-d');
        $this->description = $document->description;
        $this->is_active = $document->is_active;
        $this->showEditModal = true;
    }

    public function update()
    {
        $this->validate([
            'document_type_id' => 'required|exists:document_types,id',
            'title' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'required|date|after:issue_date',
            'description' => 'nullable|string',
            'document_file' => 'nullable|file|max:10240', // 10MB max
            'is_active' => 'boolean',
        ]);

        $data = [
            'document_type_id' => $this->document_type_id,
            'title' => $this->title,
            'issue_date' => $this->issue_date,
            'expiry_date' => $this->expiry_date,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];

        if ($this->document_file) {
            if ($this->editingDocument->document_file) {
                Storage::disk('public')->delete($this->editingDocument->document_file);
            }
            $data['document_file'] = $this->document_file->store('company-documents', 'public');
        }

        $this->editingDocument->update($data);

        $this->resetForm();
        $this->showEditModal = false;
        session()->flash('message', 'Company document updated successfully.');
    }

    public function delete(CompanyDocument $document)
    {
        if ($document->document_file) {
            Storage::disk('public')->delete($document->document_file);
        }
        $document->delete();
        session()->flash('message', 'Company document deleted successfully.');
    }

    public function resetForm()
    {
        $this->reset([
            'document_type_id',
            'title',
            'issue_date',
            'expiry_date',
            'description',
            'document_file',
            'is_active',
        ]);
        $this->editingDocument = null;
    }

    public function render()
    {
        $query = CompanyDocument::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->type, function ($query) {
                $query->where('document_type_id', $this->type);
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

        return view('livewire.documents.company.index', [
            'documents' => $query->paginate(10),
            'documentTypes' => CompanyDocument::DOCUMENT_TYPES,
        ]);
    }
} 