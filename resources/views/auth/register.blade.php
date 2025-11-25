<x-public-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded shadow">
            
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Become an Author
            </h2>

            <form class="mt-8 space-y-6" action="{{ route('register.post') }}" method="POST">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input name="name" type="text" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input name="email" type="email" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input name="password" type="password" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input name="password_confirmation" type="password" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>

                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-brand-green hover:bg-green-700">
                    Register
                </button>
            </form>
        </div>
    </div>
</x-public-layout>