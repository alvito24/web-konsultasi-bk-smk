<x-app-layout>
    <x-slot name="header">Detail Materi</x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('materials.index') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 mb-6 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Browser
            </a>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">

                <div class="bg-gray-100 border-b border-gray-200">
                    @if($material->file_type == 'youtube')
                        @php
                            // FIX: Menggunakan Regex agar bisa baca link youtu.be (short) dan youtube.com (long)
                            $url = $material->file_path;
                            $ytId = null;
                            
                            // Pattern regex untuk menangkap ID 11 karakter YouTube
                            $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
                            
                            if (preg_match($pattern, $url, $matches)) {
                                $ytId = $matches[1];
                            }
                        @endphp

                        @if($ytId)
                            <div class="aspect-w-16 aspect-h-9 w-full">
                                <iframe class="w-full h-[500px]" 
                                    src="https://www.youtube.com/embed/{{ $ytId }}?rel=0" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                                </iframe>
                            </div>
                        @else
                            <div class="p-12 text-center text-red-500">
                                <p>Format link YouTube tidak dikenali.</p>
                                <a href="{{ $material->file_path }}" target="_blank" class="underline">Buka langsung di YouTube</a>
                            </div>
                        @endif

                    @elseif($material->file_type == 'image')
                        <div class="flex justify-center bg-gray-900">
                             <img src="{{ asset('storage/' . $material->file_path) }}" class="max-w-full h-auto max-h-[600px] object-contain">
                        </div>
                    @elseif($material->file_type == 'video')
                        <video controls class="w-full h-auto max-h-[600px] bg-black">
                            <source src="{{ asset('storage/' . $material->file_path) }}">
                            Browser Anda tidak mendukung tag video.
                        </video>
                    @else
                        <div class="p-12 text-center">
                            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p class="text-gray-600 mb-4">Materi ini berupa file dokumen.</p>
                            <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download / Lihat File
                            </a>
                        </div>
                    @endif
                </div>

                <div class="p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-2">
                                {{ $material->category }}
                            </span>
                            <h1 class="text-3xl font-bold text-gray-800">{{ $material->title }}</h1>
                        </div>

                        @if(Auth::id() === $material->uploaded_by)
                            <form action="{{ route('materials.destroy', $material->id) }}" method="POST" onsubmit="return confirm('Hapus permanen?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                    🗑 Hapus
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="flex items-center text-sm text-gray-500 mb-8 border-b pb-6">
                        <img src="{{ $material->uploader->avatar ? asset('storage/'.$material->uploader->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($material->uploader->name) }}" class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $material->uploader->name }}</p>
                            <p>Diposting {{ $material->created_at->diffForHumans() }} • {{ $material->views_count }}x Dilihat</p>
                        </div>
                    </div>

                    <div class="prose max-w-none text-gray-600 leading-relaxed mb-8">
                        {!! nl2br(e($material->description)) !!}
                    </div>

                    <div class="flex items-center gap-4">
                        <form action="{{ route('materials.upvote', $material->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center px-4 py-2 rounded-full border transition-all transform active:scale-95
                                {{ $material->isUpvotedByAuthUser()
                                    ? 'bg-green-600 text-white border-green-600 hover:bg-green-700 shadow-md'
                                    : 'bg-white text-gray-600 border-gray-300 hover:border-green-500 hover:text-green-600' }}">

                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>

                                <span class="font-bold mr-1">Upvote</span>
                                <span class="text-sm opacity-90">({{ $material->upvotes()->count() }})</span>
                            </button>
                        </form>

                        <p class="text-sm text-gray-400 italic">
                            {{ $material->isUpvotedByAuthUser() ? 'Anda menyukai materi ini.' : 'Apakah materi ini membantu?' }}
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
