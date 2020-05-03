@extends('layouts.app')

@section('content')
    <div class="login-page">
        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div>
                <label for="email" class="login-label">E-Mail Address</label>

                <div>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <div class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <label for="password" class="login-label">Password</label>

                <div>
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <div class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <div>
                    <div>
                        <label>
                            <input type="checkbox" name="remember" checked> Remember Me
                        </label>
                    </div>
                </div>
            </div>

            <div>
                <div>
                    <button type="submit" class="login-button">
                        Login
                    </button>
                </div>
                <div>
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        Forgot Your Password?
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
