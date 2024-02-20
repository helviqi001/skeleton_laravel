@extends('layouts.app')

@section('title','Create Admin')
@section('content_header_title','Create Admin')

@section('main-content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Admin</h3>
            <div class="box-tools">

            </div>
        </div>
        <div class="box-body">
            <form action="" id="form" class="form-horizontal" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="form-group">
                    <label class="control-label col-lg-2 cursor-pointer" for="role_id">Role <span class="req">*</span></label>
                    <div class="col-lg-10">
                        <select name="role_id" class="form-control select-search" required>
                            @if(empty($roles))
                                <option selected disabled>Please create role first</option>
                            @else
                                @foreach ($roles as $item)
                                <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2 cursor-pointer" for="email">Email Address <span class="req">*</span></label>
                    <div class="col-lg-10">
                        <input type="email" id="email" name="email" class="form-control" required="required" value="" />
                        <p class="help-block validation-error emailValid" style="display: none; color: red;">Invalid Email Format, ex: user@mail.com</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2 cursor-pointer" for="username">Username <span class="req">*</span></label>
                    <div class="col-lg-10">
                        <input type="text"  id="username" minlength="2" name="username" class="form-control" required="required" value="" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2 cursor-pointer" for="password">Password <span class="req">*</span></label>
                    <div class="col-lg-10">
                        <input type="password" id="password" name="password" class="form-control" value="" required />
                        <div class="form-control-feedback reveal-password" style="padding-right: 1em; pointer-events: initial">
                            <i class="icon-eye text-muted"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2 cursor-pointer" for="password_confirmation">Password Confirmation <span class="req">*</span></label>
                    <div class="col-lg-10">
                        <input type="password" id="password_confirmation" class="form-control" value="" required />
                        <div class="form-control-feedback reveal-password-confirmation" style="padding-right: 1em; pointer-events: initial">
                            <i class="icon-eye text-muted"></i>
                        </div>
                        <p class="help-block validation-error confirmation" style="display: none; color: red;">Password Confirmation does not match with Password </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2 cursor-pointer" for="name">Name <span class="req">*</span></label>
                    <div class="col-lg-10">
                        <input type="text"  id="name" minlength="2" name="name" class="form-control" required="required" value="" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2 cursor-pointer" for="value">Photo</label>
                    <div class="col-lg-10">
                        <span class="text-muted">Maximum 2MB </span>
                        <input type="file" name="photo" class="form-control" accept="image/*" />
                    </div>
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
