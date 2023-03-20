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
		@if($detailTask->status < 17)
		<div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">Chức năng</h2>
                </div>
                <div class="box-body">
                	<div class="form-group">
	                    <select class="form-control select2 select-status" name="status">
                            <option value="17">Báo cáo công việc CEO</option>
                        </select>
                    </div>
                </div>
                <div class="box-body">
                    <button type="submit" class="btn btn-primary btn-save" tabindex="5">Lưu</button>
                    <a href="{{ route('operate_sach_rb-index-1') }}" class="btn btn-default btn-cancel" tabindex="6">Trở về</a>
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
	                    <textarea class="form-control">Leader có thể vào "Thao tác" và bấm nút "Báo cáo" để báo cáo công việc đã hoàn thành!</textarea>
                    </div>
                    <a href="{{ route('operate_sach_rb-index-1') }}" class="btn btn-default btn-cancel" tabindex="6">Trở về</a>
                </div>
            </div>
		</div>
		@endif
		@include('task-manage.taskones.operate.ataskchildGeneral')
	</div>
</form>

@include('task-manage.taskchild.report')
@include('task-manage.taskchild.add')
@endsection

@section('scripts')
@include('task-manage.script.script')
@endsection