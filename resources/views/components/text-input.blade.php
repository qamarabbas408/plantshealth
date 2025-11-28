@props(['name', 'label' => null, 'type' => 'text', 'value' => '', 'placeholder' => '', 'readonly' => false])

<div class="mb-4">
    <!-- 1. Label -->
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-2">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        <!-- 2. The Input -->
        <!-- Added 'pr-10' to padding so text doesn't hit the icon -->
        <input 
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $readonly ? 'readonly' : '' }}
            {{ $attributes->merge([
                'class' => 'w-full rounded-md border-gray-300 shadow-sm py-2.5 pl-4 pr-10 text-gray-900 placeholder-gray-400 
                            focus:border-brand-gold focus:ring-1 focus:ring-brand-gold 
                            transition duration-200 ease-in-out ' . 
                            ($readonly ? 'bg-gray-100 text-gray-500 cursor-not-allowed border-gray-200' : '')
            ]) }}
        >

        <!-- 3. The Eye Icon (Only if type is password) -->
        @if($type === 'password')
            <button type="button" 
                    onclick="togglePasswordVisibility(this)"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer">
                
                <!-- Icon: Eye (Show) -->
                <svg class="h-5 w-5 eye-open" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>

                <!-- Icon: Eye Slash (Hide) - Hidden by default -->
                <svg class="h-5 w-5 eye-closed hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.059 10.059 0 013.999-5.42m3.71-2.13C10.93 4.14 11.458 4 12 4c4.478 0 8.268 2.943 9.542 7a10.059 10.059 0 01-5.077 5.92m-2.353 1.15l3.65 3.65M3 3l18 18" />
                </svg>
            </button>
        @endif
    </div>

    <!-- 4. Validation Error -->
    @error($name)
        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

<!-- 5. Script (Only included once per page automatically by browser if handled correctly, but inline here is safe) -->
<script>
    if (typeof togglePasswordVisibility !== 'function') {
        function togglePasswordVisibility(button) {
            // Find the input relative to the button
            const container = button.parentElement;
            const input = container.querySelector('input');
            const eyeOpen = button.querySelector('.eye-open');
            const eyeClosed = button.querySelector('.eye-closed');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    }
</script>