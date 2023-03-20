@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Thêm mới</h3>
            </div>
            <form method="post" action="{{ route("authors-store") }}?continue=true" role="form" id="author-form">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
                        <label for="name">Họ và tên</label>
                        <input id="name" type="text" class="form-control" placeholder="Họ và tên" name="name" tabindex="1" value="{{ old('name') }}">
                        @if($errors->has('name'))<span class="help-block">{{ $errors->first('name') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label for="slug">URL</label>
                        <div class="input-group">
                            <span class="input-group-addon">https://rbooks.vn/</span>
                            <input type="text" id="slug" class="form-control" placeholder="Url" name="slug" tabindex="2" value="{{ old('slug') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Giới thiệu</label>
                        <textarea id="description" name="description" rows="10" cols="80" tabindex="3">{{ old('description') }}</textarea>
                    </div>
                </div>
                <input type="hidden" name="image_id" id="image_id">
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Chức năng</h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label class="cur-pointer"><input type="checkbox" class="flat-red" tabindex="4"{{ old('continue') === 1 ? ' checked="checked"' : '' }} name="continue" value="1" checked="checked" id="chk-continue"> Lưu và thêm mới</label>
                </div>
                <button type="submit" class="btn btn-primary btn-save" tabindex="5">Lưu</button>
                <a href="{{ route('authors-index') }}" class="btn btn-default btn-cancel" tabindex="6">Trở về</a>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Hình ảnh</h3>
            </div>
            <div class="box-body">
                <form id="image-dropzone" class="dropzone" action="{{ route('api-images-upload') }}">
                    <div class="fallback">
                        <input name="image" type="file" />
                    </div>
                </form>
                <div id="upload-images-preview"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@include('product-manage.author.partials.script')
@endsection
