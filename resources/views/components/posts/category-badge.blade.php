@props(['category'])

<x-badges.category-sidebar wire:navigate href="{{ route('posts.index', ['category' => $category->slug]) }}"
    :textColor="$category->text_color" :bgColor="$category->bg_color">
    {{ $category->name }}
</x-badges.category-sidebar>
