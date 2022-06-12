@extends('layouts.app')

@section('auth_content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row mb-5"></div>
            <div class="card">
                <!-- Card Header -->
                <div class="card" style="font-weight: bold; font-size: 32px; text-align: center;">{{ __('Create Free Account') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="row mb-4">
                            <div class="col-md-6" style="margin: auto;">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name" style="background-color: #e0e0e0;">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Email  -->
                        <div class="row mb-4">
                            <div class="col-md-6" style="margin: auto;">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" style="background-color: #e0e0e0;">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="row mb-4">
                            <div class="col-md-6" style="margin: auto;">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password" style="background-color: #e0e0e0;">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="row mb-4">
                            <div class="col-md-6" style="margin: auto;">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password" style="background-color: #e0e0e0;">
                            </div>
                        </div>

                        <!-- Sign up -->
                        <div class="row mb-3">
                            <div class="col text-center">
                                <button type="submit" class="btn btn" style="color: white; background-color: #EC008E; width: 255px; height:79px; font-size: 32px; box-shadow: 1px 3px 2px #888888;">
                                    {{ __('Sign Up') }}
                                </button>
                            </div>
                        </div>

                        <!-- Return to Login page -->
                        <div class="row mb-0">
                            <div class="col text-center">
                                <a href="{{ route('login') }}" class="btn btn" style="color: black; color: white; background-color: #1BB2B3;
                                width: 255px; height: 50px; font-size: 18px; box-shadow: 1px 3px 2px #888888;">{{ __('Login to an existing account') }}
                                </a>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
