@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<div class="row">
    <form role="form" action="{{ route('documents-update', ['id' => $document->id]) }}?continue=true" method="post" id="documents-form" enctype="multipart/form-data">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Chỉnh sửa tài liệu</h3>
                </div>
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="box-body">

                    <div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
                        <label>Tên tài liệu</label>
                        <input type="text" class="form-control" placeholder="" name="name" value="{{ $document->name }}" tabindex="1">
                        @if($errors->has('name'))<span class="help-block">{{ $errors->first('fullname') }}</span>@endif
                    </div>

                    <div class="form-group{{ ($errors->has('note')) ? ' has-error' : '' }}">
                        <label>{{ trans('home.Ghi chú') }}</label>
                        <input type="text" class="form-control" placeholder="" name="note" value="{{ $document->note }}" tabindex="1">
                        @if($errors->has('note'))<span class="help-block">{{ $errors->first('note') }}</span>@endif
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-4">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Chức năng') }}</h3>
                </div>
                <div class="box-body">
                    <button type="submit" class="btn btn-primary btn-save" tabindex="9">{{ trans('home.Lưu') }}</button>
                    <a href="{{ route('documents-index') }}" class="btn btn-default btn-cancel" tabindex="10">{{ trans('home.Trở về') }}</a>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Upload CV</h3>
                </div>
                <div class="box-body">
                    <input class="file_cv_add" type="file" name="filename" id="file_cv">
                    <label for="file_cv" class="clearfix fileName">
                        <span></span>
                        <strong><i class="fa fa-upload"></i> Choose a file&hellip;</strong>
                    </label>
                    <p class="text-danger" style="margin-top: 10px;">{{ trans('home.Lưu ý: Tải file .pdf và dung lượng file dưới 1 MB') }}</p>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#documents-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#documents-form').attr('action', '');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#documents-form').attr('action', '');
        });
    });
</script>
@endsection
