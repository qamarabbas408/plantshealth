<x-public-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg border border-gray-100">
            
            <div class="text-center">
                <img src="{{ asset('images/leaf-logo.png') }}" class="mx-auto h-12 w-auto" alt="Logo">
                <h2 class="mt-6 text-2xl font-serif font-bold text-gray-900">
                    Create New Password
                </h2>
            </div>

            <form class="mt-8 space-y-5" action="{{ route('password.update') }}" method="POST">
                @csrf

                <!-- Password Reset Token (Required by Laravel) -->
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email -->
                <x-text-input 
                    label="Email Address" 
                    name="email" 
                    type="email" 
                    :value="old('email', $email)" 
                    readonly
                />

                <!-- New Password -->
                <x-text-input 
                    label="New Password" 
                    name="password" 
                    type="password" 
                    placeholder="Minimum 8 characters"
                />

                <!-- Confirm Password -->
                <x-text-input 
                    label="Confirm Password" 
                    name="password_confirmation" 
                    type="password" 
                    placeholder="Re-type new password"
                />

                <div class="pt-4">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-brand-green hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-green transition transform hover:-translate-y-0.5">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-public-layout>