<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Comment extends Component
{
    use WithPagination;

    public Post $post;

    #[Rule('required|string|max:255|min:3')]
    public string $comment;

    public function postComment()
    {
        if(auth()->guest()) {
            return redirect()->route('login');
        }

        $this->validateOnly('comment');

        $this->post->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $this->comment
        ]);
        $this->reset('comment');
    }

    #[Computed()]
    public function comments()
    {
        return $this?->post?->comments()->latest()->paginate(5);
    }

    public function render()
    {
        return view('livewire.posts.comment');
    }
}
