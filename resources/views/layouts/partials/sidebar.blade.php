@php
$auth = Session::get('user_data');
@endphp
<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ $auth['avatar'] }}" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                {{--                <p style="overflow: hidden;text-overflow: ellipsis;max-width: 160px;" data-toggle="tooltip" title="{{ $auth->userAuth->name }}">{{ $auth->userAuth->name }}</p>--}}
                <p style="overflow: hidden;text-overflow: ellipsis;max-width: 160px;" data-toggle="tooltip" title="{{ $auth['name'] }}">{{ $auth['name'] }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                {{--                <small>{{ $auth->userAuth->name }}</small>--}}
            </div>
        </div>
        <style>
            .skin-blue .sidebar-form .btn, .skin-blue .sidebar-form input[type="text"] {
                background-color: whitesmoke;
            }
        </style>
        {{-- <form action="" method="GET" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search" required>
                <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
                </span>
            </div>
        </form> --}}
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Navigation</li>
            <li class="{{ isActiveUrl('/dashboard') }}">
                <a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i><span>Dashboard</span></a>
            </li>
            @if (!empty(Session::get('privileges')))
            @foreach(Session::get('privileges') as $privilege)
                <li class="treeview">
                    <a href="#">
                        <i class="{{ $privilege['icon'] }}"></i>
                        <span>{{ $privilege['name'] }}</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        @foreach($privilege['menus'] as $menu)
                        
                            <li class="{{ isActiveUrl($menu['url']) }}"><a href="{{ $menu['url'] }}"><i class="fa fa-circle-o"></i> {{ $menu['name'] }}</a></li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
            @endif
        </ul>
    </section>
</aside>
