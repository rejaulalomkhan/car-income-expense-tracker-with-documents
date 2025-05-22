<?php

namespace App\Livewire\Documents\Personal;

use App\Models\PersonalDocument;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';

    public function mount()
    {
        $this->category = request()->query('category', '');
    }

    public function delete(PersonalDocument $document)
    {
        $document->delete();
        $this->dispatch('notify', ['message' => 'Document deleted successfully!']);
    }

    public function render()
    {
        $query = PersonalDocument::query()
            ->when($this->search, function ($query) {
                $query->where('doc_name', 'like', '%' . $this->search . '%')
                    ->orWhere('doc_description', 'like', '%' . $this->search . '%');
            })
            ->when($this->category, function ($query) {
                $query->where('doc_category', $this->category);
            })
            ->orderBy('created_at', 'desc');

        return view('livewire.documents.personal.index', [
            'documents' => $query->paginate(15),
            'categories' => PersonalDocument::getCategories()
        ]);
    }
} 