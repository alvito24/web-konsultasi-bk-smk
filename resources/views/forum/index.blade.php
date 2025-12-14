<x-app-layout>
    <x-slot name="header">Forum Diskusi</x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col lg:flex-row gap-8">

                <div class="order-1 lg:order-2 lg:w-1/4 space-y-6">

                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-3">Filter Diskusi</h3>
                        <form method="GET" action="{{ route('forum.index') }}">
                            <div class="space-y-3">
                                <input type="text" name="search" value="{{ request('search') }}" class="w-full border-gray-300 rounded-lg text-sm" placeholder="Cari topik...">

                                <select name="category" class="w-full border-gray-300 rounded-lg text-sm">
                                    <option value="">-- Semua Kategori --</option>
                                    @foreach(['Umum', 'Akademik', 'Motivasi', 'Info Sekolah'] as $cat)
                                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>

                                <select name="sort" class="w-full border-gray-300 rounded-lg text-sm">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>📅 Terbaru</option>
                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>🔥 Terpopuler (Banyak Like)</option>
                                </select>

                                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-2 rounded-lg text-sm hover:bg-indigo-700">Terapkan</button>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                            <span class="mr-2">🔥</span> Topik Hangat
                        </h3>
                        <ul class="space-y-3">
                            @foreach($popularTopics as $pt)
                            <li class="flex items-start">
                                <span class="text-lg font-bold text-gray-300 mr-3">#{{ $loop->iteration }}</span>
                                <div>
                                    <a href="{{ route('forum.show', $pt->id) }}" class="text-sm font-semibold text-gray-700 hover:text-indigo-600 block line-clamp-2">
                                        {{ $pt->title }}
                                    </a>
                                    <span class="text-xs text-green-600 font-bold flex items-center mt-1">
                                        ❤️ {{ $pt->likes_count }} Likes
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    @if(in_array(Auth::user()->role, ['guru_bk', 'wali_kelas']))
                        <a href="{{ route('forum.create') }}" class="block w-full bg-green-600 text-white text-center py-3 rounded-xl font-bold hover:bg-green-700 shadow-md transition transform hover:-translate-y-1">
                            + Buat Topik Baru
                        </a>
                    @endif
                </div>

                <div class="order-2 lg:order-1 lg:w-3/4 space-y-4">
                    @if($topics->isEmpty())
                        <div class="bg-white rounded-xl p-12 text-center border border-dashed">
                            <p class="text-gray-500">Belum ada diskusi yang cocok dengan filter Anda.</p>
                        </div>
                    @else
                        @foreach($topics as $topic)
                            <a href="{{ route('forum.show', $topic->id) }}" class="block bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all hover:border-indigo-200 group">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="flex items-center space-x-2 mb-2">
                                            <span class="bg-indigo-50 text-indigo-600 text-[10px] px-2 py-1 rounded-full font-bold uppercase tracking-wide">{{ $topic->category }}</span>
                                            @if(!$topic->is_active)
                                                <span class="bg-red-50 text-red-600 text-[10px] px-2 py-1 rounded-full font-bold uppercase">🔒 Closed</span>
                                            @endif
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-800 mb-1 group-hover:text-indigo-600 transition-colors">{{ $topic->title }}</h3>
                                        <p class="text-gray-500 text-sm line-clamp-2">{{ $topic->description }}</p>
                                    </div>
                                    <div class="text-center min-w-[60px]">
                                        <div class="text-2xl font-bold text-gray-300">{{ $topic->replies_count }}</div>
                                        <div class="text-[10px] text-gray-400 uppercase">Balasan</div>
                                    </div>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-50 flex justify-between items-center text-xs text-gray-400">
                                    <div class="flex items-center">
                                        <img src="{{ $topic->user->avatar ? asset('storage/'.$topic->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($topic->user->name) }}" class="w-6 h-6 rounded-full mr-2">
                                        <span class="font-medium text-gray-600 mr-1">{{ $topic->user->name }}</span>
                                        <span>• {{ $topic->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex items-center text-green-600 font-bold">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" /></svg>
                                        {{ $topic->likes_count }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        <div class="mt-4">{{ $topics->appends(request()->query())->links() }}</div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
