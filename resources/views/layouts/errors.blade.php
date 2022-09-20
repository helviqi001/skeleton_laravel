<!DOCTYPE html>
<html>

@include('layouts.partials.html_header')
<body>
<div id="app" v-cloak>
    <section class="content">
        @yield('main-content')
    </section>
</div>
@section('scripts')
    @include('layouts.partials.script')
@show
</body>
</html>
