<x-app-layout>
    <x-slot name="header">Detail Diskusi</x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('forum.index') }}" class="inline-flex items-center text-gray-500 hover:text-indigo-600 mb-6">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg> Kembali
            </a>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                <div class="p-6 md:p-8">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $forum->user->avatar ? asset('storage/'.$forum->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($forum->user->name) }}" class="w-12 h-12 rounded-full object-cover">
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $forum->user->name }}</h4>
                                <p class="text-xs text-gray-500">{{ $forum->user->role == 'guru_bk' ? 'Guru BK' : ($forum->user->role == 'wali_kelas' ? 'Wali Kelas' : 'Siswa') }} • {{ $forum->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        @if(Auth::user()->role === 'admin' || Auth::id() === $forum->user_id)
                            <form action="{{ route('forum.toggle', $forum->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-xs font-bold px-3 py-1 rounded-full border {{ $forum->is_active ? 'border-red-200 text-red-600 hover:bg-red-50' : 'border-green-200 text-green-600 hover:bg-green-50' }}">
                                    {{ $forum->is_active ? '⛔ Tutup Diskusi' : '✅ Buka Diskusi' }}
                                </button>
                            </form>
                        @endif
                    </div>

                    <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $forum->title }}</h1>
                    <div class="prose max-w-none text-gray-600 leading-relaxed bg-gray-50 p-6 rounded-lg mb-4">
                        {!! nl2br(e($forum->description)) !!}
                    </div>

                    <div class="flex items-center gap-4 border-t pt-4">
                        <form action="{{ route('forum.topic.like', $forum->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center px-4 py-2 rounded-full border transition-all transform active:scale-95
                                {{ $forum->isLikedByAuthUser() ? 'bg-indigo-100 text-indigo-700 border-indigo-200' : 'bg-white text-gray-500 border-gray-200 hover:bg-gray-50' }}">
                                <svg class="w-5 h-5 mr-2" fill="{{ $forum->isLikedByAuthUser() ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                <span class="font-bold">{{ $forum->likes_count }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="font-bold text-gray-700 mb-4 text-lg">Komentar ({{ $forum->replies->count() }})</h3>
                <div class="space-y-4">
                    @foreach($forum->replies as $reply)
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0">
                                <img src="{{ $reply->user->avatar ? asset('storage/'.$reply->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($reply->user->name) }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                            </div>
                            <div class="flex-grow">
                                <div class="bg-white p-4 rounded-r-xl rounded-bl-xl shadow-sm border border-gray-100 relative group">
                                    <div class="flex justify-between items-start mb-2">
                                        <h5 class="font-bold text-sm text-gray-800">{{ $reply->user->name }} <span class="text-xs font-normal text-gray-400 ml-1">{{ $reply->created_at->diffForHumans() }}</span></h5>

                                        @if(Auth::user()->role === 'admin' || Auth::id() === $reply->user_id || Auth::id() === $forum->user_id)
                                            <form action="{{ route('forum.reply.destroy', $reply->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600" onclick="return confirm('Hapus?')">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    <p class="text-gray-700 text-sm mb-3">{{ $reply->content }}</p>

                                    <form action="{{ route('forum.reply.like', $reply->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="flex items-center text-xs transition-colors {{ $reply->isLikedByAuthUser() ? 'text-indigo-600 font-bold' : 'text-gray-400 hover:text-indigo-500' }}">
                                            <svg class="w-4 h-4 mr-1" fill="{{ $reply->isLikedByAuthUser() ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                            {{ $reply->likes_count > 0 ? $reply->likes_count : 'Suka' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if($forum->is_active)
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 sticky bottom-6">
                    <form action="{{ route('forum.reply', $forum->id) }}" method="POST" class="flex gap-4 items-center">
                        @csrf
                        <div class="flex-grow">
                            <input type="text" name="content" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-full px-4 py-2 shadow-sm" placeholder="Tulis komentar balasan..." required>
                        </div>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-full shadow-md">
                            <svg class="w-6 h-6 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
