<x-app-layout>
    <x-slot name="header">
        Tulis Jurnal Harian
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 text-white">
                    <h2 class="text-xl font-bold flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Jurnal Harian Baru
                    </h2>
                    <p class="text-blue-100 text-sm mt-1">Tuangkan perasaanmu hari ini. Jangan khawatir, privasimu aman.</p>
                </div>

                <div class="p-6">
                    <form action="{{ route('journal.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <x-input-label value="Siswa" />
                                <input type="text" value="{{ Auth::user()->name }}" disabled class="block mt-1 w-full bg-gray-100 border-gray-300 rounded-md text-gray-500 shadow-sm cursor-not-allowed">
                            </div>

                            <div>
                                <x-input-label for="is_public" value="Jenis Jurnal *" />
                                <select name="is_public" id="is_public" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="0">🔒 Private (Hanya saya yang baca)</option>
                                    <option value="1">📢 Public (Guru BK bisa baca & komen)</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Pilih "Public" jika kamu butuh saran dari Guru BK.</p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <x-input-label value="Bagaimana Mood-mu Hari Ini? *" />
                            <div class="grid grid-cols-5 gap-2 mt-2">
                                <label class="cursor-pointer">
                                    <input type="radio" name="mood" value="Senang" class="peer sr-only" required>
                                    <div class="text-center p-3 rounded-lg border hover:bg-gray-50 peer-checked:bg-yellow-100 peer-checked:border-yellow-400 peer-checked:scale-110 transition-all">
                                        <span class="text-2xl">😄</span>
                                        <p class="text-xs mt-1 font-medium">Senang</p>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="mood" value="Biasa" class="peer sr-only" required>
                                    <div class="text-center p-3 rounded-lg border hover:bg-gray-50 peer-checked:bg-gray-200 peer-checked:border-gray-400 peer-checked:scale-110 transition-all">
                                        <span class="text-2xl">😐</span>
                                        <p class="text-xs mt-1 font-medium">Biasa</p>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="mood" value="Sedih" class="peer sr-only" required>
                                    <div class="text-center p-3 rounded-lg border hover:bg-gray-50 peer-checked:bg-blue-100 peer-checked:border-blue-400 peer-checked:scale-110 transition-all">
                                        <span class="text-2xl">😢</span>
                                        <p class="text-xs mt-1 font-medium">Sedih</p>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="mood" value="Marah" class="peer sr-only" required>
                                    <div class="text-center p-3 rounded-lg border hover:bg-gray-50 peer-checked:bg-red-100 peer-checked:border-red-400 peer-checked:scale-110 transition-all">
                                        <span class="text-2xl">😡</span>
                                        <p class="text-xs mt-1 font-medium">Marah</p>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="mood" value="Cemas" class="peer sr-only" required>
                                    <div class="text-center p-3 rounded-lg border hover:bg-gray-50 peer-checked:bg-purple-100 peer-checked:border-purple-400 peer-checked:scale-110 transition-all">
                                        <span class="text-2xl">😰</span>
                                        <p class="text-xs mt-1 font-medium">Cemas</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="mb-6">
                            <x-input-label for="title" value="Judul Jurnal *" />
                            <x-text-input id="title" name="title" class="block mt-1 w-full" placeholder="Masukkan judul jurnal..." required />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="content" value="Deskripsi / Isi Jurnal *" />
                            <textarea id="content" name="content" rows="6" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Tuliskan apa yang kamu rasakan hari ini..." required></textarea>
                        </div>

                        <div class="mb-6 opacity-50">
                            <x-input-label value="Rekomendasi Guru BK" />
                            <textarea disabled class="block mt-1 w-full bg-gray-50 border-gray-200 rounded-md text-sm text-gray-400 resize-none" rows="2" placeholder="Field ini akan diisi oleh Guru BK setelah jurnal direview (Khusus Public)"></textarea>
                            <p class="text-xs text-gray-400 mt-1 italic">* Field ini hanya dapat diisi oleh Guru BK</p>
                        </div>

                        <div class="flex items-center justify-end space-x-3 border-t pt-6">
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                                Batal
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Simpan Jurnal
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
