@extends('layouts.auth')
@section('content')
    <div class="card bg-glass">
        <div class="card-body px-4 py-5 px-md-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="text-left" style="color: #125D72; font-weight: bold;">{{ trans('global.login') }}</h1>
                </div>
                <div class="col-md-6 text-md-right">
                    <span style="color: hsl(218, 81%, 75%);">
                        <img class="img-fluid" src="{{ asset('img/logos/logo-kemendagri.png') }}" width="80"
                            alt="Logo Kemendagri">
                    </span>
                </div>
            </div>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" style="margin-top: 10px">
                @csrf

                <div class="input-group mb-3">
                    {{-- <div class="input-group-text">
                            <span class="input-group-text">
                                <i class="fa fa-user"></i>
                            </span>
                        </div> --}}

                    <input id="email" name="email" type="text"
                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autocomplete="email"
                        autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">

                    @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <div class="input-group mb-3">
                    <input id="password" name="password" type="password"
                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required
                        placeholder="{{ trans('global.login_password') }}">
                    {{-- <i class="ri-eye-off-line login__eye" id="login-eye"></i> --}}
                    @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                <div class="input-group mb-4">
                    <div class="form-check checkbox">
                        <input class="form-check-input" name="remember" type="checkbox" id="remember"
                            style="vertical-align: middle;" />
                        <label class="form-check-label" for="remember" style="vertical-align: middle;">
                            <p style="color: #125D72;">{{ trans('global.remember_me') }}</p>
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 text-left">
                        <button type="submit" class="btn btn-primary px-4" style="color: #ffffff;text;font-weight: bold;">
                            {{-- {{ trans('global.login') }} --}}
                            Masuk
                        </button>
                    </div>
                    <div class="col-6 text-right">
                        @if (Route::has('password.request'))
                            <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                <p style="color: #125D72;text;font-weight: bold;">
                                    {{-- {{ trans('global.forgot_password') }} --}}Lupa Password?
                                </p>
                            </a><br>
                        @endif

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
