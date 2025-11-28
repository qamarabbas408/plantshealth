<x-public-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg border border-gray-100">
            
            <div class="text-center">
                <img src="{{ asset('images/leaf-logo.png') }}" class="mx-auto h-12 w-auto" alt="Logo">
                <h2 class="mt-6 text-2xl font-serif font-bold text-gray-900">
                    Reset Password
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Enter your email and we'll send you a link to reset your password.
                </p>
            </div>

            <!-- Success Message -->
            @if (session('status'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-4">
                    <p class="text-sm text-green-700">{{ session('status') }}</p>
                </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('password.email') }}" method="POST">
                @csrf 

                <x-text-input 
                    label="Email Address" 
                    name="email" 
                    type="email" 
                    placeholder="name@university.edu"
                    :value="old('email')" 
                />

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-brand-green hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-green transition transform hover:-translate-y-0.5">
                        Send Reset Link
                    </button>
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="font-medium text-sm text-gray-600 hover:text-brand-green hover:underline">
                        &larr; Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-public-layout>