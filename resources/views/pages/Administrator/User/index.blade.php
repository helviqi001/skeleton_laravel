@extends('layouts.app')

@section('title','Admin List')
@section('content_header_title','Admin List')

@section('main-content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Admin</h3>
            <div class="box-tools">
                test
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-striped admin-list">
                <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                <a class="btn btn-primary" href="admin/create/">Create</a>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Area</h4>
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
        let dataTable = $('.admin-list').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: window.location.href + "/fn_get_data",
            },
            columns: [
                {data: 'avatar', name: 'avatar', width: '10%', searchable: false, orderable: false},
                {data: 'name', name: 'name'},
                {data: 'username', name: 'username'},
                {data: 'email', name: 'email'},
                {data: 'action', searchable: false, orderable: false, width: '25%'},
            ],
        })

        function fnDelete(component, id) {
            let modalDelete = $('#modal-delete')
            let name = component.parentElement.parentElement.childNodes[1].textContent
            modalDelete.find('div.modal-body>p')[0].textContent = "Are you sure want to delete " + name + "?"
            modalDelete.find('div.modal-footer>a')[0].href = 'admin/delete/' + id
            modalDelete.modal()
        }
    </script>
@endsection
