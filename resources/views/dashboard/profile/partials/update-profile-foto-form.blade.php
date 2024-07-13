<section>
    <header>
        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Foto Profil') }}
        </h4>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Pebaharui Foto anda") }}
        </p>
    </header>

    <form action="{{ route('profile.update_foto', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')


        <!--begin::Input group-->
        <div class="form-group">
            @if ($user->photo)
                <img src="{{ url('/' . $user->photo) }}" class="user-profil">
            @else
                <div class="image-placeholder">Foto Tidak Tersedia</div>
            @endif
            <br><br><br>
            <div class="custom-file">
                <input type="file" name="photo" class="form-control">
                <input type="hidden" name="pathFile" value="{{ $user->photo }}">
            </div>
        </div>
        <!--end::Input group-->

        <style>
            /* Gaya untuk gambar */
            .user-profil {
              width: 220px;
              height: 250px;
              border: 2px solid #ccc; /* Tambahkan garis tepi */
              box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); /* Tambahkan bayangan */
              border-radius: 10px; /* Tambahkan sudut melengkung */
            }
            /* Gaya untuk teks pengganti */
            .image-placeholder {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 220px;
                height: 250px;
                border: 2px dashed #ccc;
                /* Garis putus-putus sebagai pengganti gambar */
                border-radius: 10px;
                font-size: 14px;
                color: #777;
            }
          </style>

        <br>
        <div class="flex items-center gap-4">
            <x-primary-button class="btn btn-primary">
                {{ __('Simpan') }}
            </x-primary-button>

            @if (session('data') === 'photo')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Tersimpan') }}</p>
            @endif
        </div>
    </form>
</section>
