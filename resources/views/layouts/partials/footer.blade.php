<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> {{ config('app.version') }}
    </div>
    <strong>Copyright &copy; {{ \Carbon\Carbon::now()->format('Y') }} <a href="{{ config('app.url') }}">{{ config('app.name') }}</a>.</strong> All rights reserved.
</footer>
