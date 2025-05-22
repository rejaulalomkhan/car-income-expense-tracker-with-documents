<?php

namespace App\Livewire\Documents\Personal;

use App\Models\PersonalDocument;
use Livewire\Component;

class View extends Component
{
    public PersonalDocument $document;

    public function mount(PersonalDocument $document)
    {
        $this->document = $document;
    }

    public function render()
    {
        return view('livewire.documents.personal.view', [
            'document' => $this->document
        ]);
    }
} 