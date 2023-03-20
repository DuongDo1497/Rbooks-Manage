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
    <form role="form" action="{{ route('update-receipt', ['id' => $receipt->id]) }}" method="post" id="edit_receipt-form">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <div class="col-md-8" id="information">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Chỉnh sửa phiếu thu</h3>
                </div>
                <div class="box-body">

                	<div class="form-group">
                        <label>{{ trans('home.Ngày thu') }}</label>
                        <input type="date" class="form-control" placeholder="{{ trans('home.Nhập ngày thu') }}" name="date_revenue" value="{{ $receipt->date_revenue }}">
                    </div>

                    <div class="form-group">
                        <label>Số lượng</label>
                        <input type="text" class="form-control" placeholder="Số lượng" name="quantity" value="{{ $receipt->quantity }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tổng tiền đã thu (không VAT)') }}</label>
                                <input type="text" class="form-control" placeholder="{{ trans('home.Nhập tổng tiền đã trả (không VAT)') }}" name="dathu_notvat" value="{{ $receipt->dathu_notvat }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tổng tiền đã thu (có VAT)') }}</label>
                                <input type="text" class="form-control" placeholder="{{ trans('home.Nhập tổng tiền đã trả (có VAT)') }}" name="dathu_vat" value="{{ $receipt->dathu_vat }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Nội dung thu') }}</label>
                                <textarea class="form-control" placeholder="{{ trans('home.Nhập nội dung thu') }}" rows="4" name="content">{{ $receipt->content }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Ghi chú') }}</label>
                                <textarea class="form-control" placeholder="{{ trans('home.Nhập ghi chú') }}" rows="4" name="note">{{ $receipt->note }}</textarea>
                            </div>
                        </div>
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
                    <a href="{{ route('gross_revenues-detail', ['id' => $receipt->grossrevenue->id]) }}" class="btn btn-default btn-cancel" tabindex="10">{{ trans('home.Trở về') }}</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
@include('financial-manage.gross_revenue.partials.script')

<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#edit_receipt-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#edit_receipt-form').attr('action', '');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#edit_receipt-form').attr('action', '');
        });
    });
</script>
@endsection
