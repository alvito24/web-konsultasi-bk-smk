<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Perbarui informasi profil akun dan data diri Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="avatar" :value="__('Foto Profil')" />
            <div class="flex items-center mt-2 gap-4">
                @if($user->avatar)
                    <img src="{{ asset('storage/'.$user->avatar) }}" class="w-16 h-16 rounded-full object-cover border border-gray-200">
                @else
                    <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
                <input type="file" name="avatar" id="avatar" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="nis_nip" :value="$user->role == 'siswa' ? 'NIS' : 'NIP'" />
                <x-text-input id="nis_nip" name="nis_nip" type="text" class="mt-1 block w-full bg-gray-100" :value="old('nis_nip', $user->nis_nip)" readonly />
                <p class="text-xs text-gray-500 mt-1">* Hubungi admin jika ingin mengubah NIS/NIP.</p>
            </div>
            <div>
                <x-input-label for="phone" :value="__('No. WhatsApp')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" placeholder="08xxxxxxxx" />
            </div>

            @if($user->role == 'siswa')
            <div>
                <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                <select name="gender" id="gender" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            @endif
        </div>

        @if($user->role === 'siswa')
            <div>
                <x-input-label for="class_name" :value="__('Kelas')" />
                <x-text-input id="class_name" name="class_name" type="text" class="mt-1 block w-full bg-gray-100" :value="old('class_name', $user->class_name)" readonly />
                <p class="text-xs text-gray-500 mt-1">* Hubungi admin jika data kelas salah.</p>
            </div>

            <div>
                <x-input-label for="interests" :value="__('Minat & Hobi')" />
                <textarea id="interests" name="interests" rows="2" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('interests', $user->interests) }}</textarea>
            </div>

            <div>
                <x-input-label for="career_goals" :value="__('Cita-cita / Rencana Karir')" />
                <x-text-input id="career_goals" name="career_goals" type="text" class="mt-1 block w-full" :value="old('career_goals', $user->career_goals)" />
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-bold"
                >{{ __('Berhasil Disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
