@extends('layouts.auth')

@section('title')
    Register
@endsection

@section('content')
    <style>
        .register-box {
            width: 720px;
            padding-top: 7%;
            margin: auto;
        }
        @media (max-width:768px) {
            .login-box,.register-box {
                width:90%;
                margin-top:20px
            }
        }
    </style>
    <body class="hold-transition register-page">
    <div class="register-box">
        <div class="login-logo">
            <a href="{{ route('landing') }}">
                <svg width="100" height="102" viewBox="0 0 50 52" xmlns="http://www.w3.org/2000/svg"><title>Logomark</title><path d="M49.626 11.564a.809.809 0 0 1 .028.209v10.972a.8.8 0 0 1-.402.694l-9.209 5.302V39.25c0 .286-.152.55-.4.694L20.42 51.01c-.044.025-.092.041-.14.058-.018.006-.035.017-.054.022a.805.805 0 0 1-.41 0c-.022-.006-.042-.018-.063-.026-.044-.016-.09-.03-.132-.054L.402 39.944A.801.801 0 0 1 0 39.25V6.334c0-.072.01-.142.028-.21.006-.023.02-.044.028-.067.015-.042.029-.085.051-.124.015-.026.037-.047.055-.071.023-.032.044-.065.071-.093.023-.023.053-.04.079-.06.029-.024.055-.05.088-.069h.001l9.61-5.533a.802.802 0 0 1 .8 0l9.61 5.533h.002c.032.02.059.045.088.068.026.02.055.038.078.06.028.029.048.062.072.094.017.024.04.045.054.071.023.04.036.082.052.124.008.023.022.044.028.068a.809.809 0 0 1 .028.209v20.559l8.008-4.611v-10.51c0-.07.01-.141.028-.208.007-.024.02-.045.028-.068.016-.042.03-.085.052-.124.015-.026.037-.047.054-.071.024-.032.044-.065.072-.093.023-.023.052-.04.078-.06.03-.024.056-.05.088-.069h.001l9.611-5.533a.801.801 0 0 1 .8 0l9.61 5.533c.034.02.06.045.09.068.025.02.054.038.077.06.028.029.048.062.072.094.018.024.04.045.054.071.023.039.036.082.052.124.009.023.022.044.028.068zm-1.574 10.718v-9.124l-3.363 1.936-4.646 2.675v9.124l8.01-4.611zm-9.61 16.505v-9.13l-4.57 2.61-13.05 7.448v9.216l17.62-10.144zM1.602 7.719v31.068L19.22 48.93v-9.214l-9.204-5.209-.003-.002-.004-.002c-.031-.018-.057-.044-.086-.066-.025-.02-.054-.036-.076-.058l-.002-.003c-.026-.025-.044-.056-.066-.084-.02-.027-.044-.05-.06-.078l-.001-.003c-.018-.03-.029-.066-.042-.1-.013-.03-.03-.058-.038-.09v-.001c-.01-.038-.012-.078-.016-.117-.004-.03-.012-.06-.012-.09v-.002-21.481L4.965 9.654 1.602 7.72zm8.81-5.994L2.405 6.334l8.005 4.609 8.006-4.61-8.006-4.608zm4.164 28.764l4.645-2.674V7.719l-3.363 1.936-4.646 2.675v20.096l3.364-1.937zM39.243 7.164l-8.006 4.609 8.006 4.609 8.005-4.61-8.005-4.608zm-.801 10.605l-4.646-2.675-3.363-1.936v9.124l4.645 2.674 3.364 1.937v-9.124zM20.02 38.33l11.743-6.704 5.87-3.35-8-4.606-9.211 5.303-8.395 4.833 7.993 4.524z" fill="#FF2D20" fill-rule="evenodd"/></svg>
                <h1>{{ strtoupper(config('app.name')) }}</h1>
            </a>
            <h5>{{ config('app.description') }}</h5>

        </div>

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="register-box-body">
            <p class="login-box-msg">{{ trans('message.registermember') }}</p>
            <form action="{{ route('register') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group has-feedback {{ $errors->has('name') ? ' has-error' : '' }}">
                            <input type="text" class="form-control" placeholder="Nama Lengkap" name="name" value="{{ old('name') }}" autofocus required/>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="email" class="form-control" placeholder="{{ trans('message.email') }}" name="email" value="{{ old('email') }}" required/>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback {{ $errors->has('gender') ? ' has-error' : '' }}">
                            <select name="gender" class="form-control">
                                <option value=""> -- Jenis Kelamin --</option>
                                <option value="male"> Laki-Laki</option>
                                <option value="female"> Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group has-feedback {{ $errors->has('birthday') ? ' has-error' : '' }}">
                            <input id="datepicker" type="text" class="form-control" placeholder="Tanggal Lahir" name="birthday" value="{{ old('birthday') }}" required/>
                            <span class="fa fa-birthday-cake form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        @if (config('auth.providers.users.field','username') === 'username')
                            <div class="form-group has-feedback {{ $errors->has('username') ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ trans('message.username') }}" name="username" required/>
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                        @endif
                        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                            <input type="password" class="form-control" placeholder="{{ trans('message.password') }}" name="password" required/>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                            <input type="password" class="form-control" placeholder="{{ trans('message.retypepassword') }}" name="password_confirmation" required/>
                            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-xs-1">
                                <label>
                                    <div class="checkbox_register icheck">
                                        <label>
                                            <input type="checkbox" name="terms" required>
                                        </label>
                                    </div>
                                </label>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <a href="" data-toggle="modal" data-target="#termsModal">{{ trans('message.terms') }}</a>
                                </div>
                            </div>
                            <div class="col-xs-4 col-xs-push-1">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('message.register') }}</button>
                            </div>
                        </div>
                        <a href="{{ url('/login') }}" class="text-center">{{ trans('message.membership') }}</a>
                        {{--<div class="row">--}}
                        {{--<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>--}}
                        {{--<div class="col-md-8">--}}
                        {{--@include('auth.partials.social_login')--}}
                        {{--</div>--}}
                        {{--<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>--}}
                        {{--</div>--}}
                    </div>
                </div>

            </form>
        </div>
    </div>
    @include('auth.terms')
    @include('layouts.partials.script')
    <script src="/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

    <script>
        $('#datepicker').datepicker({
            format: "dd/mm/yyyy",
        });
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
@section('stylesheet')
    <link rel="stylesheet" href="/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
@endsection

