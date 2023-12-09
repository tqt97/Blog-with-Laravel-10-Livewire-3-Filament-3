<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url()]
    public string $sort = 'desc';

    #[Url()]
    public string $search = '';

    public function setSort(string $sort): void
    {
        $this->sort = ($sort === 'desc') ? 'desc' : 'asc';
    }

    #[On('search')]
    public function updatingSearch($search): void
    {
        $this->search = $search;
//        $this->resetPage(); // Reset pagination when search is updated
    }

    #[Computed()]
    public function posts()
    {
        return Post::published()
            ->orderBy('published_at', $this->sort)
            ->search($this->search)
            ->paginate(3);
    }

    public function render()
    {
        return view('livewire.posts.index'
        );
    }
}
