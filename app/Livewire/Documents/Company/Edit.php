<?php

namespace App\Livewire\Documents\Company;

use App\Models\CompanyDocument;
use App\Models\DocumentType;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public CompanyDocument $document;
    public $document_type_id = '';
    public $title = '';
    public $issue_date = '';
    public $expiry_date = '';
    public $description = '';
    public $document_file;
    public $is_active = true;

    public function mount(CompanyDocument $document)
    {
        $this->document = $document;
        $this->document_type_id = $document->document_type_id;
        $this->title = $document->title;
        $this->issue_date = $document->issue_date->format('Y-m-d');
        $this->expiry_date = $document->expiry_date->format('Y-m-d');
        $this->description = $document->description;
        $this->is_active = $document->is_active;
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
            if ($this->document->document_file) {
                Storage::disk('public')->delete($this->document->document_file);
            }
            $data['document_file'] = $this->document_file->store('company-documents', 'public');
        }

        $this->document->update($data);

        session()->flash('message', 'Company document updated successfully.');
        return redirect()->route('documents.company.index');
    }

    public function delete()
    {
        if ($this->document->document_file) {
            Storage::disk('public')->delete($this->document->document_file);
        }
        $this->document->delete();

        session()->flash('message', 'Company document deleted successfully.');
        return redirect()->route('documents.company.index');
    }

    public function render()
    {
        return view('livewire.documents.company.edit', [
            'documentTypes' => DocumentType::where('is_active', true)->get()->pluck('name', 'id'),
        ]);
    }
}
