@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@section('content')
@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Thêm mới tài khoản đăng nhập</h3>
            </div>
            
            <form action="{{ route('users-store') }}" enctype="multipart/form-data" method="POST">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group {{ ($errors->has('name')) ? ' has-error' : '' }}">
                        <label>Tên người dùng <small class="text-danger text"> (*)</small></label>
                        <input type="text" class="form-control" name="name" id="name" tabindex="1" value="{{ old('name') }}">
                        @if($errors->has('name'))<span class="help-block">{{ $errors->first('name') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>Email đăng nhập <small class="text-danger text"> (*)</small></label>
                        <input type="text" class="form-control" name="email" id="email" tabindex="2" value="{{ old('email') }}">
                        @if($errors->has('email'))<span class="help-block">{{ $errors->first('email') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu <small class="text-danger text"> (*)</small></label>
                        <input type="password" class="form-control" name="password" tabindex="3" value="">
                    </div>
                    <div class="form-group">
                        <label>Quyền truy cập <small class="text-danger text"> (*)</small></label>
                        <select class="form-control" name="role">
                            <option value=""></option>
                            @foreach($applicationroles as $item)
                                @if($item->code == old('role'))
                                    <option value="{{ $item->code }}" selected>{{ $item->code . '. ' . $item->name }}</option>
                                @else
                                    <option value="{{ $item->code }}">{{ $item->code . '. ' . $item->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Trạng thái tài khoản <small class="text-danger text"> (*)</small></label>
                        <select class="form-control select2" name="blocked">
                            @foreach($accounttypes as $key=>$value)
                                @if($key == old('blocked'))
                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>                                                                    
                                @endif
                            @endforeach
                        </select>
                        @if($errors->has('blocked'))<span class="text-danger">{{ $errors->first('blocked') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Thời hạn từ ngày</label>
                            </div>
                            <div class="col-md-3">
                                <input type='text' class="form-control" name="begin_at" id='begin_at' value="{{ old('begin_at') }}"/>
                                @if($errors->has('begin_at'))<span class="text-danger">{{ $errors->first('begin_at') }}</span>@endif
                            </div>
                            <div class="col-md-2">
                                <label>đến ngày</label>
                            </div>
                            <div class="col-md-3">
                                <input type='text' class="form-control" name="finish_at" id='finish_at' value="{{ old('finish_at') }}"/>
                                @if($errors->has('finish_at'))<span class="text-danger">{{ $errors->first('finish_at') }}</span>@endif
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <button type="submit" style="width: 20%;" class="btn btn-primary btn-save" tabindex="9" onclick="processReports('frm', 'save')">Lưu</button>
        <a href="{{ route('users-index') }}" style="width: 20%;" class="btn btn-default btn-cancel" tabindex="11">Trở về</a>
        </form>

</div>
@endsection

@section('scripts')
@include('user-employees.user.user_account.partials.script');
@endsection