@extends('layouts.app')

@section('content')

<div class="login-form-wrapper">
    <div class="login-brand">
        <h1>Pepper Rodeo</h1>
        <h5>Your recipes & grocery lists in one place.</h5>
    </div>

    <div class="login-info">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="control-label"><i class="fa fa-user-circle-o"></i></label>

                <div>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="E-Mail Address">

                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label"></label>

                <div class="password">
                    <input id="password" type="password" class="form-control" name="password" required placeholder="Password">
                    <a class="forgot-btn" href="{{ url('/password/reset') }}">
                        Forgot?
                    </a>

                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div>


                    <button type="submit" class="login-link-btn">
                        <a class="login-link"><i class="fa fa-arrow-circle-o-right"></i> Login</a>
                    </button>


                </div>
            </div>
        </form>

        <div class="register-section">
            <p>Not a Member? <a href="/register">Register Here!</a></p>
        </div>
    </div>
</div>

@endsection
