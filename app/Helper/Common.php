<?php
if (! function_exists('isUrlActive'))
{
    function isUrlActive($url, $output = "active")
    {
        if (url()->current() == $url) return $output;
    }
    {

    }
}
if (! function_exists('isActive')) {
    function isActive($route, $output = "active")
    {
        if (Route::currentRouteName() == $route) return $output;
    }
}

if (! function_exists('areActive')) {
    function areActive(Array $routes, $output = "active")
    {
        foreach ($routes as $route)
        {
            if (Route::currentRouteName() == $route) return $output;
        }
    }
}

if (!function_exists('isActiveUrl')) {
    function isActiveUrl($url, $output = 'active') {
        if (Request::segment(1) === explode('/', $url)[1]) return $output . ' ' . $url;
    }
}

if (!function_exists('areActiveUrl')) {
    function areActiveUrl($urls, $output = 'active') {
        foreach ($urls as $url) {
            if (Request::segment(1) === explode('/', $url)[1]) return $output . ' ' . $url;
        }
    }
}
