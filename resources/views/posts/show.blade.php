<x-app-layout>
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
                <livewire:like.button :key="$post->id" :$post />
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

        <div class="mt-10 comments-box border-t border-gray-100 pt-10">
            <h2 class="text-2xl font-semibold text-gray-900 mb-5">Discussions</h2>
            <textarea
                class="w-full rounded-lg p-4 bg-gray-50 focus:outline-none text-sm text-gray-700 border-gray-200 placeholder:text-gray-400"
                cols="30" rows="7"></textarea>
            <button
                class="mt-3 inline-flex items-center justify-center h-10 px-4 font-medium tracking-wide text-white transition duration-200 bg-gray-900 rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none">
                Post Comment
            </button>

            <!-- <a class="text-yellow-500 underline py-1" href=""> Login to Post Comments</a> -->

            <div class="user-comments px-3 py-2 mt-5">
                <div class="comment [&:not(:last-child)]:border-b border-gray-100 py-5">
                    <div class="user-meta flex mb-4 text-sm items-center">
                        <img class="w-7 h-7 rounded-full mr-3" src="" alt="mn">
                        <span class="mr-1">user name</span>
                        <span class="text-gray-500">. 15 days ago</span>
                    </div>
                    <div class="text-justify text-gray-700  text-sm">
                        comment content
                    </div>
                </div>
                <!-- <div class="text-gray-500 text-center">
                    <span> No Comments Posted</span>
                </div> -->
            </div>
        </div>


    </article>
</x-app-layout>
