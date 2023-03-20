@extends('layouts.master')

@section('head')
@endsection

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Thông tin module chức năng</h3>
            </div>
            <form role="form" action="{{ route('applicationmodules-store') }}?index=true" method="post" id="frm">
                {{ csrf_field() }}
                <div class="box-body">
                    
                    <div class="form-group">
                        <label>Mã module <small class="text-danger text"> (*)</small>:</label>
                        <input type="text" class="form-control" name="code" value="{{ old('code') }}">
                        @if($errors->has('code'))<span class="text-danger">{{ $errors->first('code') }}</span>@endif                        
                    </div>                      
                    <div class="form-group">
                        <label>Tên module <small class="text-danger text"> (*)</small>:</label>
                        <input type="text" class="form-control" name="applicationmodulename" value="{{ old('applicationmodulename') }}">
                        @if($errors->has('applicationmodulename'))<span class="text-danger">{{ $errors->first('applicationmodulename') }}</span>@endif                        
                    </div>                      
                    <div class="form-group">
                        <label>Hiển thị/Ẩn:&nbsp;&nbsp;</label>
                        <input type="checkbox" tabindex="4" name="hidden" value="1" id="chk-hidden" {{ old('hidden')==1 ? 'checked="checked"' : '' }}>
                    </div>                      
                    <div class="form-group">
                        <label>Thứ tự hiển thị: </label>
                        <input type="text" class="form-control" name="displayorder" value="{{ old('displayorder') }}">
                    </div>                                      
                    <div class="form-group">
                        <label>Image : </label>
                        <input type="text" class="form-control" name="image" value="{{ old('image') }}">
                    </div>                                      
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Chức năng</h3>
            </div>
            <div class="box-body">
                <button type="submit" class="btn btn-primary btn-save" tabindex="5">Lưu</button>
                <a href="{{ route('applicationmodules-index') }}" class="btn btn-default btn-cancel" tabindex="6">Trở về</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@include('company-manage.applicationmodules.partials.script')
@endsection