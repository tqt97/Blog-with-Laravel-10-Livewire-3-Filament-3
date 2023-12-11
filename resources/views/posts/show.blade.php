<x-app-layout :title="$post->title">
    <article class="col-span-4 md:col-span-3 mt-10 mx-auto py-5 w-full" style="max-width:700px">
        <img class="w-full my-2 rounded-lg" src="" alt="">
        <h1 class="text-4xl font-bold text-left text-gray-800">
            {{ $post->title }}
        </h1>
        <div class="mt-2 flex justify-between items-center">
            <div class="flex py-5 text-base items-center">
                <x-posts.author :author="$post->user" size="sm" />
                <span class="text-gray-500 text-sm">| {{ $post->time_to_read }}</span>
            </div>
            <div class="flex items-center">
                <span class="text-gray-500 mr-2">{{ $post->publishedDiffForHumans() }}</span>
                <x-icons.clock />
            </div>
        </div>

        <div
            class="article-actions-bar my-6 flex text-sm items-center justify-between border-t border-b border-gray-100 py-4 px-2">
            <div class="flex items-center">
                <livewire:like.button :key="'show-likeButton-'.$post->id" :$post />
            </div>
            <div>
                <div class="flex items-center">
                    <button>
                        <x-icons.dot />
                    </button>
                </div>
            </div>
        </div>

        <div class="article-content py-3 prose text-gray-800 text-lg text-justify">
            {!! $post->body !!}
        </div>

        <div class="flex items-center space-x-4 mt-10">
            @foreach ($post->categories as $category)
                <x-posts.category-badge :category="$category" />
            @endforeach
        </div>

        <livewire:posts.comment :key="'comments' . $post->id" :post="$post" />

    </article>
</x-app-layout>
