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

<form role="form" action="{{ route('task_ones-approve', ['id' => $detailTask->id]) }}" method="post">
	{{ csrf_field() }}
	{{ method_field('put') }}
	<input type="hidden" name="statusTask" value="{{ $detailTask->status }}">
	<div class="row">
		
		@include('task-manage.adetailGeneral')
		@if(Auth()->user()->roles()->first()->name == "Leader" || Auth()->user()->roles()->first()->name == "owner")
		<div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">Ghi chú</h2>
                </div>
                <div class="box-body">
                	<div class="form-group">
	                    <textarea class="form-control">Công việc đã được giao cho Nhân viên!.</textarea>
                    </div>
                    <div class="form-group">
	                    <a href="{{ route('design_others-index') }}" class="btn btn-default btn-cancel" tabindex="6">Trở về</a>
                    </div>
                </div>
            </div>
		</div>
		@else
		<div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">Nội dung</h2>
                </div>
                <div class="box-body">
                	<div class="form-group">
	                    <textarea class="form-control">Công việc đã được giao. Đề nghị Nhân Viên vào "Thao tác" bấm "Xác nhận" hoặc "Từ chối" công việc của mình!.</textarea>
                    </div>
                    <div class="form-group">
	                    <a href="{{ route('design_others-index') }}" class="btn btn-default btn-cancel" tabindex="6">Trở về</a>
                    </div>
                </div>
            </div>
		</div>
		@endif
		@include('task-manage.taskones.design.ataskchildGeneral')
	</div>
</form>

@include('task-manage.taskchild.report')
@include('task-manage.taskchild.add')
@endsection

@section('scripts')
@include('task-manage.script.script')
@endsection