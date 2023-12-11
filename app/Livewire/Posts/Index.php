<?php

namespace App\Livewire\Posts;

use App\Models\Category;
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

    #[Url()]
    public string $category = '';

    public function setSort(string $sort): void
    {
        $this->sort = ($sort === 'desc') ? 'desc' : 'asc';
    }

    #[On('search')]
    public function updateSearch($search)
    {
        $this->search = $search;
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->category = '';
        $this->resetPage();
    }

    #[Computed()]
    public function posts()
    {
        return Post::published()
            ->when($this->activeCategory, fn($q) => $q->withCategory($this->category))
            ->orderBy('published_at', $this->sort)
            ->withSearch($this->search)
            ->paginate(3);
    }

    #[Computed()]
    public function activeCategory()
    {
        if ($this->category === '') {
            return null;
        }
        return Category::where('slug', $this->category)->first();
    }

    public function render()
    {
        return view('livewire.posts.index'
        );
    }
}
