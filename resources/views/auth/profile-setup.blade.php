<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        <h2 class="text-xl font-bold text-gray-800 mb-2">Halo, {{ Auth::user()->name }}! 👋</h2>
        <p>Demi keamanan dan kelengkapan data, silakan lengkapi profil Anda dan buat password baru sebelum melanjutkan.</p>
    </div>

    <form method="POST" action="{{ route('profile.setup.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <x-input-label for="avatar" :value="__('Foto Profil (Wajib)')" />
            <input id="avatar" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="avatar" required accept="image/*">
            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="phone" :value="__('Nomor WhatsApp')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required placeholder="08xxxxxxxx" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        @if(Auth::user()->role === 'siswa')
            <div class="mb-4">
                <x-input-label for="interests" :value="__('Minat & Bakat')" />
                <textarea id="interests" name="interests" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="2" placeholder="Contoh: Musik, Coding, Futsal" required>{{ old('interests') }}</textarea>
                <x-input-error :messages="$errors->get('interests')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="career_goals" :value="__('Rencana Karir')" />
                <select id="career_goals" name="career_goals" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="">Pilih Rencana Karir...</option>
                    <option value="Kuliah">Kuliah</option>
                    <option value="Kerja">Bekerja</option>
                    <option value="Wirausaha">Wirausaha</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
        @endif

        <hr class="my-6 border-gray-200">
        <p class="text-xs text-gray-500 mb-4 font-bold uppercase">Buat Password Baru</p>

        <div class="mb-4">
            <x-input-label for="password" :value="__('Password Baru')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Simpan & Masuk Dashboard') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
