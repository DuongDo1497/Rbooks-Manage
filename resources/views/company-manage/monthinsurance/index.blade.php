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

@include('company-manage.monthinsurance.partials.search-form')

<div class="note">
	<div class="row">
		<div class="col-md-12">
			<h4>
				<u>{{ trans('home.Ghi chú') }}:</u><br>
				<small>- {{ trans('home.Chọn tháng/năm cần lập bảng tính bảo hiểm xã hội') }}.</small><br>
				<small>- {{ trans('home.Nhấn nút') }} <b>{{ trans('home.Tạo mới') }}</b> {{ trans('home.để tạo mới bảng tính bảo hiểm xã hội, nếu bảng tính bảo hiểm xã hội đã được duyệt, bạn chỉ có thể') }} <b>{{ trans('home.Xem bảng tính bảo hiểm xã hội đã lưu') }}</b>.</small><br>
				<small>- {{ trans('home.Để duyệt/bỏ duyệt bảng tính bảo hiểm xã hội') }}, {{ trans('home.nhấn nút') }} <b>{{ trans('home.Xem bảng tính bảo hiểm xã hội đã lưu') }}</b>, {{ trans('home.nhấn nút') }} <b>{{ trans('home.Đồng ý duyệt') }}</b>/<b>{{ trans('home.Bỏ duyệt') }}</b> {{ trans('home.để duyệt bảng tính bảo hiểm xã hội') }}.</small><br>
				<small>- {{ trans('home.Bảng tính bảo hiểm xã hội chỉ được') }} <b>{{ trans('home.Xóa') }}</b> {{ trans('home.hoặc') }} <b>{{ trans('home.Tạo mới') }}</b> {{ trans('home.lại khi bảng tính bảo hiểm xã hội chưa được duyệt') }}.</small><br>
				<small>- {{ trans('home.Xuất file excel khi bảng tính bảo hiểm xã hội đã được lưu') }}.</small><br>
			</h4>
		</div>
	</div>

</div>

@endsection

