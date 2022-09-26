<script src="{{ asset('/js/app.js') }}"></script>
<script src="{{ asset('/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    @if($message = Session::get('success'))
        toastr["success"]("{{ $message }}").show()
    @endif

    @if($message = Session::get('error'))
        toastr["error"]("{{ $message }}").show()
    @endif

    @if($message = Session::get('warning'))
        toastr["warning"]("{{ $message }}").show()
    @endif

    @if($message = Session::get('info'))
        toastr["info"]("{{ $message }}").show()
    @endif

</script>
@yield('script')
