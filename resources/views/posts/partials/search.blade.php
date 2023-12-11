<div id="search-box" x-data="{ query: '{{ request('search', '') }}' }" x-on:keyup.enter.window="$dispatch('search', {search:query})">
    <h3 class="text-lg font-semibold text-gray-900 mb-3">Search</h3>
    <div class="flex">
        <div class="relative w-full rounded-2xl bg-gray-100 py- px-3 mb-3">
            <input x-model="query"
                class="block p-2.5 w-full z-20 ml-1 bg-transparent focus:outline-none focus:border-none focus:ring-0
                                outline-none border-none text-sm text-gray-800 placeholder:text-gray-400"
                placeholder="{{ __('Search here...') }}">
            <button x-on:click="$dispatch('search', {search:query})" type="submit"
                class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-yellow-500
                        rounded-e-2xl border border-yellow-100 hover:bg-yellow-600 focus:ring-0 focus:outline-none">
                <x-icons.search class="w-6 h-6 text-white" />
                <span class="sr-only">Search</span>
            </button>
        </div>
    </div>
</div>
