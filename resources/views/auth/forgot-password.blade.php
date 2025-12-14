<x-guest-layout>
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden p-8">
        <div class="text-center mb-6">
            <div class="bg-blue-100 text-blue-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Lupa Password?</h2>
            <p class="text-sm text-gray-500 mt-2">
                Jangan khawatir. Masukkan email Anda dan kami akan mengirimkan link untuk mereset password.
            </p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-6">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 focus:ring-blue-500" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4 gap-4">
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">Kembali Login</a>

                <x-primary-button class="bg-blue-600 hover:bg-blue-700 py-2 rounded-lg">
                    {{ __('Kirim Link Reset') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
