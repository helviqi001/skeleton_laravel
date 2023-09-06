@extends('layouts.app')

@section('title','Edit Menu Group')
@section('content_header_title','Edit Menu Group')

@section('main-content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Menu Group</h3>
            <div class="box-tools">

            </div>
        </div>
        <div class="box-body table-responsive">
            <form action="" id="form" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name <span class="text-red">*</span></label>
                    <input type="text" class="form-control" name="name" value="{{ $data->name }}" required>
                </div>
                <div class="form-group">
                    <label for="sequence">Sequence <span class="text-red">*</span></label>
                    <input type="number" class="form-control" name="sequence" value="{{ $data->sequence }}" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="0" {{ $data->status == 0?'selected':'' }}>Inactive</option>
                        <option value="1" {{ $data->status == 1?'selected':'' }}>Active</option>
                    </select>
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
