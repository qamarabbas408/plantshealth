<x-public-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg border border-gray-100">
            
            <div class="text-center">
                <img src="{{ asset('images/leaf-logo.png') }}" class="mx-auto h-12 w-auto" alt="Logo">
                <h2 class="mt-6 text-3xl font-serif font-bold text-gray-900">
                    Become an Author
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Join our community of researchers
                </p>
            </div>

            <form class="mt-8 space-y-5" action="{{ route('register.post') }}" method="POST">
                @csrf

                <!-- Name -->
                <x-text-input 
                    label="Full Name" 
                    name="name" 
                    placeholder="Dr. John Doe"
                    :value="old('name')" 
                />

                <!-- Email -->
                <x-text-input 
                    label="Email Address" 
                    name="email" 
                    type="email"
                    placeholder="name@university.edu"
                    :value="old('email')" 
                />

                <!-- Password -->
                <x-text-input 
                    label="Password" 
                    name="password" 
                    type="password"
                    placeholder="Minimum 8 characters" 
                />

                <!-- Confirm Password -->
                <x-text-input 
                    label="Confirm Password" 
                    name="password_confirmation" 
                    type="password"
                    placeholder="Re-type your password" 
                />

                <div class="pt-4">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-brand-green hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-green transition transform hover:-translate-y-0.5">
                        Register Account
                    </button>
                </div>

                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="font-medium text-brand-green hover:text-green-700 hover:underline">
                            Log in here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-public-layout>