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

	.box-body > .row:last-thuld{
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
            			<div class="detail-title"><b>{{ trans('home.Ngày thu') }}:</b></div>
            			<div class="detail-content">{{ date("d/m/Y", strtotime($detail->date_create == NULL ? "-" : $detail->date_create)) }}</div>
            		</div>
            		<div class="col-md-4 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Loại thu') }}:</b></div>
            			<div class="detail-content">{{ $detail->type_revenue == 1 ? "Doanh thu thực tế" : "Công nợ phải thu" }}</div>
            		</div>
            		<div class="col-md-4 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Nguồn thu') }}:</b></div>
            			<div class="detail-content">{{ $detail->mclist()->first()->name }}</div>
            		</div>
            	</div>

            	<div class="row">
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Ngày bắt đầu') }}:</b></div>
            			<div class="detail-content">{{ date("d/m/Y", strtotime($detail->start_date)) }}</div>
            		</div>
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Ngày kết thúc') }}:</b></div>
            			<div class="detail-content">{{ date("d/m/Y", strtotime($detail->end_date)) }}</div>
            		</div>
            	</div>

            	<div class="row">
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Hình thức thu') }}:</b></div>
            			<div class="detail-content">{{ $detail->method_revenue }}</div>
            		</div>
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Trạng thái') }}:</b></div>
                        <div class="detail-content" data-name="status">
                            @if($detail->status == 1)
                                {{ trans('home.Đã thu') }}
                            @elseif($detail->status == 2)
                                {{ trans('home.Chưa thu') }}
                            @else
                                {{ trans('home.Nợ thu từng phần') }}
                            @endif
                        </div>
            		</div>
            	</div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h2 class="box-title">{{ trans('home.Thông tin thanh toán') }}</h2>
            </div>
            <div class="box-body" style="font-size: 16px;">
            	<div class="row">
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Mã khách hàng/nhà cung cấp') }}:</b></div>
            			<div class="detail-content">{{ $detail->code_customer }}</div>
            		</div>
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Tên khách hàng/nhà cung cấp') }}:</b></div>
            			<div class="detail-content">{{ $detail->name_customer }}</div>
            		</div>
            	</div>

            	<div class="row">
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Số điện thoại') }}:</b></div>
            			<div class="detail-content">{{ $detail->phone }}</div>
            		</div>
            		<div class="col-md-6 clearfix">
            			<div class="detail-title" style="width: 20%;"><b>{{ trans('home.Địa chỉ') }}:</b></div>
            			<div class="detail-content" style="width: 80%;">{{ $detail->address }}</div>
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
            			<div class="detail-title"><b>{{ trans('home.Tổng tiền phải thu (không VAT)') }}:</b></div>
            			<div class="detail-content">{{ number_format($detail->notvat_revenue) }}</div>
            		</div>
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Tổng tiền phải thu (có VAT)') }}:</b></div>
            			<div class="detail-content">{{ number_format($detail->vat_revenue) }}</div>
            		</div>
            	</div>

            	<div class="row">
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Tổng tiền đã thu (không VAT)') }}:</b></div>
            			<div class="detail-content">{{ number_format($detail->dathu_notvat) }}</div>
            		</div>
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Tổng tiền đã thu (có VAT)') }}:</b></div>
            			<div class="detail-content">{{ number_format($detail->dathu_vat) }}</div>
            		</div>
            	</div>

            	<div class="row">
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Tổng tiền dư nợ (không VAT)') }}:</b></div>
            			<div class="detail-content">{{ number_format($detail->conlai_notvat) }}</div>
            		</div>
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Tổng tiền dư nợ (có VAT)') }}:</b></div>
            			<div class="detail-content">{{ number_format($detail->conlai_vat) }}</div>
            		</div>
            	</div>

            	<div class="row">
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Người quản lý') }}:</b></div>
            			<div class="detail-content">{{ $detail->creatorEmployee()->first() == NULL ? "" : $detail->creatorEmployee()->first()->fullname }}</div>
            		</div>
            		<div class="col-md-6 clearfix">
            			<div class="detail-title"><b>{{ trans('home.Người phụ trách') }}:</b></div>
            			<div class="detail-content">{{ $detail->personinEmployee()->first() == NULL ? "" : $detail->personinEmployee()->first()->fullname }}</div>
            		</div>
            	</div>

            	<div class="row">
            		<div class="col-md-12 clearfix">
            			<div class="detail-title" style="width: 30%"><b>{{ trans('home.Hồ sơ thu') }}:</b></div>
            			<div class="detail-content" style="width: 70%">{{ $detail->file_revenue }}</div>
            		</div>
            	</div>

            	<div class="row">
            		<div class="col-md-12 clearfix">
            			<div class="detail-title" style="width: 30%"><b>{{ trans('home.Nội dung thu') }}:</b></div>
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
    	<div class="box box-primary box-control">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('home.Chức năng') }}</h3>
            </div>
            <div class="box-body">
                <div class="btn-group">
                    <a href="{{ route('gross_revenues-index') }}" class="btn btn-default btn-cancel" tabindex="8">
                        <img src="{{ asset('img/icon-cancel.png') }}" alt="">
                        <span><b>Thoát</b></span>
                    </a>
                </div>
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

    <div class="col-md-12">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#detailPayment">Chi tiết thu từng phần</a></li>
            <li><a data-toggle="tab" href="#clearingDebt">Cấn trừ công nợ</a></li>
        </ul>

        <div class="tab-content">

            <!-- Bảng chi tiết thu từng phần -->
            <div id="detailPayment" class="tab-pane fade in active">
                <div id="detail-payment">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h2 class="box-title">{{ trans('home.Chi tiết đã thu từng phần') }}</h2>
                            <div class="box-tools">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#getFormAdd"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="box-body no-padding">
                                <div class="row">
                                    <h4 class="text-center col-xs-4">{{ trans('home.Tổng tiền') }} : {{ number_format($detail->dathu_vat) }} VND</h4>
                                    <h4 class="text-center col-xs-4">
                                        {{ trans('home.Tổng số lượng') }} : {{ $detail->status == 1 ? $detail->sl_daban : number_format($detail->grossReceipts->sum('quantity')) }}
                                    </h4>
                                    <h4 class="text-center col-xs-4">
                                        {{ trans('home.Số lượng chưa bán') }} : {{ $detail->status == 1 ? $detail->sl_chuaban : number_format($detail->quantity - $detail->grossReceipts->sum('quantity')) }}
                                    </h4>
                                </div>

                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="2.5%" rowspan="2">{{ trans('home.STT') }}</th>
                                            <th rowspan="2">{{ trans('home.Ngày thu') }}</th>
                                            <th rowspan="2">{{ trans('home.Nội dung thu') }}</th>
                                            <th style="text-align: center;" colspan="2" width="30%">{{ trans('home.Tổng tiền (đã thu)') }}</th>
                                            <th rowspan="2">Số lượng</th>
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
                                        @if($detail->grossReceipts->count() === 0)
                                        <tr>
                                            <td colspan="7"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                                        </tr>
                                        @endif
                                        @php
                                            $i = 1
                                        @endphp
                                        @foreach($detail->grossReceipts as $grossReceipt)
                                            <tr>
                                                <td style="text-align: center;">{{ $i }}</td>
                                                <td style="text-align: center;">{{ date("d/m/Y", strtotime($grossReceipt->date_revenue)) }}</td>
                                                <td style="text-align: center;">{{ $grossReceipt->content }}</td>
                                                <td style="text-align: center;">{{ number_format($grossReceipt->dathu_notvat) }}</td>
                                                <td style="text-align: center;">{{ number_format($grossReceipt->dathu_vat) }}</td>
                                                <td style="text-align: center;">{{ $grossReceipt->quantity }}</td>
                                                <td style="text-align: center;">{{ $grossReceipt->note }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            {{ trans('home.Thao tác') }} <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-right">
                                                            <li><a href="{{ route('edit-receipt', ['id' => $grossReceipt->id]) }}"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> {{ trans('home.Chỉnh sửa') }}</a></li>
                                                            <li><a href="javascript:void(0)" data-id="receipt-{{ $grossReceipt->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> {{ trans('home.Xóa') }}</a>
                                                                <form style="margin: 0;" name="form-delete-receipt-{{ $grossReceipt->id }}" method="post" action="{{ route('receipts-delete', ['id'=> $grossReceipt->id]) }}">
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
            <!-- Bảng chi tiết thu từng phần -->

            <!-- Cấn trừ công nợ -->
            <div id="clearingDebt" class="tab-pane fade">
                <div id="clearing-debt">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h2 class="box-title">Cấn trừ công nợ</h2>
                            <div class="box-tools">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#getClearingDebt"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="box-body no-padding">
                                <div class="row">
                                    <h4 class="text-center col-md-6">Tổng tiền cần trừ: {{number_format($detail->clearingDebt->sum('clearing_vat'))}} VND</h4>
                                    <h4 class="text-center col-md-6">
                                        Số lượng trả lại: {{$detail->clearingDebt->sum('sl_tralai')}}
                                    </h4>
                                </div>

                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="2.5%" rowspan="2">{{ trans('home.STT') }}</th>
                                            <th rowspan="2">Ngày cập nhật</th>
                                            <th rowspan="2">Lý do</th>
                                            <th style="text-align: center;" colspan="2" width="30%">Tổng tiền cấn trừ</th>
                                            <th rowspan="2">Số lượng trả lại</th>
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
                                        @if($detail->clearingDebt->count() === 0)
                                        <tr>
                                            <td colspan="7"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                                        </tr>
                                        @endif
                                        @php
                                            $i = 1
                                        @endphp
                                        @foreach($detail->clearingDebt as $item)
                                            <tr>
                                                <td style="text-align: center;">{{ $i }}</td>
                                                <td style="text-align: center;">{{ date("d/m/Y", strtotime($item->updated_at)) }}</td>
                                                <td style="text-align: center;">{{ $item->reason }}</td>
                                                <td style="text-align: center;">{{ number_format($item->clearing_novat) }}</td>
                                                <td style="text-align: center;">{{ number_format($item->clearing_vat) }}</td>
                                                <td style="text-align: center;">{{ $item->sl_tralai }}</td>
                                                <td style="text-align: center;">{{ $item->note }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            {{ trans('home.Thao tác') }} <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-right">
                                                            <li>
                                                                <a href="{{ route('clearing_debt-edit', $item->id) }}"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> {{ trans('home.Chỉnh sửa') }}</a>
                                                            </li>
                                                            <li><a href="javascript:void(0)" data-id="clearing-{{$item->id}}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> {{ trans('home.Xóa') }}</a>
                                                                <form style="margin: 0;" name="form-delete-clearing-{{$item->id}}" method="post" action="{{ route('clearing_debt-delete', $item->id) }}">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('delete') }}
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Cấn trừ công nợ -->

        </div>
    </div>
</div>

@include('financial-manage.gross_revenue.createpaymentslip')
@include('financial-manage.gross_revenue.createClearingDebt')

@endsection

@section('scripts')
@include('financial-manage.gross_revenue.partials.script')

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
    });
</script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#gross_revenues-form').submit();
        });
    });
</script>
@endsection
