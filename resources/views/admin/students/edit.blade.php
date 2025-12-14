<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Data Siswa</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="nis_nip" :value="__('NIS')" />
                            <x-text-input id="nis_nip" class="block mt-1 w-full" type="text" name="nis_nip" :value="old('nis_nip', $student->nis_nip)" required />
                        </div>

                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $student->name)" required />
                        </div>

                        <div>
                            <x-input-label for="class_name" :value="__('Kelas')" />
                            <x-text-input id="class_name" class="block mt-1 w-full" type="text" name="class_name" :value="old('class_name', $student->class_name)" required />
                        </div>

                        <div>
                            <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                            <select name="gender" id="gender" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="L" {{ old('gender', $student->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender', $student->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $student->email)" required />
                        </div>
                    </div>

                    <div class="mt-6 border-t pt-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="reset_password" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-600">Reset Password ke Default (<code>sekolah123</code>).</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.students.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                        <x-primary-button>Update Data</x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
