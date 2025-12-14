<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Guru Baru</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="mb-6 bg-blue-50 p-4 rounded-md border-l-4 border-blue-500">
                    <p class="text-sm text-blue-700">
                        <strong>Info:</strong> Password default guru adalah <code>guru123</code>.
                    </p>
                </div>

                <form action="{{ route('admin.teachers.store') }}" method="POST" x-data="{ role: 'guru_bk' }">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <x-input-label for="role" :value="__('Jabatan / Role *')" />
                            <select name="role" id="role" x-model="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="guru_bk">Guru BK (Bimbingan Konseling)</option>
                                <option value="wali_kelas">Wali Kelas</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <div class="md:col-span-2" x-show="role === 'wali_kelas'" style="display: none;">
                            <x-input-label for="class_name" :value="__('Wali Kelas Untuk (Contoh: XII RPL 1)')" />
                            <x-text-input id="class_name" class="block mt-1 w-full" type="text" name="class_name" :value="old('class_name')" placeholder="Masukkan nama kelas yang diampu" />
                            <p class="text-xs text-gray-500 mt-1">* Wajib diisi untuk Wali Kelas agar bisa melihat data siswa.</p>
                            <x-input-error :messages="$errors->get('class_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="nis_nip" :value="__('NIP (Nomor Induk Pegawai) *')" />
                            <x-text-input id="nis_nip" class="block mt-1 w-full" type="text" name="nis_nip" :value="old('nis_nip')" required />
                            <x-input-error :messages="$errors->get('nis_nip')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap *')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="email" :value="__('Email Sekolah *')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 border-t pt-4">
                        <a href="{{ route('admin.teachers.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                        <x-primary-button>Simpan Data Guru</x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
