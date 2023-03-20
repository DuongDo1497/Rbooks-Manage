@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

<style type="text/css">
	.detail-title{
		width: 50%;
		float: left;
	}

	.detail-content{
		width: 50%;
		float: right;
	}

	.box-body > .row {
		margin-bottom: 40px;
	}

	.box-body > .row:last-child{
		margin-bottom: 0;
	}

	.table > thead > tr > th[rowspan]{
        vertical-align: middle;
    }

    .table > thead > tr > th[colspan]{
        text-align: center;
        border-bottom: none;
    }

    .table > thead > tr > th{
        text-align: center;
    }

    .document-text{
        width: 100%;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .download_file{
    	color: #000;
    }

    .download_file:hover{
    	color: #283b91;
    }
</style>

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h2 class="box-title">{{ trans('home.Thông tin chung') }}</h2>
            </div>
            <div class="box-body" style="font-size: 16px;">
            	<div class="row">
            		<div class="col-md-4 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Ngày chi') }}:</b></div>
            			<div class="detail-content">{{ date("d/m/Y", strtotime($detail->date_create)) }}</div>
            		</div>
            		<div class="col-md-4 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Loại chi') }}:</b></div>
            			<div class="detail-content">{{ $detail->type_cost == 1 ? "Chi phí thực tế" : "Công nợ phải trả" }}</div>
            		</div>
            		<div class="col-md-4 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Mục chi') }}:</b></div>
            			<div class="detail-content">{{ $detail->mclist()->first()->name }}</div>
            		</div>
            	</div>

            	<div class="row">
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Ngày bắt đầu') }}:</b></div>
            			<div class="detail-content">{{ date("d/m/Y", strtotime($detail->startday_cost)) }}</div>
            		</div>
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Ngày kết thúc') }}:</b></div>
            			<div class="detail-content">{{ date("d/m/Y", strtotime($detail->endday_cost)) }}</div>
            		</div>
            	</div>

            	<div class="row">
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Hình thức chi') }}:</b></div>
            			<div class="detail-content">{{ $detail->method_cost == 1 ? "Tiền mặt" : "Chuyển khoản" }}</div>
            		</div>
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Trạng thái') }}:</b></div>
                        @if($detail->status == 1)
                        <div class="detail-content" data-name="type-cost">{{ trans('home.Đã chi') }}</div>
                        @elseif($detail->status == 2)
                        <div class="detail-content" data-name="type-cost">{{ trans('home.Chưa chi') }}</div>
                        @else
            			<div class="detail-content" data-name="type-cost">{{ trans('home.Nợ trả từng phần') }}</div>
                        @endif
            		</div>
            	</div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h2 class="box-title">{{ trans('home.Thông tin nhà cung cấp/Người bán') }}</h2>
            </div>
            <div class="box-body" style="font-size: 16px;">
            	<div class="row">
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Mã nhà cung cấp/Người bán') }}:</b></div>
            			<div class="detail-content">{{ $detail->supplier_code }}</div>
            		</div>
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Tên nhà cung cấp/Người bán') }}:</b></div>
            			<div class="detail-content">{{ $detail->supplier_name }}</div>
            		</div>
            	</div>

            	<div class="row">
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Số điện thoại') }}:</b></div>
            			<div class="detail-content">{{ $detail->supplier_phone }}</div>
            		</div>
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Địa chỉ') }}:</b></div>
            			<div class="detail-content">{{ $detail->supplier_address }}</div>
            		</div>
            	</div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h2 class="box-title">{{ trans('home.Thông tin khác') }}</h2>
            </div>
            <div class="box-body" style="font-size: 16px;">
            	<div class="row">
            		<div class="col-md-4 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Số lượng hàng') }}:</b></div>
            			<div class="detail-content">{{ $detail->quantity }}</div>
            		</div>
            		<div class="col-md-4 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Đơn vị tính') }}:</b></div>
            			<div class="detail-content">{{ $detail->unit }}</div>
            		</div>
            		<div class="col-md-4 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Thuế VAT') }}:</b></div>
            			<div class="detail-content" data-vat="number_vat">{{ $detail->vat }}</div>
            		</div>
            	</div>

            	<div class="row">
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Tổng tiền phải trả (không VAT)') }}:</b></div>
            			<div class="detail-content">{{ number_format($detail->novat_cost) }} VND</div>
            		</div>
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Tổng tiền phải trả (có VAT)') }}:</b></div>
            			<div class="detail-content">{{ number_format($detail->vat_cost) }} VND</div>
            		</div>
            	</div>

            	<div class="row">
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Tổng tiền đã trả (không VAT)') }}:</b></div>
            			<div class="detail-content">{{ number_format($detail->paided_cost_novat) }} VND</div>
            		</div>
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Tổng tiền đã trả (có VAT)') }}:</b></div>
            			<div class="detail-content">{{ number_format($detail->paided_cost_vat) }} VND</div>
            		</div>
            	</div>

            	<div class="row">
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Tổng tiền dư nợ (không VAT)') }}:</b></div>
            			<div class="detail-content">{{ number_format($detail->remaining_cost_novat) }} VND</div>
            		</div>
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Tổng tiền dư nợ (có VAT)') }}:</b></div>
            			<div class="detail-content">{{ number_format($detail->remaining_cost_vat) }} VND</div>
            		</div>
            	</div>

            	<div class="row">
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Người quản lý') }}:</b></div>
            			<div class="detail-content">{{ $detail->employee()->first() == NULL ? "-" : $detail->employee()->first()->fullname }}</div>
            		</div>
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Người phụ trách') }}:</b></div>
            			<div class="detail-content">{{ $detail->personinEmployee == NULL ? "-" : $detail->personinEmployee->fullname }}</div>
            		</div>
            	</div>

            	<div class="row">
            		<div class="col-md-12 clearfix">
            			<div class="detail-title" style="width: 30%"><b>{{ trans('home.Hồ sơ chi') }}:</b></div>
            			<div class="detail-content" style="width: 70%">{{ $detail->file_cost }}</div>
            		</div>
            	</div>

            	<div class="row">
            		<div class="col-md-12 clearfix">
            			<div class="detail-title" style="width: 30%"><b>{{ trans('home.Nội dung chi') }}:</b></div>
            			<div class="detail-content" style="width: 70%">{{ $detail->content }}</div>
            		</div>
            	</div>

            	<div class="row">
            		<div class="col-md-12 clearfix">
            			<div class="detail-title" style="width: 30%"><b>{{ trans('home.Ghi chú') }}:</b></div>
            			<div class="detail-content" style="width: 70%">{{ $detail->note }}</div>
            		</div>
            	</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
    	<div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('home.Chức năng') }}</h3>
            </div>
            <div class="box-body">
                <a href="{{ route('cpt_gvt-index') }}" class="btn btn-default btn-cancel" tabindex="10" style="width: 100%;">{{ trans('home.Trở về') }}</a>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('home.Mã chứng từ') }}</h3>
            </div>
            <div class="box-body">
                <div class="row" style="margin-bottom: 0;">
                    <div class="col-md-7" style="padding-top: 6px; padding-bottom: 6px;">
                        <div class="document-text">
                            <b style="font-size: 15px;">RB.633.XHW.KHOVH.08.10.2019</b>
                        </div>
                    </div>
                    <div class="col-md-5"><a href="#" class="btn btn-primary btn-search" style="width: 100%;">{{ trans('home.Xem') }}</a></div>
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('home.Tên file đính kèm/Tên hồ sơ đính kèm') }}</h3>
            </div>
            <div class="box-body">
            	<a href="#" class="download_file">
	                <div class="row">
	            		<div class="col-md-10">Chứng từ thuế 11-09-2019.png</div>
	            		<div class="col-md-2" style="text-align: right;">
	            			<i class="fa fa-download" aria-hidden="true"></i>
	            		</div>
	            	</div>
	            </a>
            </div>
        </div>
    </div>

    <div class="col-md-12" id="detail-payment">
    	<div class="box box-primary">
            <div class="box-header with-border">
                <h2 class="box-title">{{ trans('home.Chi tiết đã trả từng phần') }}</h2>
                <div class="box-tools">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#getFormAdd"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</button>
                    </div>
                </div>
            </div>
            <div class="box-body">
            	<div class="box-body no-padding">
	                <table class="table table-hover">
	                    <thead>
	                        <tr>
	                            <th width="2.5%" rowspan="2">{{ trans('home.STT') }}</th>
	                            <th rowspan="2">{{ trans('home.Ngày chi') }}</th>
	                            <th rowspan="2">{{ trans('home.Nội dung chi') }}</th>
	                            <th style="text-align: center;" colspan="2" width="30%">{{ trans('home.Tổng tiền (đã trả)') }}</th>
	                            <th rowspan="2">{{ trans('home.Ghi chú') }}</th>
	                            <th rowspan="2" width="6%">
	                                <span class="lbl-action">{{ trans('home.Chức năng') }}</span>
	                                <button class="btn btn-danger btn-xs btn-block hide btn-delete-selected">{{ trans('home.Xóa') }} <span class="lbl-selected-rows-count">0</span> {{ trans('home.đã chọn') }}</button>
	                            </th>
	                        </tr>

	                        <tr>
	                            <th width="15%">{{ trans('home.Không VAT') }}</th>
	                            <th width="15%">{{ trans('home.VAT') }}</th>
	                        </tr>
	                    </thead>
	                    <tbody>
                            @if($detail->cptpaymentslips->count() === 0)
                                <tr>
                                    <td colspan="7"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                                </tr>
                            @endif
                            @php
                                $i = 1
                            @endphp
                            @foreach($detail->cptpaymentslips as $cptpaymentslip)
                                <tr>
                                    <td style="text-align: center;">{{ $i }}</td>
                                    <td style="text-align: center;">{{ date("d/m/Y", strtotime($cptpaymentslip->date_cost)) }}</td>
                                    <td style="text-align: center;">{{ $cptpaymentslip->content }}</td>
                                    <td style="text-align: center;">{{ number_format($cptpaymentslip->paided_cost_novat) }}</td>
                                    <td style="text-align: center;">{{ number_format($cptpaymentslip->paided_cost_vat) }}</td>
                                    <td style="text-align: center;">{{ $cptpaymentslip->note }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{ trans('home.Thao tác') }} <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li><a class="editPaySlip" data-toggle="modal" href="#getEdit" data-route="{{ route('cpt_gvt_payslip-update', ['id' => $cptpaymentslip->id, 'idcostprice' => $detail->id]) }}?index=true" data-id="{{ $cptpaymentslip->id }}"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> {{ trans('home.Chỉnh sửa') }}</a></li>
                                                <li><a href="javascript:void(0)" data-id="{{ $cptpaymentslip->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> {{ trans('home.Xóa') }}</a>
                                                    <form style="margin: 0;" name="form-delete-{{ $cptpaymentslip->id }}" method="post" action="{{ route('cpt_gvt_payslip-delete', ['id' => $cptpaymentslip->id, 'idcostprice' => $detail->id]) }}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('delete') }}
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @php
                                $i++
                            @endphp
                            @endforeach
	                    </tbody>
	                </table>
	            </div>
            </div>
        </div>
    </div>
</div>

@include('financial-manage.cpt_costprices.storePaySlip')
@include('financial-manage.cpt_costprices.editPaySlip')

@endsection

@section('scripts')
@include('financial-manage.cpt_costprices.partials.script')

<script>
    $(function() {
        $('.btn-delete').click(function(){
            var id = $(this).data('id');
            swal({
                title: "{{ trans('home.Bạn có chắc không?') }}",
                text: "{{ trans('home.Nội dung xóa sẽ được đưa vào thùng rác') }}",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((value) => {
                console.log(value);
                if(value) {
                    document.forms['form-delete-'+id].submit();
                }
            });
        });

        $(document).ready(() => {
            // get router from answers button when clicked
            $(".editPaySlip").click((e) => {
                var route = $(e.target).data("route");
                var id = $(e.target).data("id");
                //var idcostprice = $("input[name='idcostprice']").val();
                // add router to form action
                $.get('{{ route('cpt_gvt_payslip-edit') }}', { id: id }, function(data){
                    console.log(data);
                    $("#getFormEdit").attr("action", route);
                    $(".date_cost").attr("value", data.date_cost);
                    $(".paided_cost_novat").attr("value", data.paided_cost_novat);
                    $(".paided_cost_vat").attr("value", data.paided_cost_vat);
                    $(".content").val(data.content);
                    $(".note").val(data.note);
                })
            });
        });
    });
</script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#cpt_gvt-form').submit();
        });
    });
</script>
@endsection
