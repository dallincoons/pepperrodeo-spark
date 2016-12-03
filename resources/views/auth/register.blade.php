@extends('layouts.app')

@section('content')
    <div class="login-form-wrapper">
        <div class="login-brand">
            <h1>Pepper Rodeo</h1>
            <h5>Your recipes & grocery lists in one place.</h5>
        </div>

        <div class="login-info">

        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label"></label>

                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Name">

                    @if ($errors->has('name'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label"></label>


                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Email Address">

                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif

            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label"></label>

                    <input id="password" type="password" class="form-control" name="password" required placeholder="Password">

                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif

            </div>

            <div class="form-group">
                <label for="password-confirm" class="col-md-4 control-label"></label>

                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">
            </div>

            <div class="form-group">
                <button type="submit" class="login-link-btn">
                    <a class="login-link"><i class="fa fa-arrow-circle-o-right"></i> Sign Up</a>
                </button>
            </div>
        </form>


            <div class="register-section">
                <p>Already a Member? <a href="/login">Login Here!</a></p>
            </div>
        </div>
    </div>







@endsection
