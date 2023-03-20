@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@section('content')

@if(isset($infor))
<div class="alert alert-success">
    {{ $infor }} 
</div>
@endif

@include('company-manage.checkemployeemonth.partials.search-form')

<div class="note">
	<div class="row">
		<div class="col-md-12">
			<h4>
				<u>{{ trans('home.Ghi chú') }}:</u><br>
				<small>- {{ trans('home.Chọn tháng/năm cần tổng hợp chấm công') }}.</small><br>
				<small>- {{ trans('home.Nhấn nút') }} <b>{{ trans('home.Tạo mới') }}</b> {{ trans('home.để tạo mới bảng chấm công, nếu bảng chấm công đã được duyệt, bạn chỉ có thể') }} <b>{{ trans('home.Xem lại bảng chấm công đã lưu') }}</b>.</small><br>
				<small>- {{ trans('home.Để duyệt/bỏ duyệt bảng tổng hợp chấm công') }}, {{ trans('home.nhấn nút') }} <b>{{ trans('home.Xem bảng chấm công đã lưu') }}</b>, {{ trans('home.nhấn nút') }} <b>{{ trans('home.Đồng ý duyệt') }}</b>/<b>{{ trans('home.Bỏ duyệt') }}</b> {{ trans('home.để duyệt bảng tổng hợp chấm công') }}.</small><br>
				<small>- {{ trans('home.Bảng tổng hợp chấm công chỉ được') }} <b>{{ trans('home.Xóa') }}</b> {{ trans('home.hoặc') }} <b>{{ trans('home.Tạo mới') }}</b> {{ trans('home.lại khi bảng tổng hợp chấm công chưa được duyệt') }}.</small><br>
				<small>- {{ trans('home.Xuất file excel khi bảng tổng hợp chấm công đã được lưu') }}.</small><br>
			</h4>
		</div>
	</div>
</div>


@endsection

