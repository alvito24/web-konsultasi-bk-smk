<x-app-layout>
    <x-slot name="header">
        Tambah Bank Materi Konseling
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-8 border border-blue-100">

                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Tambah Bank Materi Baru
                </h2>

                <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data" x-data="{ type: 'file' }">
                    @csrf

                    <div class="mb-6">
                        <x-input-label value="Judul Materi *" />
                        <x-text-input name="title" class="block mt-1 w-full" placeholder="Masukkan judul materi konseling" required />
                    </div>

                    <div class="mb-6">
                        <x-input-label value="Kategori / Tema *" />
                        <select name="category" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="Kesehatan Mental">Kesehatan Mental</option>
                            <option value="Motivasi Belajar">Motivasi Belajar</option>
                            <option value="Pergaulan Remaja">Pergaulan Remaja</option>
                            <option value="Karir & Masa Depan">Karir & Masa Depan</option>
                            <option value="Bahaya Narkoba">Bahaya Narkoba</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <x-input-label value="Deskripsi Singkat *" />
                        <textarea name="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" placeholder="Tuliskan deskripsi materi..." required></textarea>
                    </div>

                    <div class="mb-6 border rounded-xl p-6 bg-gray-50">
                        <x-input-label value="Konten Materi *" class="mb-4" />

                        <div class="flex space-x-4 mb-6">
                            <label class="cursor-pointer">
                                <input type="radio" name="type_selection" value="file" class="peer sr-only" x-model="type">
                                <div class="px-4 py-2 rounded-full border transition-all text-sm font-bold"
                                     :class="type === 'file' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-600 hover:bg-gray-100'">
                                    📁 Upload File
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="type_selection" value="youtube" class="peer sr-only" x-model="type">
                                <div class="px-4 py-2 rounded-full border transition-all text-sm font-bold"
                                     :class="type === 'youtube' ? 'bg-red-600 text-white border-red-600' : 'bg-white text-gray-600 hover:bg-gray-100'">
                                    ▶ Link YouTube
                                </div>
                            </label>
                        </div>

                        <div x-show="type === 'file'" class="transition-all">
                            <div class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white hover:bg-blue-50 hover:border-blue-300 relative">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p class="text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                    <p class="text-xs text-gray-500">PDF, PNG, JPG, atau Video (Maks. 50MB)</p>
                                </div>
                                <input name="file_upload" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".pdf,.jpg,.jpeg,.png,.mp4">
                            </div>
                        </div>

                        <div x-show="type === 'youtube'" style="display: none;">
                            <x-text-input name="youtube_link" class="block w-full" placeholder="https://www.youtube.com/watch?v=..." />
                            <p class="text-xs text-gray-500 mt-2">Salin dan tempelkan link video YouTube di sini.</p>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('materials.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase">Batal</a>
                        <x-primary-button>Simpan Materi</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
