<x-app-layout>
    <x-slot name="header">Dashboard Wali Kelas</x-slot>

    <div class="bg-indigo-600 rounded-xl shadow-lg p-6 mb-8 text-white">
        <h1 class="text-2xl font-bold">Halo, {{ Auth::user()->name }}! 👋</h1>
        <p class="opacity-90">Pantau aktivitas siswa kelas Anda.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-4">Statistik Konseling Sekolah</h3>
            <div class="h-64"><canvas id="waliChart"></canvas></div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4 text-sm">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('journal.review') }}" class="flex items-center p-3 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <span class="text-sm font-bold">Review Jurnal Siswa</span>
                    </a>

                    <a href="{{ route('counseling.create') }}" class="flex items-center p-3 rounded-lg bg-green-50 text-green-700 hover:bg-green-100 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-sm font-bold">Booking Konseling</span>
                    </a>

                    <a href="{{ route('wali.students') }}" class="flex items-center p-3 rounded-lg bg-purple-50 text-purple-700 hover:bg-purple-100 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="text-sm font-bold">Data Siswa Saya</span>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4 text-sm">Materi Populer</h3>
                @if($topMaterials->isEmpty())
                    <p class="text-xs text-gray-400">Belum ada data.</p>
                @else
                    <ul class="space-y-3">
                        @foreach($topMaterials as $tm)
                        <li class="flex justify-between items-center text-xs border-b border-gray-50 pb-2">
                            <span class="text-gray-700 truncate w-40">{{ $tm->title }}</span>
                            <span class="text-gray-400">{{ $tm->views_count }} views</span>
                        </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('waliChart');
        const chartData = @json($chartData);
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: Object.keys(chartData),
                datasets: [{
                    label: 'Tren Konseling',
                    data: Object.values(chartData),
                    borderColor: '#4F46E5',
                    tension: 0.3,
                    fill: true,
                    backgroundColor: 'rgba(79, 70, 229, 0.1)'
                }]
            },
            options: { scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });
    </script>
</x-app-layout>
