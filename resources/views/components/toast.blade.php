<!-- Toast Container (Fixed to bottom right) -->
<div id="toast-container" class="fixed bottom-5 right-5 z-[100] flex flex-col gap-3">
    <!-- Toasts will be injected here by JS -->
</div>

<script>
    // 1. Defined the Toast Logic
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        
        // Create element
        const toast = document.createElement('div');
        
        // Colors based on type
        const colors = {
            'success': 'bg-gray-900 border-l-4 border-green-500 text-white',
            'error':   'bg-gray-900 border-l-4 border-red-500 text-white',
            'info':    'bg-gray-900 border-l-4 border-blue-500 text-white',
        };
        const colorClass = colors[type] || colors['success'];

        // Tailwind Classes (Initial state: Translate off screen right)
        toast.className = `${colorClass} px-6 py-4 rounded shadow-2xl flex items-center gap-4 transition-all duration-500 transform translate-x-full opacity-0 min-w-[300px]`;
        
        // Icon based on type
        let icon = '';
        if(type === 'success') icon = '<svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
        if(type === 'error')   icon = '<svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';

        toast.innerHTML = `
            <div>${icon}</div>
            <div class="font-medium text-sm">${message}</div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-gray-400 hover:text-white">&times;</button>
        `;

        // Add to DOM
        container.appendChild(toast);

        // Animate In (Small delay to allow DOM render)
        setTimeout(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
        }, 10);

        // Auto Dismiss after 4 seconds
        setTimeout(() => {
            toast.classList.add('translate-x-full', 'opacity-0');
            // Remove from DOM after animation finishes
            setTimeout(() => {
                toast.remove();
            }, 500);
        }, 4000);
    }

    // 2. Check for Laravel Session Flash Messages
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            showToast("{{ session('success') }}", 'success');
        @endif

        @if(session('error'))
            showToast("{{ session('error') }}", 'error');
        @endif

        @if($errors->any())
            showToast("Please check the form for errors.", 'error');
        @endif
    });
</script>