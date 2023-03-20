@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <form role="form" action="{{ route('promotions-update', ['id' => $model->id]) }}?continue=true" method="post" id="promotions-form">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Chỉnh sửa mã giảm giá</h3>
                </div>
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="box-body">
                    <div class="form-group{{ ($errors->has('fullname')) ? ' has-error' : '' }}">
                        <label>Tên khách hàng</label>
                        <input type="text" class="form-control" placeholder="Tên khách hàng" name="fullname" value="{{ $model->fullname }}" tabindex="1">
                        @if($errors->has('fullname'))<span class="help-block">{{ $errors->first('fullname') }}</span>@endif
                    </div>
                    <div class="form-group{{ ($errors->has('key')) ? ' has-error' : '' }}">
                        <label>Mã giảm giá</label>
                        <input type="text" class="form-control" name="key"value="{{ $model->key }}" tabindex="1">
                        @if($errors->has('key'))<span class="help-block">{{ $errors->first('key') }}</span>@endif
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <label>% giảm giá</label>
                        <input type="text" class="form-control" name="percent" value="{{ $model->percent }}" tabindex="2">
                        @if($errors->has('percent'))<span class="text-danger">{{ $errors->first('percent') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>Số lượng</label>
                        <input type="text" class="form-control" name="quantity" value="{{ $model->quantity }}" tabindex="3">
                        @if($errors->has('quantity'))<span class="text-danger">{{ $errors->first('quantity') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>Ghi chú</label>
                        <input type="text" class="form-control" name="description" value="{{ $model->description }}" tabindex="4">
                        @if($errors->has('description'))<span class="text-danger">{{ $errors->first('description') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>Tình trạng</label>
                        <select name="status" class="form-control">
                            @if($model->status == 0)
                                <option value="0">Chưa hoạt động</option>
                                <option value="1">Kích hoạt coupon</option>
                                <option value="2">Hủy coupon</option>
                            @elseif($model->status == 1)
                                <option value="1">Kích hoạt coupon</option>
                                <option value="2">Hủy coupon</option>
                            @else
                                <option value="2">Hủy coupon</option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Chức năng</h3>
                </div>
                <div class="box-body">
                    <button type="submit" class="btn btn-primary btn-save" tabindex="9">Lưu</button>
                    <a href="{{ route('promotions-index') }}" class="btn btn-default btn-cancel" tabindex="10">Trở về</a>
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
            $('#promotions-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#promotions-form').attr('action', '{{ route('promotions-edit', ['id' => $model->id]) }}?continue=true');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#promotions-form').attr('action', '{{ route('promotions-edit', ['id' => $model->id]) }}');
        });
    });
</script>
@endsection
