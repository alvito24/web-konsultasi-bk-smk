<x-app-layout>
    <x-slot name="header">Detail Sesi Konseling</x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('counseling.schedule') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 mb-6 font-bold transition">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Jadwal
            </a>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">

                <div class="bg-indigo-600 p-6 text-white flex items-center">
                    <img src="{{ $session->student->avatar ? asset('storage/'.$session->student->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($session->student->name) }}" class="w-16 h-16 rounded-full mr-4 border-2 border-white shadow-sm object-cover">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $session->student->name }}</h2>
                        <p class="opacity-90">{{ $session->student->class_name }} • {{ $session->student->nis_nip }}</p>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-2 gap-4 border-b border-gray-100 pb-6">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold">Waktu Konseling</p>
                            <p class="text-gray-800 font-semibold mt-1">{{ $session->scheduled_at->format('l, d F Y') }}</p>
                            <p class="text-sm text-gray-600">{{ $session->scheduled_at->format('H:i') }} WIB</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold">Kategori</p>
                            <span class="inline-block mt-1 bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-bold">{{ $session->category }}</span>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold mb-2">Keluhan / Deskripsi Masalah</p>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-gray-700 italic">
                            "{{ $session->problem_description }}"
                        </div>
                    </div>

                    @if($session->status !== 'completed')
                        <div class="pt-4 border-t border-gray-100">
                            <h3 class="font-bold text-gray-800 mb-4 text-lg">Selesaikan Sesi</h3>
                            <form action="{{ route('counseling.update-status', $session->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="completed">

                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Catatan Konselor (Feedback):</label>
                                    <textarea name="counselor_notes" rows="4" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" placeholder="Tulis hasil konseling di sini..." required></textarea>
                                </div>

                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg shadow-lg transition transform hover:-translate-y-1">
                                    ✅ Tandai Selesai & Simpan
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-lg text-center font-bold">
                            Sesi ini sudah selesai.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
