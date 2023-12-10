@props(['post'])

<div>
    <a href="http://127.0.0.1:8000/blog/laravel-34">
        <div>
            <img class="w-full rounded-xl" src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}">
        </div>
    </a>
    <div class="mt-3">
        <div class="flex items-center mb-2">
            @foreach($post->categories as $category)
                <a href="http://127.0.0.1:8000/categories/{{ $category->slug }}"
                   class="bg-red-600 text-white rounded-xl px-3 py-1 text-sm mr-3">
                    {{ $category->title }}
                </a>
            @endforeach
        </div>
        <div class="flex items-center mb-2">
            <p class="text-gray-500 font-semibold text-sm flex items-center">
                         {{ $post->created_at->format('M d, Y') }} | {{ $post->time_to_read }}
            </p>
                   </div>
        <a class="text-xl font-bold text-gray-900">{{ $post->title }}</a>

    </div>
</div>
