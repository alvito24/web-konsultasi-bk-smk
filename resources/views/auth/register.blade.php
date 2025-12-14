<x-guest-layout>
    <div class="flex w-full max-w-4xl bg-white rounded-2xl shadow-xl overflow-hidden min-h-[500px]">

        <div class="hidden md:flex md:w-1/2 bg-pattern flex-col justify-center items-center text-white p-8 relative">
            <div class="absolute inset-0 bg-indigo-600 opacity-90"></div>
            <div class="relative z-10 text-center">
                <div class="mb-6 bg-white/20 p-4 rounded-full inline-block">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <h2 class="text-3xl font-bold mb-2">Daftar Akun Baru</h2>
                <p class="text-indigo-100 mb-6">Khusus untuk Siswa & Orang Tua.</p>
                <div class="bg-white/10 p-4 rounded-xl text-sm text-indigo-100 text-left">
                    <p class="mb-2">💡 <strong>Guru & Staf:</strong></p>
                    <p>Akun Guru dibuatkan oleh Admin. Silakan hubungi tata usaha jika belum memiliki akun.</p>
                </div>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center overflow-y-auto">
            <h3 class="text-2xl font-bold text-gray-800 mb-1">Buat Akun</h3>
            <p class="text-sm text-gray-500 mb-6">Isi data diri Anda dengan benar.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <x-input-label for="name" :value="__('Nama Lengkap')" />
                    <x-text-input id="name" class="block mt-1 w-full bg-gray-50 rounded-lg border-gray-300 focus:ring-indigo-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full bg-gray-50 rounded-lg border-gray-300 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full bg-gray-50 rounded-lg border-gray-300 focus:ring-indigo-500" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50 rounded-lg border-gray-300 focus:ring-indigo-500" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mb-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md" href="{{ route('login') }}">
                        {{ __('Sudah punya akun?') }}
                    </a>

                    <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 py-2 px-6 rounded-lg">
                        {{ __('Daftar') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
