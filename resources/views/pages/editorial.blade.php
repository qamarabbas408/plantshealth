<x-public-layout>
    <!-- Header -->
    <div class="bg-gray-50 py-16 text-center border-b border-gray-200">
        <h1 class="text-4xl font-serif font-bold text-gray-900">Editorial Board</h1>
        <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
            Our journal is guided by a distinguished group of experts from leading institutions worldwide.
        </p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <!-- 1. EDITOR-IN-CHIEF -->
        <div class="mb-20">
            <h2 class="text-xs font-bold text-brand-green uppercase tracking-widest text-center mb-8">Editor-in-Chief</h2>
            
            <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row">
                <div class="md:w-1/3 bg-gray-200 relative">
                    <!-- Placeholder Image -->
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover grayscale hover:grayscale-0 transition duration-500">
                </div>
                <div class="p-8 md:w-2/3 flex flex-col justify-center">
                    <h3 class="text-2xl font-serif font-bold text-gray-900">Dr. Robert Vance</h3>
                    <p class="text-brand-gold font-medium mb-4">Department of Plant Sciences</p>
                    <p class="text-gray-600 text-sm mb-6">University of Agriculture, Faisalabad</p>
                    
                    <p class="text-gray-500 text-sm italic border-l-4 border-gray-200 pl-4">
                        "Leading the charge in sustainable agricultural practices and genomic research."
                    </p>
                    
                    <div class="mt-6 flex gap-3">
                        <a href="#" class="text-xs font-bold text-gray-400 hover:text-brand-green uppercase border border-gray-200 px-3 py-1 rounded-full transition">Profile</a>
                        <a href="#" class="text-xs font-bold text-gray-400 hover:text-brand-green uppercase border border-gray-200 px-3 py-1 rounded-full transition">Google Scholar</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. ASSOCIATE EDITORS -->
        <div class="mb-20">
            <h2 class="text-xs font-bold text-brand-green uppercase tracking-widest text-center mb-10">Associate Editors</h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Editor 1 -->
                <div class="text-center group">
                    <div class="w-24 h-24 mx-auto rounded-full overflow-hidden mb-4 border-2 border-transparent group-hover:border-brand-gold transition">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-bold text-gray-900">Prof. Sarah Jenkins</h3>
                    <p class="text-xs text-brand-green font-semibold uppercase mt-1">Soil Microbiology</p>
                    <p class="text-sm text-gray-500 mt-2">Cornell University, USA</p>
                </div>

                <!-- Editor 2 -->
                <div class="text-center group">
                    <div class="w-24 h-24 mx-auto rounded-full overflow-hidden mb-4 border-2 border-transparent group-hover:border-brand-gold transition">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-bold text-gray-900">Dr. Wei Chen</h3>
                    <p class="text-xs text-brand-green font-semibold uppercase mt-1">Agricultural Engineering</p>
                    <p class="text-sm text-gray-500 mt-2">China Agricultural University, China</p>
                </div>

                <!-- Editor 3 -->
                <div class="text-center group">
                    <div class="w-24 h-24 mx-auto rounded-full overflow-hidden mb-4 border-2 border-transparent group-hover:border-brand-gold transition">
                        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-bold text-gray-900">Dr. Emily Rostova</h3>
                    <p class="text-xs text-brand-green font-semibold uppercase mt-1">Plant Genetics</p>
                    <p class="text-sm text-gray-500 mt-2">Wageningen University, Netherlands</p>
                </div>
            </div>
        </div>

        <!-- 3. ADVISORY BOARD (List View) -->
        <div>
            <h2 class="text-xs font-bold text-brand-green uppercase tracking-widest text-center mb-10">Advisory Board</h2>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Loop for dummy data -->
                @foreach(range(1, 6) as $i)
                <div class="bg-gray-50 p-4 rounded border border-gray-100 flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-400 font-bold border border-gray-200">
                        {{ ['A','B','C','D','E','F'][$i-1] }}
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-900">Dr. Member Name {{ $i }}</h4>
                        <p class="text-xs text-gray-500">Institute of Science, Country</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</x-public-layout>