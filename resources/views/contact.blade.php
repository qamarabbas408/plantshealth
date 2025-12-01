<x-public-layout>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-10">
                <h1 class="text-3xl font-serif font-bold text-gray-900">Contact Support</h1>
                <p class="mt-2 text-gray-600">Have questions about submitting an article or the review process? We're here to help.</p>
            </div>

           

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf

                    <!-- Name & Email Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                            <input type="text" name="name" required 
                                   value="{{ Auth::check() ? Auth::user()->name : old('name') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-brand-green focus:ring focus:ring-brand-green focus:ring-opacity-50 p-2 border">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Your Email</label>
                            <input type="email" name="email" required 
                                   value="{{ Auth::check() ? Auth::user()->email : old('email') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-brand-green focus:ring focus:ring-brand-green focus:ring-opacity-50 p-2 border">
                        </div>
                    </div>

                    <!-- Subject -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <select name="subject" class="w-full border-gray-300 rounded-md shadow-sm focus:border-brand-green focus:ring focus:ring-brand-green focus:ring-opacity-50 p-2 border">
                            <option>General Inquiry</option>
                            <option>Submission Issue</option>
                            <option>Technical Support</option>
                            <option>Report Content</option>
                        </select>
                    </div>

                    <!-- Message -->
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea name="message" rows="5" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-brand-green focus:ring focus:ring-brand-green focus:ring-opacity-50 p-2 border" placeholder="How can we help you?"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-brand-green text-white font-bold py-3 rounded-md hover:bg-green-800 transition shadow-lg">
                        Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="mt-10 text-center text-sm text-gray-500">
                <p>Or email us directly at <a href="mailto:support@plantshealth.com" class="text-brand-green font-bold">support@plantshealth.com</a></p>
            </div>

        </div>
    </div>
</x-public-layout>