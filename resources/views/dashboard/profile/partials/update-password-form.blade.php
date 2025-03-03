<section>
    <header>
        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Mengubah Password') }}
        </h4>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Pastikan akun Anda menggunakan kata sandi acak yang panjang agar tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <input type="password" id="current_password" class="form-control" placeholder="Password Lama" name="current_password" autocomplete="current-password"/>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label class="form-label" for="form2Example11"></label>
            <input type="password" id="password" class="form-control" placeholder="Password Baru" name="password" autocomplete="new-password"/>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label class="form-label" for="form2Example11"></label>
            <input type="password" id="password_confirmation" class="form-control" placeholder="Ulangi Password Baru" name="password_confirmation" autocomplete="new-password"/>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <br>

        <x-primary-button class="btn btn-primary">
            {{ __('Simpan') }}
        </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Tersimpan') }}</p>
            @endif

    </form>
</section>
