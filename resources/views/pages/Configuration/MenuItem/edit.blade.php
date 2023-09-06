@extends('layouts.app')

@section('title','Edit Menu Item')
@section('content_header_title','Edit Menu Group')

@section('main-content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Menu Item</h3>
            <div class="box-tools">

            </div>
        </div>
        <div class="box-body table-responsive">
            <form action="" id="form" method="POST">
                @csrf
                <div class="form-group">
                    <label for="menu_group_id">Menu Group <span class="req">*</span></label>
                    <select name="menu_group_id" class="form-control select-search" required>
                        @if(empty($menuGroups))
                            <option selected disabled>Please create menu group first</option>
                        @else
                            @foreach ($menuGroups as $item)
                            <option value="{{ $item['menu_group_id'] }}" {{ $data->menu_group_id == $item['menu_group_id']?'selected':'' }}>{{ $item['name'] }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Name <span class="text-red">*</span></label>
                    <input type="text" class="form-control" name="name" value="{{ $data->name }}" required>
                </div>
                <div class="form-group">
                    <label for="url">URL <span class="text-red">*</span></label>
                    <input type="text" class="form-control" name="url" value="{{ $data->url }}" required>
                </div>
                <div class="form-group">
                    <label for="sequence">Sequence <span class="text-red">*</span></label>
                    <input type="number" class="form-control" name="sequence" value="{{ $data->sequence }}" required>
                </div>
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
