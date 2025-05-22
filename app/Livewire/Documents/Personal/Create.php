<?php

namespace App\Livewire\Documents\Personal;

use App\Models\PersonalDocument;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $doc_name = '';
    public $doc_category = '';
    public $doc_scancopy;
    public $doc_description = '';

    protected $rules = [
        'doc_name' => 'required|min:3',
        'doc_category' => 'required',
        'doc_scancopy' => 'required|file|mimes:pdf,jpg,jpeg,png|max:20480', // 20MB in kilobytes
        'doc_description' => 'nullable'
    ];

    public function save()
    {
        $this->validate();

        PersonalDocument::create([
            'doc_name' => $this->doc_name,
            'doc_category' => $this->doc_category,
            'doc_scancopy' => $this->doc_scancopy->store('personal-documents', 'public'),
            'doc_description' => $this->doc_description,
        ]);

        $this->dispatch('notify', ['message' => 'Document created successfully!']);
        return redirect()->route('documents.personal.index');
    }

    public function updatedDocScancopy()
    {
        $this->validate([
            'doc_scancopy' => 'nullable|file|max:20480|mimes:pdf,jpg,jpeg,png',
        ]);
    }

    public function render()
    {
        return view('livewire.documents.personal.create', [
            'categories' => PersonalDocument::getCategories()
        ]);
    }
} 