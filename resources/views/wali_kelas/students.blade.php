<x-app-layout>
    <x-slot name="header">
        Data Siswa Kelas {{ $myClass }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Anak Didik</h3>

                    @if($students->isEmpty())
                        <p class="text-gray-500">Belum ada data siswa di kelas {{ $myClass }}.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Nama Lengkap</th>
                                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">NIS</th>
                                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">No. HP</th>
                                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Minat</th>
                                        <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Cita-cita</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($students as $student)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 font-bold text-gray-700">
                                            <div class="flex items-center">
                                                <img src="{{ $student->avatar ? asset('storage/'.$student->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($student->name) }}" class="w-8 h-8 rounded-full mr-3">
                                                {{ $student->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-500">{{ $student->nis_nip }}</td>
                                        <td class="px-6 py-4 text-gray-500">{{ $student->phone ?? '-' }}</td>
                                        <td class="px-6 py-4 text-gray-500">{{Str::limit($student->interests, 20) ?? '-' }}</td>
                                        <td class="px-6 py-4 text-gray-500">{{ $student->career_goals ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
