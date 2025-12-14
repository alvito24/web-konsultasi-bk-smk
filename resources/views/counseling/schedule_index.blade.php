<x-app-layout>
    <x-slot name="header">
        Manajemen Jadwal Konseling
    </x-slot>

    <div class="py-6" x-data="{ showForm: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Atur Jadwal Anda</h2>
                    <p class="text-sm text-gray-500">Kelola ketersediaan waktu dan konfirmasi permintaan siswa.</p>
                </div>

                <button @click="showForm = !showForm"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow-sm flex items-center">
                    <span x-text="showForm ? 'Tutup Form' : '+ Tambah Slot Baru'"></span>
                </button>
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">{{ session('error') }}</div>
            @endif

            <div x-show="showForm" style="display: none;" class="bg-white rounded-xl shadow-sm p-6 border-t-4 border-blue-500 mb-8">
                <form action="{{ route('schedule.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <x-input-label :value="__('Hari Konseling')" />
                            <input type="date" name="date" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required min="{{ date('Y-m-d') }}">
                        </div>
                        <div>
                            <x-input-label :value="__('Jam / Sesi')" />
                            <select name="time_slot" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="08:00 - 09:00">08:00 - 09:00 (Sesi 1)</option>
                                <option value="09:00 - 10:00">09:00 - 10:00 (Sesi 2)</option>
                                <option value="10:00 - 11:00">10:00 - 11:00 (Sesi 3)</option>
                                <option value="13:00 - 14:00">13:00 - 14:00 (Sesi 4)</option>
                                <option value="14:00 - 15:00">14:00 - 15:00 (Sesi 5)</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label :value="__('Ruangan')" />
                            <select name="room_number" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="R. Konseling 1">Ruang Konseling 1</option>
                                <option value="R. Konseling 2">Ruang Konseling 2</option>
                                <option value="Online (GMeet)">Online (Google Meet)</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <x-primary-button>Simpan Jadwal</x-primary-button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-yellow-200">
                        <div class="p-4 bg-yellow-50 border-b border-yellow-100 rounded-t-xl">
                            <h3 class="font-bold text-yellow-800">Permintaan Masuk ({{ count($incomingRequests) }})</h3>
                        </div>
                        <div class="p-4 space-y-4">
                            @forelse($incomingRequests as $req)
                                <div class="border border-gray-100 rounded-lg p-3 bg-white">
                                    <div class="mb-3">
                                        <p class="font-bold text-gray-800 text-sm">{{ $req->student->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $req->scheduled_at->format('d M Y, H:i') }}</p>
                                        <p class="text-xs text-blue-600 mt-1 font-semibold">{{ $req->category }}</p>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <a href="{{ route('counseling.show_session', $req->id) }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold underline">
                                            Lihat Detail Masalah &rsaquo;
                                        </a>
                                    </div>

                                    <div class="flex gap-2">
                                        <form action="{{ route('counseling.update-status', $req->id) }}" method="POST" class="w-full">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button class="w-full bg-green-500 text-white text-xs py-2 rounded font-bold hover:bg-green-600">Terima</button>
                                        </form>
                                        <form action="{{ route('counseling.update-status', $req->id) }}" method="POST" class="w-full">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button class="w-full bg-red-100 text-red-600 text-xs py-2 rounded font-bold hover:bg-red-200">Tolak</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-400 text-center py-4">Tidak ada permintaan baru.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-6 flex justify-between">
                            <span>Jadwal Aktif Saya</span>
                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">{{ count($mySchedules) }} Slot</span>
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($mySchedules as $s)
                                @if($s->is_booked && $s->session)
                                    <a href="{{ route('counseling.show_session', $s->session->id) }}" 
                                       class="block border rounded-lg p-4 bg-indigo-50 border-indigo-200 hover:shadow-md transition-all relative group">
                                @else
                                    <div class="border rounded-lg p-4 bg-white hover:border-blue-300 transition-all">
                                @endif
                                
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-bold text-gray-800">{{ $s->date->format('l, d M Y') }}</p>
                                            <p class="text-sm text-blue-600 font-semibold">{{ $s->time_slot }}</p>

                                            @if($s->is_booked && $s->session)
                                                <div class="mt-2 text-xs text-indigo-700 bg-indigo-100 px-2 py-1 rounded inline-block">
                                                    👤 {{ $s->session->student->name }}
                                                </div>
                                                <div class="text-[10px] text-indigo-400 mt-1 italic group-hover:text-indigo-600">
                                                    (Klik untuk detail sesi)
                                                </div>
                                            @else
                                                <p class="text-xs text-gray-500 mt-1 flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                    {{ $s->room_number }}
                                                </p>
                                            @endif
                                        </div>

                                        <div class="text-right">
                                            @if($s->is_booked)
                                                <span class="px-2 py-1 bg-indigo-600 text-white text-xs rounded font-bold shadow-sm">Booked</span>
                                            @else
                                                <span class="px-2 py-1 bg-green-200 text-green-800 text-xs rounded font-bold">Available</span>
                                                <form action="{{ route('schedule.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal?');" class="mt-2 text-right">
                                                    @csrf @method('DELETE')
                                                    <button class="text-red-400 hover:text-red-600 text-xs underline">Hapus</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                
                                @if($s->is_booked && $s->session)
                                    </a>
                                @else
                                    </div>
                                @endif

                            @empty
                                <div class="col-span-2 text-center py-12 text-gray-400 border border-dashed rounded-lg">
                                    Belum ada slot jadwal yang dibuka.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
</x-app-layout>