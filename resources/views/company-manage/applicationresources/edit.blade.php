@extends('layouts.master')

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Thông tin trang truy cập</h3>
            </div>
            <form role="form" action="{{ route('applicationresources-update', ['id' => $model->id]) }}?continue=true" method="post" id="frm">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label>Mã trang truy cập <small class="text-danger text"> (*)</small>:</label>
                        <input type="text" class="form-control" name="code" value="{{ $model->code }}">
                        @if($errors->has('code'))<span class="text-danger">{{ $errors->first('code') }}</span>@endif                        
                    </div>                      
                    <div class="form-group">
                        <label>Tên trang truy cập <small class="text-danger text"> (*)</small>:</label>
                        <input type="text" class="form-control" name="name" value="{{ $model->name }}">
                        @if($errors->has('name'))<span class="text-danger">{{ $errors->first('name') }}</span>@endif                        
                    </div>                                           
                    <div class="form-group">
                        <label>File name : </label>
                        <input type="text" class="form-control" name="filename" value="{{ $model->filename }}">
                    </div>                                           
                    <div class="form-group">
                        <label>Page security : </label>
                        <input type="text" class="form-control" name="pagesecurity" value="{{ $model->pagesecurity }}">
                    </div>                                           
                    <div class="form-group">
                        <label>Image : </label>
                        <input type="text" class="form-control" name="image" value="{{ $model->image }}">
                    </div>                                           
                    <div class="form-group">
                        <label>Prefix : </label>
                        <input type="text" class="form-control" name="prefix" value="{{ $model->prefix }}">
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
                <a href="{{ route('applicationresources-index') }}" class="btn btn-default btn-cancel" tabindex="6">Trở về</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@include('company-manage.applicationresources.partials.script')
@endsection