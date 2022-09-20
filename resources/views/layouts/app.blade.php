<!doctype html>
<html lang="en">
@include('layouts.partials.html_header')
<body class="skin-blue sidebar-mini">
@php($auth = Session::get('auth'))
<div class="wrapper">

    @include('layouts.partials.main_header')

    @include('layouts.partials.sidebar')

    <div class="content-wrapper">

        @include('layouts.partials.content_header')

        <section class="content">
            @yield('main-content')
        </section>
    </div>
    @include('layouts.partials.control_sidebar')

    @include('layouts.partials.footer')
</div>
@include('layouts.partials.script')
</body>
</html>
