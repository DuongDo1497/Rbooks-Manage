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
                <h3 class="box-title">Chỉnh sửa thông tin tác giả</h3>
            </div>
            <form method="post" action="{{ route('authors-update', ['id' => $model->id ]) }}?continue=true" role="form" id="author-form">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="box-body">
                    <div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
                        <label for="name">Họ và tên</label>
                        <input id="name" type="text" class="form-control" placeholder="Họ và tên" name="name" tabindex="1" value="{{ $model->name }}">
                        @if($errors->has('name'))<span class="help-block">{{ $errors->first('name') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label for="slug">URL</label>
                        <div class="input-group">
                            <span class="input-group-addon">https://rbooks.vn/</span>
                            <input id="slug" type="text" class="form-control" placeholder="Url" name="slug" tabindex="2" value="{{ $model->slug }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Giới thiệu</label>
                        <textarea id="description" name="description" rows="10" cols="80" tabindex="3">{!! $model->description !!}</textarea>
                    </div>
                </div>
                <input type="hidden" name="image_id" id="image_id" value="{{ $model->image_id }}">
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
                    <label class="cur-pointer"><input type="checkbox" class="flat-red" tabindex="4"{{ old('continue') === 1 ? ' checked="checked"' : '' }} name="continue" value="1" checked="checked" id="chk-continue"> Lưu và tiếp tục chỉnh sửa</label>
                </div>
                <button type="submit" class="btn btn-primary btn-save" tabindex="5">Lưu</button>
                <a href="{{ route('authors-index') }}" class="btn btn-default btn-cancel" tabindex="6">Trở về</a>
                <hr>
                <ul class="list-unstyled">
                    <li><b>Ngày khởi tạo:</b> {{ $model->created_at }}</li>
                    <li><b>Ngày chỉnh sửa:</b> {{ $model->updated_at }}</li>
                    <li><b>Người sửa cuối:</b> <a href="{{-- TODO: add link to user's page --}}#" target="_blank" title="Click mở trong tab mới">{{ $model->users->name }} <i class="fa fa-external-link" aria-hidden="true"></i></a></li>
                </ul>
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
