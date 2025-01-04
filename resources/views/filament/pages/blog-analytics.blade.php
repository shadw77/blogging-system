<x-filament-panels::page>

<div class="space-y-6">
    <h2 class="text-xl font-semibold">Blog Analytics</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold">Total Posts</h3>
            <p class="text-2xl">{{ $totalPosts }}</p>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold">Total Comments</h3>
            <p class="text-2xl">{{ $totalComments }}</p>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold">Total Tags</h3>
            <p class="text-2xl">{{ $totalTags }}</p>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold">Published Posts</h3>
            <p class="text-2xl">{{ $publishedPosts }}</p>
        </div>
    </div>
</div>

</x-filament-panels::page>
