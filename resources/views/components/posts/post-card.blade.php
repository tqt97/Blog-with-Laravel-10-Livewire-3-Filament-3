@props(['post'])

<div {{$attributes}}>
    <a href="http://127.0.0.1:8000/blog/laravel-34">
        <div>
            <img class="w-full rounded-xl" src="{{ $post->getThumbnail() }}" alt="{{ $post->title }}">
        </div>
    </a>
    <div class="mt-3">
        <div class="flex items-center mb-2 gap-x-2">
            @foreach($post->categories as $category)
                <x-badges.category-sidebar
                    wire:navigate
                    href="{{route('posts.index', ['category' => $category->slug])}}"
                    :textColor="$category->text_color"
                    :bgColor="$category->bg_color">
                    {{ $category->title }}
                </x-badges.category-sidebar>
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
