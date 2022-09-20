@component('component.ui.modal',['title'=>$title,'id'=>'confirm'])
    @slot('body')
        {{ $body }}
    @endslot
    @slot('footer')
        <div class="form-group">
            @if(!empty($delete))
                <button id="doit" type="submit" class="btn btn-danger">Delete</button>
            @else
                <button id="doit" type="submit" class="btn btn-warning">Yes</button>
            @endif
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
    @endslot
@endcomponent
@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#confirm').on('click', '#doit', function(e) {
            var $modalDiv = $(e.delegateTarget);
            var id = $(this).data('{!! $dataname !!}');
            var url = $(this).data('{!! $dataurl !!}');

            $.ajax({
                url: url,
                type: 'DELETE',
                success: function() {
                    $("#confirm").modal('hide');
                    toastr.success('Success delete permission test','Success Delete');
                    // location.reload();
                },
                error: function() {
                    alert("There was an error. Try again please!");
                }
            });
        });
        $('#confirm').on('show.bs.modal', function(e) {
            var data = $(e.relatedTarget).data();
            $('#doit', this).data('{!! $dataname !!}', data.{!! $dataname !!});
            $('#doit', this).data('{!! $dataurl !!}', data.{!! $dataurl !!});
        });
    </script>
@endsection