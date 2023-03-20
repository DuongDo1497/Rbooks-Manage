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
	<div class="row">
		<div class="col-md-8">
        	<div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">Chi tiết dự án</h2>
                </div>
                <div class="box-body">
                	<div class="row">
                		<div class="col-md-4 clearfix">
                			<div class="detail-title"><b>Tên dự án:</b></div>
                			<div class="detail-content">{{ $detailTask->taskname }}</div>
                		</div>
                		<div class="col-md-4 clearfix">
                			<div class="detail-title"><b>Loại dự án:</b></div>
                			<div class="detail-content">{{ $detailTask->tasktype }}</div>
                		</div>
                		<div class="col-md-4 clearfix">
                			<div class="detail-title"><b>Dự án:</b></div>
                			<div class="detail-content">{{ $detailTask->project }}</div>
                		</div>
                	</div>

                	<div class="row">
                		<div class="col-md-4 clearfix">
                			<div class="detail-title"><b>Ngày bắt đầu:</b></div>
                			<div class="detail-content">{{ date("d/m/Y", strtotime($detailTask->fromdate)) }}</div>
                		</div>
                		<div class="col-md-4 clearfix">
                			<div class="detail-title"><b>Ngày kết thúc:</b></div>
                			<div class="detail-content">{{ date("d/m/Y", strtotime($detailTask->todate)) }}</div>
                		</div>
                		<div class="col-md-4 clearfix">
                			<div class="detail-title"><b>Tổng ngày:</b></div>
                			<div class="detail-content">{{ $detailTask->numday }}</div>
                		</div>
                	</div>

                	<div class="row">
                		<div class="col-md-4 clearfix">
                			<div class="detail-title" style="width: 20%;"><b>Ghi chú:</b></div>
                			<div class="detail-content" style="width: 80%;">{{ $detailTask->description }}</div>
                		</div>
                	</div>
                </div>
        	</div>
        </div>
    	<div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">Nội dung</h2>
                </div>
                <div class="box-body">
                	<div class="form-group">
                        <textarea class="form-control">Chi tiết Task việc đã được giao cho Leader.</textarea>
                    </div>
                    <a href="{{ route('license_ones-index') }}" class="btn btn-default btn-cancel" tabindex="6">Trở về</a>
                </div>
            </div>
    	</div>
	</div>
</form>
@endsection