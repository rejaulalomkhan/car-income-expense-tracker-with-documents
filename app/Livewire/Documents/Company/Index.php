<?php

namespace App\Livewire\Documents\Company;

use App\Models\CompanyDocument;
use App\Models\DocumentType;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $type = '';
    public $expiry_status = '';
    public $sortField = 'expiry_date';
    public $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
        'expiry_status' => ['except' => ''],
        'sortField' => ['except' => 'expiry_date'],
        'sortDirection' => ['except' => 'asc'],
    ];

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

    public function delete(CompanyDocument $document)
    {
        if ($document->document_file) {
            Storage::disk('public')->delete($document->document_file);
        }
        $document->delete();
        session()->flash('message', 'Company document deleted successfully.');
    }

    public function render()
    {
        $query = CompanyDocument::with('documentType')
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
            'documentTypes' => DocumentType::where('is_active', true)->get()->pluck('name', 'id'),
        ]);
    }
}
