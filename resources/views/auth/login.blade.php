@extends('layouts.auth.app')

@section('title')
    Login | Ticketing
@endsection

@section('content')
    <div class="row d-flex align-items-stretch">
        <!-- Left Card: Image -->
        <div class="col-md-6">
            <div class="card h-100 d-flex justify-content-center align-items-center">
                <div class="text-center">
                    <img src="{{ asset('template/dist/assets/media/logos/logo.svg') }}" class="card-img-top logo-center"
                        alt="Card image cap" style="width: 300px">
                    <div class="card-body">
                        <h5 class="card-title">Welcome to Ticketing</h5>
                        <p class="card-text">Experience seamless ticket booking and management.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Card: Login Form -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-4">Login</h5>

                    @if (session('message'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>
                                        @if ($error == 'These credentials do not match our records.')
                                            The email or password you entered is incorrect.
                                            {{-- @if ($error == 'The nip field is required.')
                                            The nip field is required. --}}
                                        @elseif ($error == 'The password field is required.')
                                            The password field is required.
                                        @elseif ($error == 'The captcha field is required.')
                                            Please complete the captcha.
                                        @elseif ($error == 'The captcha is incorrect.')
                                            The captcha you entered is incorrect.
                                        @else
                                            {{ $error }}
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="" class="form w-100" novalidate="novalidate" id="kt_sign_in_form">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">Email</label>
                            <input class="form-control form-control-lg" type="email" name="email"
                                value="{{ old('email') }}" required autofocus autocomplete="email">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <div class="input-group password-group">
                                <input class="form-control form-control-lg border-end-0" type="password" name="password" id="password"
                                    required autocomplete="current-password" placeholder="Enter your password" />
                                <span class="input-group-text bg-white border-start-0" id="togglePassword" style="cursor: pointer;">
                                    <i class="fas fa-eye" id="icon-eye-show" style="display: block;"></i>
                                    <i class="fas fa-eye-slash" id="icon-eye-hide" style="display: none;"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Captcha</label>
                            <div class="d-flex align-items-center mb-2">
                                <span>{!! captcha_img() !!}</span>
                                <button type="button" class="btn btn-link ms-2" id="reloadCaptcha">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control" name="captcha" placeholder="Enter captcha" required>
                        </div>


                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                <label class="form-check-label" for="remember_me">Remember me</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-primary">Forgot Password?</a>
                            @endif
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Log in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center mt-5">
            <span class="text-muted fw-bold">Copyright © 2025</span>
            <a href="" target="_blank" class="text-gray-800 text-hover-primary">
                Ministry of Home Affairs, Republic of Indonesia.
            </a>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .alert {
            border-radius: 5px;
            padding: 10px 15px;
            margin-bottom: 20px;
        }

        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeeba;
            color: #856404;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .logo-center {
            max-width: 100px;
            height: auto;
            margin: 0 auto;
        }

        .card {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .card-body {
            padding: 20px;
        }

        .input-group.password-group {
            position: relative;
        }
        .input-group.password-group .form-control {
            border-right: 0;
        }
        .input-group.password-group .input-group-text {
            background: #fff;
            border-left: 0;
            border-radius: 0 5px 5px 0;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
            display: flex;
            align-items: center;
            height: 100%;
        }
        .input-group.password-group .input-group-text i {
            font-size: 1.2rem;
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Toggle show/hide password with two icons (ensure DOM is ready)
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const iconShow = document.getElementById('icon-eye-show');
            const iconHide = document.getElementById('icon-eye-hide');

            if (togglePassword && passwordInput && iconShow && iconHide) {
                togglePassword.addEventListener('mousedown', function(e) {
                    e.preventDefault(); // Prevent input focus loss
                });
                togglePassword.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (passwordInput.type === 'password') {
                        passwordInput.setAttribute('type', 'text');
                        iconShow.style.display = 'none';
                        iconHide.style.display = 'block';
                    } else {
                        passwordInput.setAttribute('type', 'password');
                        iconShow.style.display = 'block';
                        iconHide.style.display = 'none';
                    }
                });
            }
        });
    </script>

    <script>
        document.getElementById('reloadCaptcha').addEventListener('click', function() {
            fetch("{{ route('reload.captcha') }}")
                .then(response => response.json())
                .then(data => {
                    document.querySelector('span').innerHTML = data.captcha;
                });
        });
    </script>
@endsection
