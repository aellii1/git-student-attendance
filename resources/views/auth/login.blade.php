@extends('layouts.master-blank')

@section('content')
    <div class="wrapper-page">
        <div class="card overflow-hidden account-card mx-3 shadow">
            <div class="p-4 text-white text-center position-relative shadow" style="background-color: #ECECF1;">
                <p class="text-white-50 mb-4"></p>
                <a href="{{ route('welcome') }}" class="logo logo-admin shadow">
                    <img src="{{ asset('assets/images/voctech.png') }}" alt="voctech">
                </a>
            </div>
            <div class="account-card-content d-flex justify-content-center">
                <form class="form-horizontal m-t-40" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group m-b-20">
                        <label for="email" class="col-form-label ">{{ __('Email Address') }}</label>

                        <input id="email" type="email" class="form-control rounded rounded-pill input-sm @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group m-b-20">
                        <label for="password" class="col-form-label ">{{ __('Password') }}</label>


                        <input id="password" type="password" class="form-control rounded rounded-pill input-sm @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                   
                    <div class="form-group row m-t-20">
                        <div class=" col-sm-12 m-b-20">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-primary rounded p-2 w-xlg waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>


                </form>
            </div>
        </div>


    </div>

@endsection

@section('script')
@endsection


