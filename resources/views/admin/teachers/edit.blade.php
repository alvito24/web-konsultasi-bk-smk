<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Data Guru</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST" x-data="{ role: '{{ $teacher->role }}' }">
                    @csrf @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <x-input-label for="role" :value="__('Jabatan / Role')" />
                            <select name="role" id="role" x-model="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="guru_bk">Guru BK (Bimbingan Konseling)</option>
                                <option value="wali_kelas">Wali Kelas</option>
                            </select>
                        </div>

                        <div class="md:col-span-2" x-show="role === 'wali_kelas'" style="display: none;">
                            <x-input-label for="class_name" :value="__('Wali Kelas Untuk')" />
                            <x-text-input id="class_name" class="block mt-1 w-full" type="text" name="class_name" :value="old('class_name', $teacher->class_name)" placeholder="Contoh: XII RPL 1" />
                            <p class="text-xs text-gray-500 mt-1">* Wajib diisi untuk Wali Kelas.</p>
                            <x-input-error :messages="$errors->get('class_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="nis_nip" :value="__('NIP')" />
                            <x-text-input id="nis_nip" class="block mt-1 w-full" type="text" name="nis_nip" :value="old('nis_nip', $teacher->nis_nip)" required />
                        </div>

                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $teacher->name)" required />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $teacher->email)" required />
                        </div>
                    </div>

                    <div class="mt-6 border-t pt-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="reset_password" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-600">Reset Password ke Default (<code>guru123</code>).</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.teachers.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                        <x-primary-button>Update Data</x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
