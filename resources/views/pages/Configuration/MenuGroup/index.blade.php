@extends('layouts.app')

@section('title','Menu Group List')
@section('content_header_title','Menu Group List')

@section('main-content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Menu Group</h3>
            <div class="box-tools">
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-striped data-table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Sequence</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                <a class="btn btn-primary" href="menu-group/create/">Create</a>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Menu Group</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <a href="" class="btn btn-danger btn-sm active">Delete</a>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        let dataTable = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: window.location.href + "/fn_get_data",
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'sequence', name: 'sequence'},
                {data: 'status', searchable: false, orderable: false},
                {data: 'action', searchable: false, orderable: false, width: '25%'},
            ],
        })

        function fnDelete(component, id) {
            let modalDelete = $('#modal-delete')
            let name = component.parentElement.parentElement.childNodes[0].textContent
            modalDelete.find('div.modal-body>p')[0].textContent = "Are you sure want to delete " + name + "?"
            modalDelete.find('div.modal-footer>a')[0].href = 'menu-group/delete/' + id
            modalDelete.modal()
        }

        function updateStatus(id) {
            $.ajax({
                url: window.location.href + "/update-status/"+id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType : 'json',
                type : 'POST',
                beforeSend: function () {
                },
                success: function (data) {
                    if(data.success){
                        toastr["success"](data.message).show()
                    }else{
                        toastr["error"](data.message).show()
                    }
                },
                error: function(error){
                    toastr["error"](error).show()
                }
            });
        }
    </script>
@endsection
