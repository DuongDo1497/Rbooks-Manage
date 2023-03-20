@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <form role="form" action="{{ route('coupons-store') }}?continue=true" method="post" id="customer-form">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Tạo mới mã giảm giá') }}</h3>
                </div>
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group{{ ($errors->has('key')) ? ' has-error' : '' }}">
                        <label>{{ trans('home.Mã giảm giá') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Mã giảm giá') }}" name="key">
                        @if($errors->has('key'))<span class="help-block">{{ $errors->first('key') }}</span>@endif
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <label>{{ trans('home.% giảm giá') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.% giảm giá') }}" name="percent">
                        @if($errors->has('percent'))<span class="text-danger">{{ $errors->first('percent') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Số lượng') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Số lượng') }}" name="quantity">
                        @if($errors->has('quantity'))<span class="text-danger">{{ $errors->first('quantity') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Ghi chú') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Ghi chú') }}" name="description">
                        @if($errors->has('description'))<span class="text-danger">{{ $errors->first('description') }}</span>@endif
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
                        <a href="{{ route('coupons-index') }}" class="btn btn-default btn-cancel" tabindex="8">
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
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#customer-form').submit();
        });

        $('#birthday').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });

        $('#chk-continue').on('ifChecked', function() {
            $('#customer-form').attr('action', '{{ route('coupons-store') }}?continue=true');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#customer-form').attr('action', '{{ route('coupons-store') }}');
        });
    });
</script>
@endsection
