<x-public-layout>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center gap-4 mb-8">
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-3xl font-serif font-bold text-gray-900">Account Settings</h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                
                <!-- 1. LEFT SIDEBAR (Navigation) -->
                <div class="md:col-span-1">
                    <nav class="space-y-1 sticky top-24">
                        <a href="{{ route('profile.edit') }}" class="text-gray-600 hover:bg-white hover:text-gray-900 px-5 py-4 flex items-center transition rounded-md">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Edit Profile
                        </a>
                        
                        <!-- Active State for Password Tab -->
                        <a href="{{ route('password.edit') }}" class="bg-white text-brand-green border-l-4 border-brand-green font-semibold px-5 py-4 flex items-center shadow-sm rounded-r-md">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Password & Security
                        </a>
                        
                        <a href="#" class="text-gray-600 hover:bg-white hover:text-gray-900 px-5 py-4 flex items-center transition rounded-md">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            Notifications
                        </a>
                    </nav>
                </div>

                <!-- 2. MAIN FORM AREA -->
                <div class="md:col-span-3">
                    <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-100">
                        
                        <div class="px-8 py-6 border-b border-gray-100 bg-white flex justify-between items-center">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Security</h3>
                                <p class="text-sm text-gray-500 mt-1">Ensure your account is using a long, random password to stay secure.</p>
                            </div>
                         
                        </div>

                        <form action="{{ route('password.update') }}" method="POST" class="p-8 max-w-2xl">
                            @csrf
                            
                            <!-- 1. Current Password -->
                            <div class="mb-6">
                                <x-text-input 
                                    label="Current Password" 
                                    name="current_password" 
                                    type="password"
                                    placeholder="Enter your current password" 
                                />
                            </div>

                            <hr class="border-gray-100 my-6">

                            <!-- 2. New Password -->
                            <div class="mb-2">
                                <x-text-input 
                                    label="New Password" 
                                    name="password" 
                                    type="password"
                                    placeholder="Minimum 8 characters" 
                                />
                            </div>

                            <!-- 3. Confirm Password -->
                            <div class="mb-6">
                                <x-text-input 
                                    label="Confirm New Password" 
                                    name="password_confirmation" 
                                    type="password"
                                    placeholder="Re-type new password" 
                                />
                            </div>

                            <!-- BUTTONS -->
                            <div class="pt-4 flex items-center gap-3">
                                <button type="submit" id="save-btn" class="relative inline-flex items-center justify-center px-8 py-2.5 border border-transparent shadow-md text-sm font-bold rounded-lg text-white bg-brand-green hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-green transition transform hover:-translate-y-0.5">
                                    <svg id="btn-spinner" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span id="btn-text">Update Password</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Re-use the loading script -->
    <script>
        const form = document.querySelector('form');
        const btn = document.getElementById('save-btn');
        const spinner = document.getElementById('btn-spinner');
        const btnText = document.getElementById('btn-text');

        form.addEventListener('submit', function() {
            btn.disabled = true;
            btn.classList.add('cursor-not-allowed', 'opacity-75');
            spinner.classList.remove('hidden');
            btnText.innerText = 'Updating...';
        });
    </script>
</x-public-layout>