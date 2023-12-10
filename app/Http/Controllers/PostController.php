<?php

namespace App\Http\Controllers;

use App\Models\Category;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'categories' => Category::whereHas('posts', fn($q) => $q->published())
                ->withCount('posts')
                ->take(10)->get()]);
    }
}
