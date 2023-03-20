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
		
		@include('task-manage.adetailGeneral'))
		@if($detailTask->status < 8)
		<div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">Chức năng</h2>
                </div>
                <div class="box-body">
                	<div class="form-group">
	                    <select class="form-control select2 select-status" name="status">
                            <option value="8">Leader phân công</option>
                        </select>
                    </div>
                </div>
                <div class="box-body">
                    @if($detailTask->status < 8)
                    <button type="submit" class="btn btn-primary btn-save" tabindex="5">Lưu</button>
                    @else
                    <button type="submit" class="btn btn-primary btn-save" tabindex="5" disabled="">Lưu</button>
                    @endif
                    <a href="{{ route('it_others-index') }}" class="btn btn-default btn-cancel" tabindex="6">Trở về</a>
                </div>
            </div>
		</div>
		@else
		<div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">Ghi chú</h2>
                </div>
                <div class="box-body">
                	<div class="form-group">
	                    <textarea class="form-control">Leader bấm nút "Tạo task" để tạo task cho Nhân viên!.</textarea>
                    </div>
                    <div class="form-group">
	                    <a href="{{ route('it_others-index') }}" class="btn btn-default btn-cancel" tabindex="6">Trở về</a>
                    </div>
                </div>
            </div>
		</div>
		@endif
		@include('task-manage.taskones.it.ataskchildGeneral')
	</div>
</form>

@include('task-manage.taskchild.report')
@include('task-manage.taskchild.add')
@endsection

@section('scripts')
@include('task-manage.script.script')
@endsection