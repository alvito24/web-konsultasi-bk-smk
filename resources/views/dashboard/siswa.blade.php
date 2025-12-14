<x-app-layout>
    <x-slot name="header">
        Dashboard Siswa
    </x-slot>

    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg p-6 mb-8 text-white relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-2xl font-bold mb-2">Hai, {{ Auth::user()->name }}! 👋</h1>
            <p class="opacity-90">Bagaimana perasaanmu hari ini? Jangan ragu untuk bercerita kepada Guru BK ya.</p>
        </div>
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white opacity-10 rounded-full"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('counseling.create') }}" class="group bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all cursor-pointer flex items-center hover:border-blue-300">
                    <div class="p-4 bg-blue-100 text-blue-600 rounded-full mr-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-800">Booking Konseling</h3>
                        <p class="text-sm text-gray-500">Buat janji temu dengan Guru BK</p>
                    </div>
                </a>

                <a href="{{ route('journal.index') }}" class="group bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all cursor-pointer flex items-center hover:border-purple-300">
                    <div class="p-4 bg-purple-100 text-purple-600 rounded-full mr-4 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-800">Tulis Jurnal</h3>
                        <p class="text-sm text-gray-500">Ceritakan harimu hari ini</p>
                    </div>
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Riwayat Konseling Terakhir
                </h3>

                @if($histories->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-400 mb-2">Belum ada riwayat konseling.</p>
                        <a href="{{ route('counseling.create') }}" class="text-blue-600 hover:underline text-sm">Ajukan sekarang?</a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600">
                            <thead class="bg-gray-50 text-gray-700 uppercase font-bold text-xs">
                                <tr>
                                    <th class="px-4 py-3">Tanggal</th>
                                    <th class="px-4 py-3">Topik</th>
                                    <th class="px-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($histories as $h)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        {{ \Carbon\Carbon::parse($h->scheduled_at)->format('d M Y, H:i') }}
                                        <br>
                                        <span class="text-[10px] bg-gray-100 px-1 rounded">{{ ucfirst($h->type) }}</span>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $h->category }}</td>
                                    <td class="px-4 py-3">
                                        @if($h->status == 'pending')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full">Menunggu</span>
                                        @elseif($h->status == 'approved')
                                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">Disetujui</span>
                                        @elseif($h->status == 'completed')
                                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">Selesai</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded-full">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}"
                     alt="Avatar"
                     class="w-24 h-24 rounded-full mx-auto mb-4 object-cover border-4 border-blue-50">

                <h2 class="text-xl font-bold text-gray-800">{{ Auth::user()->name }}</h2>
                <p class="text-sm text-gray-500 mb-4">{{ Auth::user()->class_name }}</p>

                <div class="border-t pt-4 text-left space-y-2">
                    <div>
                        <span class="text-xs text-gray-400 uppercase font-bold">NIS</span>
                        <p class="text-sm font-medium">{{ Auth::user()->nis_nip }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 uppercase font-bold">Cita-cita</span>
                        <p class="text-sm font-medium">{{ Auth::user()->career_goals ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 uppercase font-bold">Minat</span>
                        <p class="text-sm font-medium">{{ Auth::user()->interests ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
