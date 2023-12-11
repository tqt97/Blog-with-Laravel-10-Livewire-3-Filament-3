<div id="posts" class=" px-3 lg:px-7 py-6">
    <div class="flex justify-between items-center border-b border-gray-100">
        <div class="text-gray-600">
            @if ($this->activeCategory || $search)
                <button class="mr-3 text-xs gray-500" wire:click="clearFilters()">X</button>
            @endif
            @if ($this->activeCategory)
                <x-badges.category-sidebar wire:navigate
                    href="{{ route('posts.index', ['category' => $this->activeCategory->slug]) }}" :textColor="$this->activeCategory->text_color"
                    :bgColor="$this->activeCategory->bg_color">
                    {{ $this->activeCategory->name }}
                </x-badges.category-sidebar>
            @endif
            @if ($search)
                <span class="ml-2">
                    {{ __('blog.containing') }} : <strong>{{ $search }}</strong>
                </span>
            @endif
        </div>
        <div id="filter-selector" class="flex items-center space-x-4 font-light ">
            <button class="{{ $sort === 'desc' ? 'text-gray-900 border-b border-gray-700' : 'text-gray-500' }} py-4"
                wire:click="setSort('desc')">
                Latest
            </button>
            <button class="{{ $sort === 'asc' ? 'text-gray-900 border-b border-gray-700' : 'text-gray-500' }} py-4 "
                wire:click="setSort('asc')">
                Oldest
            </button>
        </div>
    </div>
    <div class="py-4" wire:loading.class="opacity-10">
        @forelse($this->posts as $post)
            <x-posts.post :post="$post" />
        @empty
            <h1>{{ count($this->posts) }} post here</h1>
        @endforelse

        <div class="my-3">
            @if (count($this->posts))
                {{ $this->posts->onEachSide(3)->links() }}
            @endif
        </div>
    </div>
</div>
