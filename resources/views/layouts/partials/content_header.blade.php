@php ($countsegments = count(Request::segments()))
<section class="content-header">
    <h1>
        @yield('content_header_title', 'Page Header here')
        <small>@yield('content_header_description')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i></a></li>
        @for($i = 1; $i <= $countsegments; $i++)
            @for($i1 = 1; $i1 <= $i; $i1++)@php($url[$i1] = Request::segment($i1))@endfor
            <li>
                <a href="{{url(implode("/", $url))}}">{{ ucfirst(Request::segment($i))}}</a>
            </li>
        @endfor
    </ol>
</section>
