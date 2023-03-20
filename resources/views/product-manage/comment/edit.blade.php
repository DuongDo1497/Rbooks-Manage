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
                <h3 class="box-title">Chỉnh sửa nhà cung cấp</h3>
            </div>
            <form  method="post" action="{{ route('suppliers-update', ['id' => $model->id ]) }}" role="form" id="supplier-form">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="box-body">
                    <div class="form-group">
                        <label>Code</label>
                        <input type="text" class="form-control" placeholder="ID nhà cung cấp" name="code" tabindex="1" value="{{ $model->code }}">
                    </div>
                        <div class="form-group {{ ($errors->has('name')) ? ' has-error' : '' }}">
                            <label>Tên nhà cung cấp</label>
                            <input type="text" class="form-control" placeholder="Tên nhà cung cấp" name="name" tabindex="2" value="{{ $model->name }}">
                            @if($errors->has('name'))<span class="help-block">{{ $errors->first('name') }}</span>@endif
                        </div>
                        <div class="form-group">
                            <label>URL</label>
                            <div class="input-group">
                                <span class="input-group-addon">https://rbooks.vn/</span>
                                <input type="text" class="form-control" placeholder="Url" name="slug" tabindex="3" value="{{ $model->slug }}">
                            </div>
                        </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Địa chỉ</label>
                            <input type="text" class="form-control" placeholder="Địa chỉ" name="address" tabindex="4" value="{{ $model->address }}">
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label>Số điện thoại:</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                    <input type="text" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask tabindex="5" value="{{ $model->phone }}" name="phone"> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="text" class="form-control" placeholder="Email" name="email" tabindex="6" value="{{ $model->email }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Chiết khấu</label>
                            <input type="number" class="form-control" placeholder="Chiết khấu" name="discount" tabindex="7" value="{{ $model->discount }}">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-primary box-control">
            <div class="box-header with-border">
                <h3 class="box-title">Chức năng</h3>
            </div>
            <div class="box-body">
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary btn-save" tabindex="7">
                        <img src="{{ asset('img/icon-save.png') }}" alt="">
                        <span><b>{{ trans('home.Lưu') }}</b></span>
                    </button>
                    <a href="{{ route('comments-index') }}" class="btn btn-default btn-cancel" tabindex="8">
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

