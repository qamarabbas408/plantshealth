<x-public-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-brand-green leading-tight">
            {{ __('Admin Portal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Row -->
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-brand-green">
                    <div class="text-gray-500">Pending Articles</div>
                    <div class="text-3xl font-bold">4</div> <!-- Dummy data for now -->
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-brand-gold">
                    <div class="text-gray-500">Total Authors</div>
                    <div class="text-3xl font-bold">12</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500">Published</div>
                    <div class="text-3xl font-bold">34</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Latest Submissions</h3>
                <p>List of articles to approve will go here...</p>
            </div>
        </div>
    </div>
</x-public-layout>