<x-public-layout>
    <div class="py-12 text-center">
        <h1 class="text-2xl font-bold">Author Dashboard</h1>
        <p>Welcome, {{ Auth::user()->name }}!</p>
        
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="text-red-500 underline">Logout</button>
        </form>
    </div>
</x-public-layout>