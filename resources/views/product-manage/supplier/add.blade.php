@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Tạo mới đối tác RB</h3>
            </div>
            <form  method="post" action="{{ route('suppliers-store') }}" role="form" id="supplier-form">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group {{ ($errors->has('code')) ? ' has-error' : '' }}">
                        <label>ID</label>
                        <input type="text" class="form-control" placeholder="ID Đối tác RB" name="code" tabindex="1" >
                        @if($errors->has('code'))<span class="help-block">{{ $errors->first('code') }}</span>@endif
                    </div>
                    <div class="form-group {{ ($errors->has('name')) ? ' has-error' : '' }}">
                        <label>Tên đối tác RB</label>
                        <input id="name" type="text" class="form-control" placeholder="Tên đối tác RB" name="name" tabindex="2" >
                        @if($errors->has('name'))<span class="help-block">{{ $errors->first('name') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>URL</label>
                        <div class="input-group">
                            <span class="input-group-addon">https://rbooks.vn/</span>
                            <input id="slug" type="text" class="form-control" placeholder="Url" name="slug" tabindex="3" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.Địa chỉ') }}</label>
                            <input type="text" class="form-control" placeholder="{{ trans('home.Địa chỉ') }}" name="address" tabindex="4">
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Số điện thoại') }}:</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                    <input type="text" tabindex="5" name="phone" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="text" class="form-control" placeholder="Email" name="email" tabindex="6">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.Chiết khấu') }}</label>
                            <input type="number" class="form-control" placeholder="{{ trans('home.Chiết khấu') }}" name="discount" tabindex="7">
                        </div>
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
                    <a href="{{ route('suppliers-index') }}" class="btn btn-default btn-cancel" tabindex="8">
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
@include('product-manage.supplier.partials.script')
@endsection

