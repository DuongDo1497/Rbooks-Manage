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
    <form role="form" action="{{ route('tscds-update', ['id' => $tscd->id]) }}?continue=true" method="post" id="tscd-form">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Chỉnh sửa tài sản cố định') }}</h3>
                </div>
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="box-body">
                    <div class="form-group">
                        <label>{{ trans('home.Mã tài sản') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập mã tài sản') }}" value="{{ $tscd->code }}" name="code">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Tên tài sản') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập tên tài sản') }}" value="{{ $tscd->name }}" name="name">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Số lượng') }}</label>
                        <input type="number" class="form-control" placeholder="{{ trans('home.Nhập số lượng') }}" value="{{ $tscd->quantity }}" name="quantity">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Vị trí') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập vị trí') }}" value="{{ $tscd->position }}" name="position">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Trạng thái') }}</label>
                        <select class="form-control select2" name="status">
                            <option {{ $tscd->status == 1 ? 'selected': '' }} value="1">{{ trans('home.Mới tạo') }}</option>
                            <option {{ $tscd->status == 2 ? 'selected': '' }} value="2">{{ trans('home.Đề xuất duyệt') }}</option>
                            @if (Auth::user()->hasRole(['owner', 'admin']))
                                <option {{ $tscd->status == 3 ? 'selected': '' }} value="3">{{ trans('home.Duyệt') }}</option>
                                <option {{ $tscd->status == 4 ? 'selected': '' }} value="4">{{ trans('home.Không duyệt') }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Ghi chú') }} </label>
                        <textarea class="form-control" name="note" rows="2">{{ $tscd->note }}</textarea>
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
                    <a href="{{ route('tscds-index') }}" class="btn btn-default btn-cancel" tabindex="10">{{ trans('home.Trở về') }}</a>
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
            $('#tscd-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#tscd-form').attr('action', '');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#tscd-form').attr('action', '');
        });
    });
</script>
@endsection
