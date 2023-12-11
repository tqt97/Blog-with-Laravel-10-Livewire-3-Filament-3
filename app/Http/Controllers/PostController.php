<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function index()
    {
        $categories = Cache::remember('categories', Carbon::now()->addDay(3), function () {
            return Category::whereHas('posts', fn ($q) => $q->published())
                ->withCount('posts')
                ->take(10)->get();
        });
        return view('posts.index', [
            'categories' => $categories
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post
        ]);
    }
}
