<x-guest-layout>
    <div class="flex w-full max-w-4xl bg-white rounded-2xl shadow-xl overflow-hidden min-h-[500px]">

        <div class="hidden md:flex md:w-1/2 bg-pattern flex-col justify-center items-center text-white p-8 relative">
            <div class="absolute inset-0 bg-blue-600 opacity-90"></div>
            <div class="relative z-10 text-center">
                <div class="mb-6 bg-white/20 p-4 rounded-full inline-block">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h2 class="text-3xl font-bold mb-2">Selamat Datang!</h2>
                <p class="text-blue-100 mb-6">Sistem Informasi Bimbingan & Konseling Sekolah.</p>
                <div class="space-y-2 text-sm text-blue-200 text-left mx-auto max-w-xs">
                    <p class="flex items-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Konseling Terjadwal</p>
                    <p class="flex items-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Jurnal Harian Siswa</p>
                    <p class="flex items-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Privasi Terjamin</p>
                </div>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-1">Masuk Akun</h3>
            <p class="text-sm text-gray-500 mb-8">Silakan login untuk melanjutkan.</p>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full bg-gray-50 border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-lg" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@sekolah.sch.id" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full bg-gray-50 border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-lg" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 hover:text-blue-800 font-medium" href="{{ route('password.request') }}">
                            {{ __('Lupa password?') }}
                        </a>
                    @endif
                </div>

                <x-primary-button class="w-full justify-center bg-blue-600 hover:bg-blue-700 py-3 rounded-lg text-base">
                    {{ __('Masuk Sekarang') }}
                </x-primary-button>

                <p class="mt-6 text-center text-sm text-gray-600">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">Daftar</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>
