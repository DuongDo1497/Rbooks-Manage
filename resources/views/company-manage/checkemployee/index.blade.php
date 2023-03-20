@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('company-manage.checkemployee.partials.search-form')

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    {{ trans('home.Danh sách phê duyệt nghỉ phép') }}
                </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="text-align: center;" width="1%">{{ trans('home.STT') }}</th>
                            <th style="text-align: left;" class="text-nowrap" width="14%">{{ trans('home.Họ tên') }}</th>
                            <th style="text-align: center;" class="text-nowrap" width="8%">{{ trans('home.Phép còn lại') }}</th>
                            <th style="text-align: center;" class="text-nowrap" width="8%">{{ trans('home.Loại phép') }}</th>
                            <th style="text-align: center;" class="text-nowrap" width="34%">{{ trans('home.Thông tin chi tiết') }}</th>
                            <th style="text-align: center;" class="text-nowrap" width="15%">{{ trans('home.Người duyệt') }}</th>
                            <th style="text-align: center;" class="text-nowrap">
                                <span class="lbl-action">{{ trans('home.Chức năng') }}</span>
                                <button class="btn btn-danger btn-xs btn-block hide btn-delete-selected">{{ trans('home.Xóa') }} <span class="lbl-selected-rows-count">0</span> {{ trans('home.đã chọn') }}</button>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                    	@if($collections->count() === 0)
                            <tr>
                                <td colspan="8"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                            </tr>
                        @endif
                        @php
                        $i = 1
                        @endphp
                        @foreach($collections as $checkemployee)
	                        <tr>
                            	<td style="text-align: center;">{{ $i }}</td>
	                        	<td>{{ $checkemployee->employee->fullname }}</td>
	                        	<td style="text-align: center;">{{ formatNumber($checkemployee->permission_left, 1, 2, 1) }}</td>
	                        	<td>{{ $checkemployee->checktype->description }}</td>
	                        	<td>
	                        		<div class="day-off">
	                        			<div class="day-off"><b>{{ trans('home.Từ ngày') }}: </b><span>{{ $checkemployee->fromdate == null ? "" : date("d/m/Y", strtotime($checkemployee->fromdate)) }} {{ $checkemployee->fromtime == "" ? "" : $fromtimetype[$checkemployee->fromtime] }}</span><span> - </span><b>{{ trans('home.Tới ngày') }}: </b><span>{{ $checkemployee->todate == null ? "" : date("d/m/Y", strtotime($checkemployee->todate)) }} {{ $checkemployee->totime == "" ? "" : $totimetype[$checkemployee->totime] }}</span></div>
	                        			<div class="count-day"><b>{{ trans('home.Tổng số ngày nghỉ') }}: </b><span>{{ $checkemployee->numday }}</span></div>
	                        			<div class="reason"><b>{{ trans('home.Lý do nghỉ') }}: </b><span>{{ $checkemployee->description }}</span></div>
	                        		</div>
                                    @if($checkemployee->status == 0)
                                        <b class="alert-warning">{{ $approvetype[$checkemployee->status] }}</b>
                                    @elseif($checkemployee->status == 1)
                                        <b class="alert-success">{{ $approvetype[$checkemployee->status] }}</b>
                                    @else
                                        <b class="alert-danger">{{ $approvetype[$checkemployee->status] }}</b>
                                    @endif

                                </td>
	                        	<td>
                        		    <p>{{ $checkemployee->approved_user_name }}<br>
                                    Ngày duyệt: <span>{{ $checkemployee->approved_at == null ? "" : date("d/m/Y", strtotime($checkemployee->approved_at))  }}</span></p>
	                        	</td>
	                        	<td>
                                    @if( Auth()->user()->name == 'admin' || Auth()->user()->employee()->first()->position_id == 8 || Auth()->user()->employee()->first()->position_id == 9)
                                    <div class="btn-group">
                                        <form id="form1" action="{{ route('checkemployees-accept', ['id' => $checkemployee->id]) }}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('put') }}
                                            <button type="submit" class="btn btn-success btn-save" tabindex="9" style="width: 84px; margin-bottom: 1px;"><i class="fa fa-check-circle-o"></i> {{ trans('home.Đồng ý') }}</button>
                                        </form>
                                    </div>
                                    <div class="btn-group">
                                        <form id="form2" action="{{ route('checkemployees-cancel', ['id' => $checkemployee->id]) }}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('put') }}
                                            <button type="submit" class="btn btn-danger btn-save" tabindex="9" style="width: 84px; margin-bottom: 1px;"><i class="fa fa-times-circle-o"></i> {{ trans('home.Từ chối') }}</button>
                                        </form>
                                    </div>
                                    @else
	                        		<div class="btn-group">
	                                    <button type="button" class="btn btn-default dropdown-toggle btn-checkemployees" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                                        {{ trans('home.Thao tác') }} <span class="caret"></span>
	                                    </button>
	                                    <ul class="dropdown-menu dropdown-menu-right">
	                                        <li><a href="{{ route('checkemployees-edit', ['employeeid' => $checkemployee->employee_id_encrypt, 'id'=> $checkemployee->id]) }}"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> {{ trans('home.Chỉnh sửa') }}</a></li>
                                            <li><a href="{{ route('checkemployees-delete', ['employeeid' => $checkemployee->employee_id_encrypt, 'id'=> $checkemployee->id]) }}"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> {{ trans('home.Xóa') }}</a></li>
	                                    </ul>
	                                </div>
                                    @endif
	                        	</td>
	                        </tr>
                        @php
                        $i++
                        @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix text-right">
                {{ $collections->links() }}
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>

@endsection
