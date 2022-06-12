@extends('layouts.app')

@section('auth_content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0" style="background-color: #F8FAFC;">
            <div class="row mb-5"></div>
                <!-- Card Header -->
                <div class="card border-0" style="background-color: #F8FAFC; font-weight: bold; font-size: 32px; text-align: center;">
                    <div class="row mb-4">
                        <strong>
                            {{ __('Login to Your Account') }}
                        </strong>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Properties -->
                        <div class="row mb-4">
                            <div class="col-md-6" style="margin: auto;">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email" style="background-color: #e0e0e0;">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Password properties -->
                        <div class="row mb-4">
                            <div class="col-md-6" style="margin: auto;">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password" style="background-color: #e0e0e0;">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Remember me properties -->
                        <div class="row mb-4">
                            <div class="col-md-3 offset-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Log in properties -->
                        <div class="row mb-0">
                            <div class="col text-center">
                                <button type="submit" class="btn btn" style="color: white; background-color: #EC008E; width: 255px; height:79px; font-size: 32px; box-shadow: 1px 3px 2px #888888;">
                                    {{ __('Log in') }}
                                </button>
                            </div>
                        </div>

                        <!-- Footer -->
                        <footer class="bg-light text-center text-lg-start" style="position: fixed; left: 0; bottom: 0; width: 100%; margin: 0; padding: 0;">
                            <!-- Grid container -->
                            <div class="container p-4" style="background-color: #1BB2B3; box-shadow: 4px 8px 5px #888888;">
                                <div class="row">

                                    <!-- Title and O-->
                                    <div class="col mb-0" style="color: white; text-align: center; padding: 10px;">
                                        <h5 class="col mb-0 text-center" style="font-weight: bold; padding: 5px;">New Library User?</h5>
                                            <p>
                                            Register, borrow, and discover great books!
                                            </p>
                                        <div class="row mb-5">
                                            <div class="col text-center" style="text-align: center;">
                                                <a href="{{ route('register') }}" class="btn btn-info" style="color: black; background-color: white; 
                                                width: 255px; height: 65px; font-size: 25px; box-shadow: 1px 3px 2px #888888; font-weight: bold;">{{ __('Sign up') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Grid column-->

                                </div>
                            </div>
                            <!-- Grid container -->
                        </footer>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
