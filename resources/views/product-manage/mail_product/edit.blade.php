@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <form role="form" action="{{ route('mail_products-update', ['id' => $model->id]) }}?continue=true" method="post" id="mail_products-form">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Chỉnh sửa quy trình gửi mail</h3>
                </div>
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
                                <label>Tiêu đề gửi mail</label>
                                <input type="text" class="form-control" value="{{ $model->name }}" name="name">
                                @if($errors->has('name'))<span class="help-block">{{ $errors->first('name') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group{{ ($errors->has('product_id')) ? ' has-error' : '' }}">
                                <label>Sách hiện tại</label>
                                <select class="form-control select2" name="product_id">
                                    <option value="{{ $model->product()->first() == NULL ? "" : $model->product()->first()->id }}">{{ $model->product()->first() == NULL ? "" : $model->product()->first()->name }}</option>
                                    <option>Chọn sách</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Nội dung giới thiệu</label>
                        <textarea id="description" name="content" rows="10">{{ $model->content }}</textarea>
                        @if($errors->has('content'))<span class="text-danger">{{ $errors->first('content') }}</span>@endif
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sách kế tiếp gửi mail</label>
                                <select class="form-control select2" name="next_product_id">
                                    <option value="{{ $model->nextproduct()->first() == NULL ? "" : $model->nextproduct()->first()->id }}">{{ $model->nextproduct()->first() == NULL ? "" : $model->nextproduct()->first()->name }}</option>
                                    <option>Chọn sách</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Số ngày gửi tiếp theo</label>
                                <input type="text" class="form-control" value="{{ $model->aftersendday }}" name="aftersendday">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Thứ tự gửi mail</label>
                                <input type="text" class="form-control" value="{{ $model->ordernum }}" name="ordernum">
                                @if($errors->has('ordernum'))<span class="text-danger">{{ $errors->first('ordernum') }}</span>@endif
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
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary btn-save" tabindex="7">
                            <img src="{{ asset('img/icon-save.png') }}" alt="">
                            <span><b>{{ trans('home.Lưu') }}</b></span>
                        </button>
                        <a href="{{ route('mail_products-index') }}" class="btn btn-default btn-cancel" tabindex="8">
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
<script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#mail_products-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#mail_products-form').attr('action', '');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#mail_products-form').attr('action', '');
        });
        CKEDITOR.replace('description');
    });
</script>
@endsection
