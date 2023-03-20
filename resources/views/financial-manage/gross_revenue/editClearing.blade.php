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
    <form role="form" action="{{ route('clearing_debt-update', $clearing->id) }}" method="post" id="edit_clearing-form">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Chỉnh sửa phiếu thu</h3>
                </div>
                <div class="box-body">

                	<div class="form-group">
                        <label>Số lượng hàng trả lại <small class="text-danger">(nếu có)</small></label>
                        <input type="text" value="{{$clearing->sl_tralai}}" class="form-control" placeholder="Số lượng hàng trả lại" name="sl_tralai">
                    </div>

                    <div class="row">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>Tổng tiền cấn trừ (không VAT)</label>
		                        <input type="text" value="{{$clearing->clearing_novat}}" class="form-control total-vat" placeholder="Nhập tổng tiền cấn trừ (không VAT)" name="clearing_novat">
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>Tổng tiền cấn trừ (có VAT)</label>
		                        <input type="text" class="form-control total-vat" value="{{$clearing->clearing_vat}}" placeholder="Nhập tổng tiền cấn trừ (có VAT)" name="clearing_vat">
		                    </div>
                    	</div>
                    </div>

                    <div class="row">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>Lý do</label>
		                        <textarea class="form-control" placeholder="Nhập lý do cấn trừ" rows="4" name="reason">{{$clearing->reason}}</textarea>
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Ghi chú') }}</label>
		                        <textarea class="form-control" placeholder="{{ trans('home.Nhập ghi chú') }}" rows="4" name="note">{{$clearing->note}}</textarea>
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
                    <a href="{{ route('gross_revenues-detail', ['id' => $clearing->dt_revenue_id]) }}" class="btn btn-default btn-cancel" tabindex="10">{{ trans('home.Trở về') }}</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
