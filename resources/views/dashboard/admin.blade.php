<x-app-layout>
    <x-slot name="header">
        Dashboard Overview
    </x-slot>

    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg p-6 mb-8 text-white relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-2xl font-bold mb-2">Halo, {{ Auth::user()->name }}! 👋</h1>
            <p class="opacity-90">Selamat datang di Panel Admin Sistem Manajemen Konseling Sekolah.</p>
        </div>
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white opacity-10 rounded-full"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <a href="{{ route('admin.students.index') }}" class="block bg-white rounded-lg shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition-shadow cursor-pointer group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase group-hover:text-purple-600">Total Siswa</p>
                    <h3 class="text-3xl font-bold text-purple-600 mt-2">{{ $data['total_siswa'] }}</h3>
                </div>
                <div class="p-2 bg-purple-50 rounded-full text-purple-600">
                   <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.teachers.index') }}" class="block bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow cursor-pointer group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase group-hover:text-blue-600">Total Guru</p>
                    <h3 class="text-3xl font-bold text-blue-600 mt-2">{{ $data['total_guru'] }}</h3>
                </div>
                <div class="p-2 bg-blue-50 rounded-full text-blue-600">
                   <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.monitoring.schedules') }}" class="block bg-white rounded-lg shadow-sm p-6 border-l-4 border-indigo-500 hover:shadow-md transition-shadow cursor-pointer group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase group-hover:text-indigo-600">Jadwal Konseling</p>
                    <h3 class="text-3xl font-bold text-indigo-600 mt-2">{{ $data['jadwal_konseling'] }}</h3>
                </div>
                <div class="p-2 bg-indigo-50 rounded-full text-indigo-600">
                   <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.monitoring.bookings') }}" class="block bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition-shadow cursor-pointer group">
             <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase group-hover:text-green-600">Booking Aktif</p>
                    <h3 class="text-3xl font-bold text-green-600 mt-2">{{ $data['booking_aktif'] }}</h3>
                </div>
                <div class="p-2 bg-green-50 rounded-full text-green-600">
                   <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-6 flex items-center">
                Status Booking Konseling Hari Ini
            </h3>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-4">Tren Konseling Tahun Ini</h3>
            <div class="h-64">
                <canvas id="counselingChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Materi Terpopuler
            </h3>
            @if($topMaterials->isEmpty())
                <p class="text-sm text-gray-500">Belum ada data materi.</p>
            @else
                <ul class="space-y-4">
                    @foreach($topMaterials as $tm)
                    <li class="flex items-center justify-between border-b border-gray-50 pb-2">
                        <div class="flex items-center overflow-hidden">
                            <span class="text-lg font-bold text-gray-300 mr-3">#{{ $loop->iteration }}</span>
                            <div class="truncate">
                                <a href="{{ route('materials.show', $tm->id) }}" class="text-sm font-semibold text-gray-700 hover:text-blue-600 block truncate">{{ $tm->title }}</a>
                                <span class="text-xs text-gray-400">{{ $tm->category }}</span>
                            </div>
                        </div>
                        <div class="text-xs font-bold bg-blue-50 text-blue-600 px-2 py-1 rounded-full whitespace-nowrap">
                            {{ $tm->views_count }} views
                        </div>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="mb-6 flex justify-end">
        <a href="{{ route('report.export_pdf') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Export Laporan PDF
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('counselingChart');
        const chartData = @json($chartData); // Data dari Controller

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(chartData), // Nama Bulan
                datasets: [{
                    label: 'Jumlah Sesi Konseling',
                    data: Object.values(chartData), // Jumlah Data
                    backgroundColor: 'rgba(59, 130, 246, 0.5)', // Blue-500
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
    </script>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 rounded-xl bg-blue-50 border border-blue-100 flex flex-col items-center justify-center text-center">
                    <div class="text-blue-600 font-bold text-2xl mb-1">{{ $data['booking_on_progress'] }}</div>
                    <div class="text-xs text-blue-600 uppercase tracking-wide font-semibold">Sedang Berjalan</div>
                </div>
                <div class="p-4 rounded-xl bg-green-50 border border-green-100 flex flex-col items-center justify-center text-center">
                    <div class="text-green-600 font-bold text-2xl mb-1">{{ $data['booking_selesai'] }}</div>
                    <div class="text-xs text-green-600 uppercase tracking-wide font-semibold">Selesai</div>
                </div>
                <div class="p-4 rounded-xl bg-yellow-50 border border-yellow-100 flex flex-col items-center justify-center text-center">
                    <div class="text-yellow-600 font-bold text-2xl mb-1">{{ $data['booking_pending'] }}</div>
                    <div class="text-xs text-yellow-600 uppercase tracking-wide font-semibold">Pending</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-4">Akses Cepat</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.students.index') }}" class="flex items-center p-3 rounded-lg bg-gray-50 hover:bg-blue-50 hover:text-blue-600 transition-colors group cursor-pointer border border-transparent hover:border-blue-200">
                    <div class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-500 group-hover:text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-semibold">Kelola Data Siswa</p>
                        <p class="text-xs text-gray-500">Tambah atau edit siswa</p>
                    </div>
                </a>

                <a href="{{ route('admin.teachers.index') }}" class="flex items-center p-3 rounded-lg bg-gray-50 hover:bg-purple-50 hover:text-purple-600 transition-colors group cursor-pointer border border-transparent hover:border-purple-200">
                    <div class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-500 group-hover:text-purple-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-semibold">Kelola Data Guru</p>
                        <p class="text-xs text-gray-500">Tambah guru BK/Wali</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
