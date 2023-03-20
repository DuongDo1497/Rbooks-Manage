@extends('layouts.master')


@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@section('content')

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<i class="fa fa-plane"></i>
				<h3 class="box-title">{{ trans('home.THEO DÕI ĐI CÔNG TÁC') }}</h3>
			</div>
			<div class="box-body">
				<div class="status">
					<div class="registration">
		                <a href="#" data-toggle="modal" data-target="#getFormAddBusiness" class="btn btn-primary btn-registration">{{ trans('home.Đăng ký công tác') }}</a>
		            </div>
				</div>
			</div>
			<div class="box-footer" style="max-height: 610px; overflow-y: auto;">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>{{ trans('home.Ngày/Lý do') }}</th>
							<th width="45%">{{ trans('home.Thông tin chi tiết') }}</th>
							<th width="15%">{{ trans('home.Công việc cụ thể') }}</th>
							<th>{{ trans('home.Người duyệt') }} ({{ trans('home.Chờ') }})</th>
						</tr>
					</thead>
					<tbody>
                    @foreach($checkbusiness as $item)
                        <tr>
                            <td style="text-align: center;">
                                {{ $item['checktype_name'] }}<br>
                                {{ $item['fromdate'] == null ? "" : date("d/m/Y", strtotime($item['fromdate'])) }}
                            </td>
                            <td style="text-align: left;">
                                {{ trans('home.Từ ngày') }}: <span>{{ $item['fromdate'] == null ? "" : date("d/m/Y", strtotime($item['fromdate'])) }} {{ $item['fromtime'] == "" ? "" : $fromtimetype[$item['fromtime']] }}</span> - {{ trans('home.Tới ngày') }}: <span>{{ $item['todate'] == null ? "" : date("d/m/Y", strtotime($item['todate'])) }} {{ $item['totime'] == "" ? "" : $totimetype[$item['totime']] }}</span><br>

                                {{ trans('home.Số ngày đi công tác') }}: {{ $item['numday'] }}<br>

                                {{ trans('home.Nơi đến') }}: {{ $item['place'] }}<br>

                                {{ trans('home.Phương tiện') }}: {{ $transportationtype[$item['transportation']] }}<br>
                                @if($item['status'] == 0)
                                    <div class="btn-group">
                                        <a href="{{ route('checkbusiness-edit', ['employeeid' => $employeeid, 'id'=> $item['id']]) }}"><i class="fa fa-edit" aria-hidden="true"></i> {{ trans('home.Chỉnh sửa') }}</a> - 
                                        <a href="{{ route('checkbusiness-delete', ['employeeid' => $employeeid, 'id'=> $item['id']]) }}"><i class="fa fa-trash" aria-hidden="true"></i> {{ trans('home.Xóa') }}</a>
                                    </div>  
                                @elseif($item['status'] == 1)
                                    <b class="alert-success">{{ $approvetype[$item['status']] }}</b>
                                @elseif($item['status'] == 2)
                                    <b class="alert-warning">{{ $approvetype[$item['status']] }}</b>
                                @endif
                            </td>
                            <td style="text-align: left;">{{ $item['description'] }}</td>
                            <td style="text-align: center;"><font size='2' color='#4181d0'><b>{{ $item['approved_user_name'] }}</b></font></td>
                        </tr>
                    @endforeach                    
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div>
    <a href="{{  route('employees-detail', ['id' => $employeeid]) }}" class="btn btn-default btn-cancel" style="width: 8%;"><i class="fa fa-arrow-left"></i> {{ trans('home.Quay lại') }}</a>   
</div>
@include('company-manage.checkbusiness.add')
@endsection
