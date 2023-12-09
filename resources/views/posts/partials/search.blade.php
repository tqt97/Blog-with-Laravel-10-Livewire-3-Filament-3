<div id="search-box" x-data="{ keywords: '{{request('search','')}}' }" x-on:keydown.enter.prevent>
    <h3 class="text-lg font-semibold text-gray-900 mb-3">Search</h3>
    <div class="flex">
        <div class="relative w-full rounded-2xl bg-gray-100 py-1 px-3 mb-3">
            <input x-model="keywords" type="search" id="search-dropdown"
                   class="block p-2.5 w-full z-20 ml-1 bg-transparent focus:outline-none focus:border-none focus:ring-0
                                outline-none border-none text-sm text-gray-800 placeholder:text-gray-400"
                   placeholder="{{__('Search here...')}}">
            <button x-on:click="$dispatch('search', {search:keywords})"
                    type="submit"
                    class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-yellow-500
                        rounded-e-2xl border border-yellow-100 hover:bg-yellow-600 focus:ring-0 focus:outline-none">
                <x-icons.search class="w-6 h-6 text-white"/>
                <span class="sr-only">Search</span>
            </button>
        </div>
    </div>
</div>
