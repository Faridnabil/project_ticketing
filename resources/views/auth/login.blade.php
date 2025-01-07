@extends('layouts.auth.app')

@section('title')
    Login | Ticketing
@endsection

@section('content')
    <div class="row d-flex align-items-stretch">
        <!-- Left Card: Image -->
        <div class="col-md-6">
            <div class="card h-100">
                <img src="{{ asset('template/dist/assets/media/logos/logo.png') }}" class="card-img-top" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Welcome to Ticketing</h5>
                    <p class="card-text">Experience seamless ticket booking and management.</p>
                </div>
            </div>
        </div>

        <!-- Right Card: Login Form -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title" style="margin-bottom: 20px; font-size: 16px;;">Login.</h5>
                    @if (session('message'))
                        <div class="alert alert-warning text-center mb-4">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="form w-100" novalidate="novalidate"
                        id="kt_sign_in_form">
                        @csrf
                        <div class="fv-row mb-4">
                            <label class="form-label fs-6 fw-normal text-dark">Email</label>
                            <input class="form-control form-control-lg form-control-solid" type="text" name="email"
                                autocomplete="off" id="email" value="{{ old('email') }}" required autofocus
                                autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="fv-row mb-4">
                            <label class="form-label fs-6 fw-normal text-dark">Password</label>
                            <input class="form-control form-control-lg form-control-solid" type="password" name="password"
                                id="password" required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" name="remember"
                                    class="rounded text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="link-primary fs-6 fw-bolder">Forgot
                                    Password?</a>
                            @endif
                        </div>

                        <div class="text-center">
                            <x-primary-button class="btn btn-lg btn-primary w-100 mt-4">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1 text-center mt-5">
            <span class="text-muted fw-bold me-1">Hak Cipta © </span>
            2025
            <a href="" target="_blank" class="text-gray-800 text-hover-primary">
                Kementerian Perdagangan Republik Indonesia.
            </a>
        </div>
        <!--end::Copyright-->
    </div>
@endsection

@section('styles')
    <style>
        body {
            background-color: #f8f9fa;
            /* Light background for the page */
        }

        .card {
            border: none;
            /* Remove card border */
            border-radius: 10px;
            /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
        }

        .card-img-top {
            border-top-left-radius: 10px;
            /* Rounded corners for image */
            border-top-right-radius: 10px;
            /* Rounded corners for image */
        }

        .form-control {
            border-radius: 5px;
            /* Rounded corners for input fields */
        }

        .btn-primary {
            background-color: #007bff;
            /* Primary button color */
            border: none;
            /* No border */
        }

        .btn-primary:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
        }

        .alert {
            background-color: #ff cc00;
            /* Warning alert color */
            color: #000;
            /* Black text for readability */
        }

        .link-primary {
            color: #007bff;
            /* Link color */
        }

        .link-primary:hover {
            text-decoration: underline;
            /* Underline on hover */
        }
    </style>
@endsection
