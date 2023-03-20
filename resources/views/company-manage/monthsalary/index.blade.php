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

@include('company-manage.monthsalary.partials.search-form')

<div class="note">
	<div class="row">
		<div class="col-md-12">
			<h4>
				<u>{{ trans('home.Ghi chú') }}:</u><br>

				<small>- {{ trans('home.Chọn tháng/năm cần lập bảng tính lương') }}.</small><br>

				<small>- {{ trans('home.Nhấn nút') }} <b>{{ trans('home.Tạo mới') }}</b> {{ trans('home.để tạo mới bảng tính lương, nếu bảng tính lương đã được duyệt, bạn chỉ có thể') }} <b>{{ trans('home.Xem lại bảng tính lương đã lưu') }}</b>.</small><br>

				<small>- {{ trans('home.Để duyệt/bỏ duyệt bảng tính lương') }}, {{ trans('home.nhấn nút') }} <b>{{ trans('home.Xem bảng tính bảo hiểm xã hội đã lưu') }}</b>, {{ trans('home.nhấn nút') }} <b>{{ trans('home.Đồng ý duyệt') }}</b>/<b>{{ trans('home.Bỏ duyệt') }}</b> {{ trans('home.để duyệt bảng tính lương') }}.</small><br>

				<small>- {{ trans('home.Bảng tính lương chỉ được') }} <b>{{ trans('home.Xóa') }}</b> {{ trans('home.hoặc') }} <b>{{ trans('home.Tạo mới') }}</b> {{ trans('home.lại khi bảng tính lương chưa được duyệt') }}.</small><br>

				<small>- {{ trans('home.Xuất file excel khi bảng tính lương đã được lưu') }}.</small><br>
			</h4>
		</div>
	</div>

</div>

@endsection

