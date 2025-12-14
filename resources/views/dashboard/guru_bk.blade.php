<x-app-layout>
    <x-slot name="header">Dashboard Guru BK</x-slot>

    <div class="bg-blue-600 rounded-xl shadow-lg p-6 mb-8 text-white flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Halo, {{ Auth::user()->name }}! 👋</h1>
            <p class="opacity-90">Pantau perkembangan siswa hari ini.</p>
        </div>
        <div class="flex space-x-6 text-center">
            <div class="bg-white/20 p-3 rounded-lg">
                <span class="block text-2xl font-bold">{{ $data['permintaan_masuk'] }}</span>
                <span class="text-xs opacity-75">Request Baru</span>
            </div>
            <div class="bg-white/20 p-3 rounded-lg">
                <span class="block text-2xl font-bold">{{ $data['slot_aktif'] }}</span>
                <span class="text-xs opacity-75">Slot Dibuka</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-4">Statistik Konseling</h3>
            <div class="h-64"><canvas id="bkChart"></canvas></div>
        </div>

        <div class="space-y-6">

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4 text-sm flex items-center">
                    <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                    Permintaan Masuk
                </h3>

                @if($pendingRequests->isEmpty())
                    <p class="text-xs text-gray-400">Tidak ada permintaan baru untuk jadwal Anda.</p>
                @else
                    <div class="space-y-4">
                        @foreach($pendingRequests as $req)
                        <div class="border-b border-gray-50 pb-3 last:border-0 last:pb-0">
                            <div class="mb-2">
                                <p class="text-sm font-bold text-gray-800">{{ $req->student->name }}</p>
                                <p class="text-xs text-gray-500">{{ $req->scheduled_at->format('d M, H:i') }} • {{ $req->type }}</p>
                                <p class="text-xs text-blue-600 mt-1">{{ $req->category }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <form action="{{ route('counseling.update-status', $req->id) }}" method="POST" class="w-full">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="w-full bg-green-100 text-green-700 text-xs py-1 rounded hover:bg-green-200 font-bold">Terima</button>
                                </form>
                                <form action="{{ route('counseling.update-status', $req->id) }}" method="POST" class="w-full">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="w-full bg-red-100 text-red-700 text-xs py-1 rounded hover:bg-red-200 font-bold">Tolak</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <a href="{{ route('admin.monitoring.schedules') }}" class="block p-3 rounded-lg bg-gray-50 text-gray-600 hover:bg-gray-100 transition-colors text-center text-sm font-bold border border-gray-200">
                🔍 Lihat Jadwal Guru Lain
            </a>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4 text-sm">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('counseling.schedule') }}" class="flex items-center p-3 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-sm font-bold">Kelola Jadwal</span>
                    </a>
                    <a href="{{ route('report.export_pdf') }}" class="flex items-center p-3 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        <span class="text-sm font-bold">Download Laporan</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('bkChart');
        const chartData = @json($chartData);
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(chartData),
                datasets: [{
                    label: 'Jumlah Konseling',
                    data: Object.values(chartData),
                    backgroundColor: 'rgba(59, 130, 246, 0.6)',
                    borderRadius: 5
                }]
            },
            options: { scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });
    </script>
</x-app-layout>
