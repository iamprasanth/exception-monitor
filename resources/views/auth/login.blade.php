@extends('layouts.authapp')
@section('content')
<section class="main-module">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image" style="background: url('/images/login_cover.svg') center; background-size:300px; background-repeat:no-repeat"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div>
                                <form class="user" name="login" id="login-form" method="post" action="{{ url('/checklogin') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user"
                                            id="email" aria-describedby="email" name="email" 
                                            placeholder="Enter Email Address...">
                                        <div class="help-block with-errors email-error">
                                            <span class="help-block"><strong>
                                                    <p></p>
                                                </strong></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user"
                                            id="password" name="password"  placeholder="Password">
                                        <div class="help-block with-errors password-error">
                                            <span class="help-block"><strong>
                                                    <p></p>
                                                </strong></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" name="remember"
                                                id="remember">
                                            <label class="form-check-label"
                                                for="remember">{{ __('Remember Me') }}</label>
                                        </div>
                                    </div>
                                    <button type="button"
                                        class="btn btn-primary btn-user btn-block login" onclick="submitForm(this)" data-redirect="{{ url('/') }}">{{ __('Login') }}</button>
                                    <hr>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="{{ route('register') }}">Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection