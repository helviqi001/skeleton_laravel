@extends('layouts.auth')

@section('title','Password reset')

@section('content')

    <body class="login-page">

    <div id="app">
        <div class="login-box">
            <div class="login-logo">
                <a href="{{ route('landing') }}"><b>Admin</b>LTE</a>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> {{ trans('message.someproblems') }}<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="login-box-body">
                <p class="login-box-msg">{{ trans('message.passwordreset') }}</p>
                <form action="{{ url('/password/reset') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" autofocus/>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password" name="password"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password" name="password_confirmation"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div class="row">
                        <div class="col-xs-2">
                        </div>
                        <div class="col-xs-8">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('message.passwordreset') }}</button>
                        </div>
                        <div class="col-xs-2">
                        </div>
                    </div>
                </form>

                <a href="{{ url('/login') }}">Log in</a><br>
                <a href="{{ url('/register') }}" class="text-center">{{ trans('message.membership') }}</a>

            </div>

        </div>
    </div>

    @include('layouts.partials.script')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    </body>

@endsection