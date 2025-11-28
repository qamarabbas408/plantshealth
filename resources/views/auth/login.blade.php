<x-public-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg border border-gray-100">

            <div class="text-center">
                <img src="{{ asset('images/leaf-logo.png') }}" class="mx-auto h-12 w-auto" alt="Logo">
                <h2 class="mt-6 text-3xl font-serif font-bold text-gray-900">
                    Welcome Back
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Sign in to access your dashboard
                </p>
            </div>

            <!-- Global Error (Optional, usually handled by component, but good for generic auth fails) -->
            @if ($errors->has('email') && !$errors->has('password'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                    <p class="text-sm text-red-700">{{ $errors->first('email') }}</p>
                </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="space-y-4">
                    <!-- Email Input (Using Component) -->
                    <x-text-input label="Email Address" name="email" type="email" placeholder="you@example.com"
                        :value="old('email')" />

                    <!-- Password Input (Using Component - Gets Eye Icon automatically) -->
                    <x-text-input label="Password" name="password" type="password" placeholder="Enter your password" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mt-4">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox"
                            class="h-4 w-4 text-brand-green focus:ring-brand-green border-gray-300 rounded cursor-pointer">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-900 cursor-pointer">
                            {{ __('Remember me') }}
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="{{ route('password.request') }}"
                            class="font-medium text-brand-green hover:text-green-700">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-brand-green hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-green transition transform hover:-translate-y-0.5 shadow-md">
                        {{ __('Sign in') }}
                    </button>
                </div>

                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">
                        Don't have an account?
                        <a href="{{ route('register') }}"
                            class="font-medium text-brand-green hover:text-green-700 hover:underline">
                            Register as Author
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-public-layout>
