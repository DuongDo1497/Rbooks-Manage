@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

<style type="text/css">
	.detail-title{
		width: 50%;
		float: left;
		font-size: 15px;
	}

	.detail-content{
		width: 50%;
		float: right;
		font-size: 15px;
	}

	.box-body > .row {
		margin-bottom: 40px;
	}

	.box-body > .row:last-child{
		margin-bottom: 0;
	}

	.progress{
	    background-color: #b3b3b3 !important;
    	border: .5px solid #000;
	}
</style>

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<form role="form" action="#" method="post">
	{{ csrf_field() }}
	{{ method_field('put') }}
	<input type="hidden" name="statusTask" value="{{ $detailTask->status }}">
	<div class="row">
		@include('task-manage.adetailGeneral')
		<div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">Ghi chú</h2>
                </div>
                <div class="box-body">
                	<div class="form-group">
	                    <textarea class="form-control">CEO vào "Thao tác" bấm nút "Duyệt" task đã hoàn thành hoặc hoàn thành 1 phần!.</textarea>
                    </div>
                    <a href="{{ route('design_sach_rbooks-index-1') }}" class="btn btn-default btn-cancel" tabindex="6">Trở về</a>
                </div>
            </div>
		</div>
		@include('task-manage.taskones.design.ataskchildGeneral')
	</div>
</form>

@include('task-manage.taskchild.report')
@include('task-manage.taskchild.add')
@endsection

@section('scripts')
@include('task-manage.script.script')
@endsection