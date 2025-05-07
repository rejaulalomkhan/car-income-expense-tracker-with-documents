<?php

namespace App\Livewire\Documents\Company;

use App\Models\CompanyDocument;
use App\Models\DocumentType;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use WithFileUploads;

    public $document_type_id = '';
    public $title = '';
    public $issue_date = '';
    public $expiry_date = '';
    public $description = '';
    public $document_file;
    public $is_active = true;

    public function mount()
    {
        $firstDocType = DocumentType::where('is_active', true)->first();
        $this->document_type_id = $firstDocType ? $firstDocType->id : null;
        $this->issue_date = now()->format('Y-m-d');
    }

    public function save()
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

        session()->flash('message', 'Company document created successfully.');
        return redirect()->route('documents.company.index');
    }

    public function render()
    {
        return view('livewire.documents.company.create', [
            'documentTypes' => DocumentType::where('is_active', true)->get()->pluck('name', 'id'),
        ]);
    }
}
