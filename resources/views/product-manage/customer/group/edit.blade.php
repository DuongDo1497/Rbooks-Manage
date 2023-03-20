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
                <h3 class="box-title">{{ trans('home.Chỉnh sửa thông tin khách hàng') }}</h3>
            </div>
            <form role="form" action="{{ route('customers-groups-update', ['id' => $model->id]) }}?continue=true" method="post" id="customers-groups-form">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="box-body">
                    <div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
                        <label>{{ trans('home.Tên nhóm') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Tên nhóm khách hàng') }}" name="name" value="{{ $model->name }}">
                        @if($errors->has('name'))<span class="help-block">{{ $errors->first('name') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Mã nhóm') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Mã nhóm khách hàng') }}" name="code" value="{{ $model->code }}">
                        @if($errors->has('code'))<span class="help-block">{{ $errors->first('code') }}</span>@endif
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-primary box-control">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('home.Chức năng') }}</h3>
            </div>
            <div class="box-body">
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary btn-save" tabindex="7">
                        <img src="{{ asset('img/icon-save.png') }}" alt="">
                        <span><b>{{ trans('home.Lưu') }}</b></span>
                    </button>
                    <a href="{{ route('customers-groups-index') }}" class="btn btn-default btn-cancel" tabindex="8">
                        <img src="{{ asset('img/icon-cancel.png') }}" alt="">
                        <span><b>Thoát</b></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#customers-groups-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#customers-groups-form').attr('action', '{{ route('customers-groups-edit', ['id' => $model->id]) }}?continue=true');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#customers-groups-form').attr('action', '{{ route('customers-groups-edit', ['id' => $model->id]) }}');
        });
    });
</script>
@endsection
