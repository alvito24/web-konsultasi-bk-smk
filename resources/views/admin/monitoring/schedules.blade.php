<x-app-layout>
    <x-slot name="header">
        Monitoring Jadwal Konseling
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Semua Jadwal Guru BK</h3>

                    @if($schedules->isEmpty())
                        <p class="text-gray-500 text-center py-4">Belum ada jadwal yang dibuka oleh Guru BK.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Guru BK</th>
                                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Tanggal</th>
                                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Sesi</th>
                                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Ruangan</th>
                                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($schedules as $s)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 font-bold text-gray-700">{{ $s->counselor->name }}</td>
                                        <td class="px-6 py-4">{{ $s->date->format('d M Y') }}</td>
                                        <td class="px-6 py-4">{{ $s->time_slot }}</td>
                                        <td class="px-6 py-4">{{ $s->room_number }}</td>
                                        <td class="px-6 py-4">
                                            @if($s->is_booked)
                                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded-full">Booked</span>
                                            @else
                                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">Open</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $schedules->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
