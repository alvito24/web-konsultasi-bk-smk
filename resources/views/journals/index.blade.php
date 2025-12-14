<x-app-layout>
    <x-slot name="header">
        Riwayat Jurnal Harian
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-800">Daftar Jurnal Saya</h3>
                <a href="{{ route('journal.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 shadow-sm">
                    + Tulis Jurnal Baru
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($journals->isEmpty())
                <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                    <p class="text-gray-500 mb-4">Kamu belum menulis jurnal apapun.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($journals as $journal)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="text-3xl">
                                        @switch($journal->mood)
                                            @case('Senang') 😄 @break
                                            @case('Sedih') 😢 @break
                                            @case('Marah') 😡 @break
                                            @case('Cemas') 😰 @break
                                            @default 😐
                                        @endswitch
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-lg">{{ $journal->title }}</h4>
                                        <p class="text-xs text-gray-500">{{ $journal->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                                <span class="px-2 py-1 text-xs font-bold rounded-full {{ $journal->is_public ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $journal->is_public ? '📢 Public' : '🔒 Private' }}
                                </span>
                            </div>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $journal->content }}
                            </p>

                            @if($journal->teacher_feedback)
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 mt-4">
                                    <p class="text-xs text-yellow-800 font-bold mb-1">Rekomendasi Guru BK:</p>
                                    <p class="text-xs text-gray-700 italic">"{{ $journal->teacher_feedback }}"</p>
                                </div>
                            @endif

                            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end space-x-2">
                                <a href="{{ route('journal.edit', $journal->id) }}" class="text-xs bg-yellow-100 text-yellow-700 px-3 py-1 rounded-md hover:bg-yellow-200 transition-colors font-semibold">
                                    Edit
                                </a>
                                <form action="{{ route('journal.destroy', $journal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jurnal ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs bg-red-100 text-red-700 px-3 py-1 rounded-md hover:bg-red-200 transition-colors font-semibold">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $journals->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
