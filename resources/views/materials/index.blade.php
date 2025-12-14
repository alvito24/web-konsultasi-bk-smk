<x-app-layout>
    <x-slot name="header">
        Browser Materi Konseling
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col lg:flex-row gap-8">

                <div class="order-1 lg:order-2 lg:w-1/4 space-y-6">

                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Cari Materi
                        </h3>
                        <form method="GET" action="{{ route('materials.index') }}">
                            <div class="space-y-3">
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                           class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg pl-9 py-2 text-sm"
                                           placeholder="Kata kunci...">
                                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>

                                <div>
                                    <select name="category" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg text-sm">
                                        <option value="">-- Semua Kategori --</option>
                                        @foreach(['Kesehatan Mental', 'Motivasi Belajar', 'Pergaulan Remaja', 'Karir & Masa Depan', 'Bahaya Narkoba', 'Lainnya'] as $cat)
                                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg text-sm transition-colors shadow-sm">
                                    Terapkan Filter
                                </button>

                                @if(request('search') || request('category'))
                                    <a href="{{ route('materials.index') }}" class="block text-center text-xs text-gray-500 hover:text-red-500 underline">Reset Filter</a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Terpopuler
                        </h3>
                        @if($popularMaterials->isEmpty())
                            <p class="text-xs text-gray-400">Belum ada data populer.</p>
                        @else
                            <ul class="space-y-4">
                                @foreach($popularMaterials as $pm)
                                <li class="flex items-start group">
                                    <span class="text-xl font-bold text-gray-300 mr-3 -mt-1 group-hover:text-yellow-400 transition-colors">#{{ $loop->iteration }}</span>
                                    <div class="flex-grow">
                                        <a href="{{ route('materials.show', $pm->id) }}" class="text-sm font-semibold text-gray-700 hover:text-blue-600 block line-clamp-2 leading-tight transition-colors">
                                            {{ $pm->title }}
                                        </a>
                                        <div class="flex items-center mt-1 text-[10px] text-gray-400 space-x-2">
                                            <span class="flex items-center text-green-600 font-bold">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                                {{ $pm->upvotes_count }}
                                            </span>
                                            <span>{{ $pm->views_count }} views</span>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                </div>

                <div class="order-2 lg:order-1 lg:w-3/4">

                    <div class="mb-6 flex justify-between items-end">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Jelajahi Materi</h2>
                            <p class="text-sm text-gray-500">Temukan panduan kesehatan mental & motivasi.</p>
                        </div>
                        @if(in_array(Auth::user()->role, ['guru_bk', 'wali_kelas']))
                            <a href="{{ route('materials.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-bold shadow-sm flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Upload
                            </a>
                        @endif
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($materials->isEmpty())
                        <div class="text-center py-12 bg-white rounded-xl shadow-sm border border-dashed">
                            <div class="p-4 bg-blue-50 rounded-full w-16 h-16 mx-auto text-blue-500 mb-4 flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Materi tidak ditemukan</h3>
                            <p class="text-gray-500">Coba ganti kata kunci atau kategori lain.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($materials as $m)
                                <a href="{{ route('materials.show', $m->id) }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all hover:-translate-y-1 flex flex-col">

                                    <div class="h-40 bg-gray-100 flex items-center justify-center group-hover:bg-blue-50 transition-colors relative overflow-hidden">
                                        @if($m->file_type == 'youtube')
                                            @php parse_str(parse_url($m->file_path, PHP_URL_QUERY), $vars); $ytId = $vars['v'] ?? null; @endphp
                                            <img src="https://img.youtube.com/vi/{{ $ytId }}/hqdefault.jpg" class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition-transform duration-500">
                                            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-20">
                                                <svg class="w-12 h-12 text-white opacity-80" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" /></svg>
                                            </div>
                                        @elseif($m->file_type == 'image')
                                            <img src="{{ asset('storage/' . $m->file_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        @else
                                            <svg class="w-16 h-16 text-gray-300 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        @endif
                                        <span class="absolute top-2 right-2 bg-white/90 backdrop-blur px-2 py-1 rounded text-[10px] font-bold shadow-sm uppercase tracking-wide text-gray-600">
                                            {{ $m->file_type }}
                                        </span>
                                    </div>

                                    <div class="p-5 flex-grow">
                                        <p class="text-xs text-blue-600 font-semibold mb-1 uppercase tracking-wider">{{ $m->category }}</p>
                                        <h3 class="font-bold text-gray-800 text-lg mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $m->title }}</h3>
                                        <p class="text-gray-500 text-sm line-clamp-2 mb-4">{{ $m->description }}</p>

                                        <div class="flex justify-between items-center border-t pt-4 text-xs text-gray-400 mt-auto">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                {{ $m->views_count }}
                                            </span>
                                            <span class="flex items-center text-green-600 font-bold">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                                {{ $m->upvotes_count }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="mt-6">{{ $materials->links() }}</div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
