<x-app-layout>
    <x-slot name="header">
        Booking Konseling Baru
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-blue-600 rounded-xl shadow-lg p-6 mb-8 text-white flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Pilih Jadwal Konseling 📅</h1>
                    <p class="opacity-90">Klik pada kartu jadwal yang kamu inginkan di bawah ini.</p>
                </div>
            </div>

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('counseling.store') }}">
                @csrf

                @if($availableSchedules->isEmpty())
                    <div class="bg-white rounded-xl shadow-sm p-12 text-center border border-dashed border-gray-300">
                        <div class="mb-4">
                            <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Belum Ada Jadwal Tersedia</h3>
                        <p class="text-gray-500 mb-6">Guru BK belum membuka slot jadwal baru.</p>
                        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Kembali ke Dashboard</a>
                    </div>
                @else

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                        <div class="md:col-span-2 space-y-4">
                            <h3 class="font-bold text-gray-800 text-lg">1. Klik Salah Satu Jadwal:</h3>

                            <div class="grid grid-cols-1 gap-4">
                                @foreach($availableSchedules as $schedule)
                                <div class="relative">
                                    <input type="radio" id="sched_{{ $schedule->id }}" name="schedule_id" value="{{ $schedule->id }}" class="peer sr-only" required>

                                    <label for="sched_{{ $schedule->id }}"
                                           class="block cursor-pointer p-5 rounded-xl border-2 transition-all duration-200 ease-in-out
                                                  border-gray-200 bg-white hover:border-blue-300 hover:shadow-md
                                                  peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:shadow-lg peer-checked:ring-1 peer-checked:ring-blue-600">

                                        <div class="flex justify-between items-center">
                                            <div class="flex items-center">
                                                <div class="bg-gray-100 text-gray-500 rounded-lg p-3 mr-4 transition-colors peer-checked:bg-blue-200 peer-checked:text-blue-700">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                                <div>
                                                    <h4 class="text-lg font-bold text-gray-800">
                                                        {{ $schedule->date->format('l, d F Y') }}
                                                    </h4>
                                                    <p class="text-sm text-gray-500 font-medium">
                                                        Pukul <span class="text-gray-900 font-bold">{{ $schedule->time_slot }}</span>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="text-gray-300">
                                                <svg class="w-8 h-8 hidden text-blue-600 check-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>

                                                <svg class="w-6 h-6 uncheck-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                        </div>

                                        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                Konselor: <span class="font-semibold ml-1 text-gray-700">{{ $schedule->counselor->name }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                Lokasi: <span class="font-semibold ml-1 text-gray-700">{{ $schedule->room_number }}</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm sticky top-24">
                                <h3 class="font-bold text-gray-800 mb-4 text-lg">2. Detail Masalah</h3>

                                <div class="mb-4">
                                    <x-input-label for="category" :value="__('Topik Permasalahan')" />
                                    <select name="category" id="category" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm" required>
                                        <option value="">-- Pilih Topik --</option>
                                        <option value="Akademik">Akademik (Nilai, Jurusan)</option>
                                        <option value="Pribadi">Pribadi (Keluarga, Diri Sendiri)</option>
                                        <option value="Sosial">Sosial (Teman, Bullying)</option>
                                        <option value="Karir">Karir & Masa Depan</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <div class="mb-6">
                                    <x-input-label for="problem_description" :value="__('Cerita Singkat (Opsional)')" />
                                    <textarea id="problem_description" name="problem_description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm" placeholder="Apa yang ingin kamu diskusikan?"></textarea>
                                </div>

                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transform transition hover:-translate-y-1">
                                    Ajukan Booking Sekarang 🚀
                                </button>
                                <p class="text-xs text-gray-400 mt-3 text-center">Permintaan akan dikirim ke Guru BK terkait.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <style>
        input:checked + label .check-icon { display: block; }
        input:checked + label .uncheck-icon { display: none; }
        input:checked + label .bg-gray-100 { background-color: #BFDBFE; color: #1D4ED8; } /* Biru Muda */
    </style>
</x-app-layout>
