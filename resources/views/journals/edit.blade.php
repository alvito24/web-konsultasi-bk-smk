<x-app-layout>
    <x-slot name="header">
        Edit Jurnal Harian
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">

                <div class="bg-yellow-500 p-6 text-white">
                    <h2 class="text-xl font-bold flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit Jurnal
                    </h2>
                </div>

                <div class="p-6">
                    <form action="{{ route('journal.update', $journal->id) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <x-input-label value="Siswa" />
                                <input type="text" value="{{ Auth::user()->name }}" disabled class="block mt-1 w-full bg-gray-100 border-gray-300 rounded-md text-gray-500 shadow-sm cursor-not-allowed">
                            </div>

                            <div>
                                <x-input-label for="is_public" value="Jenis Jurnal *" />
                                <select name="is_public" id="is_public" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="0" {{ !$journal->is_public ? 'selected' : '' }}>🔒 Private</option>
                                    <option value="1" {{ $journal->is_public ? 'selected' : '' }}>📢 Public</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-6">
                            <x-input-label value="Mood Saat Itu *" />
                            <div class="grid grid-cols-5 gap-2 mt-2">
                                @foreach(['Senang', 'Biasa', 'Sedih', 'Marah', 'Cemas'] as $mood)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="mood" value="{{ $mood }}" class="peer sr-only" {{ $journal->mood == $mood ? 'checked' : '' }}>
                                        <div class="text-center p-3 rounded-lg border hover:bg-gray-50 peer-checked:bg-blue-100 peer-checked:border-blue-400 peer-checked:font-bold transition-all">
                                            <p class="text-xs mt-1">{{ $mood }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-6">
                            <x-input-label for="title" value="Judul Jurnal *" />
                            <x-text-input id="title" name="title" class="block mt-1 w-full" value="{{ old('title', $journal->title) }}" required />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="content" value="Isi Jurnal *" />
                            <textarea id="content" name="content" rows="6" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>{{ old('content', $journal->content) }}</textarea>
                        </div>

                        <div class="flex items-center justify-end space-x-3 border-t pt-6">
                            <a href="{{ route('journal.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <x-primary-button>Update Jurnal</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
