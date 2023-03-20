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

<form role="form" action="{{ route('design-product-assign-division', ['id' => $detailTask->id]) }}?continue=true" method="post">
	{{ csrf_field() }}
	{{ method_field('put') }}
	<input type="hidden" name="statusTask" value="{{ $detailTask->status }}">
	<div class="row">
		
		@include('task-manage.adetailGeneral')
		<div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">Chức năng</h2>
                </div>
                <div class="box-body">
                    <div class="row" style="margin-bottom: 0;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-control select2 select-status" name="status">
                                    <option value="25">CEO phân công BP khác</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-control select2" name="assign">
                                    <option value="content_product1">Content 1</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Ghi chú</label>
                        <textarea class="form-control" placeholder="Nhập ghi chú" rows="3" name="note"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bắt đầu</label>
                                <input type="date" class="form-control" name="fromdate" value="{{ $detailTask->fromdate}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kết thúc</label>
                                <input type="date" class="form-control" name="todate" value="{{ $detailTask->todate}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <button type="submit" class="btn btn-primary btn-save" tabindex="5">Lưu</button>
                    <a href="{{ route('design-product-index') }}" class="btn btn-default btn-cancel" tabindex="6">Trở về</a>
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