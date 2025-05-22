<?php

namespace App\Livewire\Documents\Personal;

use App\Models\PersonalDocument;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public PersonalDocument $document;
    public $doc_name = '';
    public $doc_category = '';
    public $doc_scancopy;
    public $doc_description = '';

    protected $rules = [
        'doc_name' => 'required|min:3',
        'doc_category' => 'required',
        'doc_scancopy' => 'nullable|image|max:1024',
        'doc_description' => 'nullable'
    ];

    public function mount(PersonalDocument $document)
    {
        $this->document = $document;
        $this->doc_name = $document->doc_name;
        $this->doc_category = $document->doc_category;
        $this->doc_description = $document->doc_description;
    }

    public function save()
    {
        $this->validate();

        $this->document->update([
            'doc_name' => $this->doc_name,
            'doc_category' => $this->doc_category,
            'doc_description' => $this->doc_description,
        ]);

        if ($this->doc_scancopy) {
            $this->document->update([
                'doc_scancopy' => $this->doc_scancopy->store('personal-documents', 'public')
            ]);
        }

        $this->dispatch('notify', ['message' => 'Document updated successfully!']);
        return redirect()->route('documents.personal.index');
    }

    public function render()
    {
        return view('livewire.documents.personal.edit', [
            'categories' => PersonalDocument::getCategories()
        ]);
    }
} 