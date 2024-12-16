@extends('layouts.auth.app')

@section('title')
    Login | SIAK DUKCAPIL
@endsection

@section('content')
    <!--begin::Logo-->
    <a href="#" class="mb-12">
        <img alt="Logo" src="{{ asset('template/dist/assets/media/logos/logo.svg') }}" class="h-60px mb-10" />
    </a>
    <!--end::Logo-->

    @if (session('message'))
        <div class="alert alert-warning">
            {{ session('message') }}
        </div>
    @endif



    <form method="POST" action="{{ route('login') }}" class="form w-100" novalidate="novalidate" id="kt_sign_in_form">
        @csrf
        <!--begin::Heading-->
        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="form-label fs-6 fw-bolder text-white">Email</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input class="form-control form-control-lg form-control-solid" type="text" name="email" autocomplete="off"
                id="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            <!--end::Input-->
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Wrapper-->
            <label class="form-label fs-6 fw-bolder text-white">Password</label>
            <!--end::Wrapper-->
            <!--begin::Input-->
            <input class="form-control form-control-lg form-control-solid" type="password" name="password"
                autocomplete="off" id="password" name="password"required autocomplete="current-password" />
            <!--end::Input-->
            <x-input-error :messages="$errors->get('password')" class="mt-2" />

            <div class="d-flex flex-stack mb-2">
                <!--begin::Label-->
                <label for="remember_me" class="inline-flex items-center mt-5 ">
                    <input id="remember_me" type="checkbox"
                        class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                        name="remember">
                    <span class="ml-2 text-sm text-gray-600 dark:text-white-400">{{ __('Remember me') }}</span>
                </label>
                <!--end::Label-->
                <!--begin::Link-->
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="link-primary fs-6 fw-bolder mt-5">Forgot Password ?</a>
                @endif
                <!--end::Link-->
            </div>

            <!--end::Input group-->
            <!--begin::Actions-->
            <div class="text-center">
                <!--begin::Submit button-->
                <x-primary-button class="btn btn-lg btn-primary w-100 mt-5">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
    </form>
@endsection
