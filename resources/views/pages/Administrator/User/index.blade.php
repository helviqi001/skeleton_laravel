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
        <div class="box-body no-padding table-responsive">
            <table class="table table-striped admin-list">
                <thead>
                <tr>
                    <th>Photo</th>
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
@endsection
@section('script')
    <script>
        $(function() {
            var $stateID, $editState, $isImgEditable = false,
                $content;

            var oDataList = $('.admin-list').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,
                ajax: {
                    url: '{{url('')}}' + '/admin/fn_get_data',
                    data: function(d) {

                    }
                },
                "fnDrawCallback": function(oSettings) {
                    $(".styled").uniform();
                },
                columns: [
                    { data: 'avatar', name: 'avatar', width: '10%'},
                    { data: 'name', name: 'name'},
                    { data: 'username', name: 'username'},
                    { data: 'email', name: 'email'},
                    { data: 'action', searchable: false, orderable: false, width: '25%' },
                ],
                "order": [
                    [3, "desc"]
                ]
            });
            $tableState = oDataList;

            //add button to datatables toolbar
            $("div.datatable-header").append('<button type="button" class="btn btnCreate" style="background-color: #6fa8dc; float: right; margin: 0px 5px">' +
                '<i class="icon-plus22"></i>Add New' +
                '</button>');

            //check screen width
            // function myFunction(x) {
            //     if (x.matches) { // If media query matches
            //         $('.btnCreate').css('margin-left', '69%');
            //     } else {
            //         $('.btnCreate').css('margin-left', '74%');
            //     }
            // }

            // var x = window.matchMedia("(max-width: 1400px)")
            // myFunction(x)

            if ($('#privAdd').val() == 0) {
                $('.btnCreate').css('display', 'none')
            }

            // Enable Select2 select for the length option
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: 'auto'
            });

            // NEW CREATE
            $('.btnCreate').on('click', function() {
                if ($('.panel-create').length == 0) {
                    $editState = false;
                    $.ajax({
                        url: _baseURL + '/user/create',
                        type: 'GET',
                        dataType: 'json',
                        data: {},
                        success: function(d) {
                            if (d.status == 200) {
                                $('.content-input').empty().append(d.template);
                                $('.select-search').select2({
                                    search: true
                                });
                                var infoSwitch = document.querySelectorAll('.switchery');
                                for (var i = 0; i < infoSwitch.length; i++) {
                                    var switchery = new Switchery(infoSwitch[i], { color: '#27ad38' });
                                }
                            }
                        },
                        beforeSend: function() {
                            blockUI('body')
                        },
                        complete: function() {
                            unblockUI('body')
                        }
                    })
                }
            });

            // SAVE PROCESS
            $('.content-input').on('click', '.saveCreate', function(e) {
                // Setup validation
                optValidate.rules = {};
                optValidate.message = {};
                $("#frmCreate").validate(optValidate);

                if ($('#frmCreate').valid()) {

                    var form = $('#frmCreate')[0];
                    var formData = new FormData(form);

                    console.log($('#frmCreate').serialize());

                    formData.append('is_edit', $editState ? 1 : 0);
                    if ($editState && $stateID) {
                        formData.append('user_id', $stateID);
                    }

                    $.ajax({
                        url: _baseURL + '/user/store',
                        type: 'post',
                        dataType: 'json',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(d) {
                            if (d.status == 200) {
                                if (d.success == true) {
                                    reloadTable(oDataList);
                                    $('.content-input').fadeOut(function() {
                                        $('.content-input').empty().show();
                                    });
                                    if ($editState) {
                                        showNoty('User data successfully updated', 'success');
                                    } else {
                                        console.log(d);
                                        showNoty('A new User data successfully created', 'success');
                                    }
                                } else {
                                    console.log(d);
                                    showNoty(d.message, 'error');
                                }
                            } else {
                                console.log(d);
                                showNoty(d.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        },
                        beforeSend: function() {
                            blockUI('body')
                        },
                        complete: function() {
                            unblockUI('body')
                        }
                    });

                    e.stopImmediatePropagation();
                    return false;
                }

                $(".page-layer-content").getNiceScroll().resize();

            });

            // CANCEL INPUT
            $('.content-input').on('click', '.cancelInput', function() {
                blockUI('body');
                $('.content-input').fadeOut(function() {
                    unblockUI('body')
                    $('.content-input').empty().show();
                });
            });

            // DELETE DATA
            $('.admin-list').on('click', '.btnDelete', function() {
                $('.content-input').fadeOut(function() {
                    $('.content-input').empty().show();
                });
                var tr = $(this).closest('tr');
                var data = oDataList.row(tr).data();

                deleteTableList(oDataList, 'user/delete', [data.user_id], true);
                return false;
            });

            // EDIT DATA
            $('.admin-list').on('click', '.btnEdit', function() {
                var tr = $(this).closest('tr');
                var data = oDataList.row(tr).data();
                editDataView(data.user_id);
            });

            // Detail DATA
            $('.admin-list').on('click', '.btnDetail', function() {
                var tr = $(this).closest('tr');
                var data = oDataList.row(tr).data();
                detailDataView(data.user_id);
            });

            function editDataView($dataID) {
                $editState = true;
                $stateID = $dataID;
                $.ajax({
                    url: _baseURL + '/user/edit/' + $dataID,
                    dataType: 'json',
                    data: {},
                    success: function(d) {
                        if (d.status == 200) {
                            $('.content-input').empty().append(d.template);
                            $('.select-search').select2({
                                search: true
                            });


                            var infoSwitch = document.querySelectorAll('.switchery');
                            for (var i = 0; i < infoSwitch.length; i++) {
                                var switchery = new Switchery(infoSwitch[i], { color: '#27ad38' });
                            }
                            $(document).scrollTop(0);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr)
                    },
                    beforeSend: function() {
                        blockUI('body')
                    },
                    complete: function() {
                        unblockUI('body')
                    }
                });
            }
        });
    </script>
@endsection
