@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@section('content')

@if(session()->has('success'))
@include('layouts.partials.messages.success')
@endif
<div class="row">

    <form method="post" action="{{ route('warehouses-update', ['id' => $model->id]) }}?continue=true" role="form" id="warehouse-form">
        {{ csrf_field() }}
        {{ method_field('put') }}

        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Thêm mới') }}</h3>
                </div>
                <div class="box-body">
                    <div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
                        <label for="name">{{ trans('home.Tên kho') }}</label>
                        <input id="name" type="text" class="form-control" placeholder="Tên kho" name="name" tabindex="1" value="{{ $model->name }}">
                        @if($errors->has('name'))<span class="help-block">{{ $errors->first('name') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Ký tự') }}</label>
                        <input type="text" class="form-control" name="characters" value="{{ $model->characters }}">
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.Địa chỉ') }}</label>
                            <input type="text" class="form-control" name="address" value="{{ $model->address }}" tabindex="2">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.Số điện thoại') }}</label>
                            <div class="input-group">
                                <div class="input-group-addon">+84</div>
                                <input class="form-control" type="text" name="phone" value="{{ $model->phone }}" tabindex="3">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.Lệ phí') }}</label>
                            <input type="text" class="form-control" name="fee_percent" value="{{ $model->fee_percent }}" tabindex="4">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.Lợi nhuận') }}</label>
                            <div class="input-group addon-right">
                                <input class="form-control" type="text" name="profit_percent" value="{{ $model->profit_percent }}" tabindex="5">
                                <div class="input-group-addon"><i class="fa fa-percent"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary box-control">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Chức năng') }}</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select class="form-control" name="status">
                            <option value="{{$model->status}}">{{$model->status_text}}</option>
                            <option value="0">Đang đóng</option>
                            <option value="1">Đang hoạt động</option>

                        </select>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary btn-save" tabindex="7">
                            <img src="{{ asset('img/icon-save.png') }}" alt="">
                            <span><b>{{ trans('home.Lưu') }}</b></span>
                        </button>
                        <a href="{{ route('warehouses-index') }}" class="btn btn-default btn-cancel" tabindex="8">
                            <img src="{{ asset('img/icon-cancel.png') }}" alt="">
                            <span><b>Thoát</b></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('scripts')
@include('product-manage.warehouse.partials.script')
@endsection