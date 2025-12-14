<x-app-layout>
    <x-slot name="header">
        Buat Topik Diskusi
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-8 border border-indigo-100">

                <h2 class="text-xl font-bold text-gray-800 mb-6">Mulai Diskusi Baru</h2>

                <form action="{{ route('forum.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <x-input-label value="Judul Diskusi *" />
                        <x-text-input name="title" class="block mt-1 w-full" placeholder="Contoh: Tips Mengatur Waktu Belajar" required />
                    </div>

                    <div class="mb-6">
                        <x-input-label value="Kategori *" />
                        <select name="category" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="Umum">Umum</option>
                            <option value="Akademik">Akademik</option>
                            <option value="Motivasi">Motivasi</option>
                            <option value="Info Sekolah">Info Sekolah</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <x-input-label value="Isi Diskusi *" />
                        <textarea name="description" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Tuliskan topik yang ingin dibahas..." required></textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('forum.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase">Batal</a>
                        <x-primary-button>Terbitkan Diskusi</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
