<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        return view('home', [
            'featurePosts' => Post::published()->featured()->with('categories')->latest('published_at')->take(3)->get(),
            'latestPosts' => Post::published()->with('categories')->latest('published_at')->take(9)->get(),
        ]);
    }
}
