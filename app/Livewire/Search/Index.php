<?php

namespace App\Livewire\Search;

use Livewire\Component;

class Index extends Component
{
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->dispatch('search', $this->search);
    }

    public function render()
    {
        return view('livewire.search.index');
    }
}
