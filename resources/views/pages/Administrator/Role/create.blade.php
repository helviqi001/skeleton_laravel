@extends('layouts.app')

@section('title','Create Role')
@section('content_header_title','Create Role')

@section('main-content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Role</h3>
            <div class="box-tools">
                test
            </div>
        </div>
        <div class="box-body">
            <form action="" id="form" method="POST">
                @csrf
                <div class="form-group">
                    <label for="employeeFirstName">Name<span class="text-red">*</span></label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="form-group">
                    <label for="employeeFirstName">Description</label>
                    <input type="text" class="form-control" name="description">
                </div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Menu</th>
                        <th width="10%">View</th>
                        <th width="10%">Add</th>
                        <th width="10%">Edit</th>
                        <th width="10%">Delete</th>
                        <th width="10%">Other</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($menuItems as $menuItem)
                        <tr>
                            <td>{{ $menuItem->name }}</td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"
                                               class=""
                                               name="menu[{{ $menuItem->menuItemId }}][menuView]"
                                               value="1">
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"
                                               class=""
                                               name="menu[{{ $menuItem->menuItemId }}][menuAdd]"
                                               value="1">
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="" name="menu[{{ $menuItem->menuItemId }}][menuEdit]" value="1">
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="" name="menu[{{ $menuItem->menuItemId }}][menuDelete]" value="1">
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="" name="menu[{{ $menuItem->menuItemId }}][menuOther]" value="1">
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </form>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                <button class="btn btn-default" onclick="history.back()">Back</button>
                <button class="btn btn-primary" form="form">Save</button>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
