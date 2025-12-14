<x-app-layout>
    <x-slot name="header">
        Monitoring Booking Aktif
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Konseling Berjalan</h3>

                    @if($bookings->isEmpty())
                        <p class="text-gray-500 text-center py-4">Tidak ada sesi konseling yang sedang aktif.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Siswa</th>
                                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Guru BK</th>
                                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Waktu Konseling</th>
                                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Tipe</th>
                                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($bookings as $b)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-700">{{ $b->student->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $b->student->class_name }}</div>
                                        </td>
                                        <td class="px-6 py-4">{{ $b->counselor->name ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $b->scheduled_at->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4 uppercase text-xs font-bold">{{ $b->type }}</td>
                                        <td class="px-6 py-4">
                                            @if($b->status == 'pending')
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full">Menunggu</span>
                                            @elseif($b->status == 'approved')
                                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">Disetujui</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $bookings->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
