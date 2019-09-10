@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <!-- <div class="card-header">{{ __('Login') }}</div> -->

                <div class="card-body">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>{{ __('Log in') }}</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-sm-6 b-r">
                                    <form role="form" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group ">
                                            <label>{{ __('E-Mail Address') }}</label>
                                            <input id="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email or Pnone" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            <div class="col-md-6">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label for="password">{{ __('Password') }}</label>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                            <div class="col-md-6">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div>
                                            <!-- ************* -->
                                            {!! htmlFormSnippet() !!}
                                            <!-- <input type="submit"> -->
                                            @if ($errors->has('g-recaptcha-response'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                            @endif
                                            <!-- ************** -->
                                            <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Log in</strong></button>
                                            <label class="">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="remember">
                                                        {{ __('Remember Me') }}
                                                    </label>
                                                </div>
                                            </label>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-sm-6">
                                    <h4>Not a member?</h4>
                                    <p>You can create an account:</p>
                                    <p class="text-center">
                                        <a href="{{ route('register') }}"><i class="fa fa-sign-in big-icon"></i></a>
                                    </p>
                                </div>

                                <div class="col-md-8 offset-md-4">
                                    @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection