@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@section('content')
@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <i class="fa fa-plane"></i>
                <h3 class="box-title">{{ trans('home.THEO DÕI NGHỈ') }}</h3>
            </div>
            <div class="box-body">
                <div class="title-status">
                    <h5>{{ trans('home.Trạng thái phép') }}:</h5>
                </div>

                <div class="status">
                    <div class="status-1 clearfix">
                        <div class="status-item">
                            <span>{{ trans('home.Phép năm') }}:</span>
                            <span>{{ formatNumber($employee->permission_curryear, 1, 2, 1) }}</span>
                        </div>
                        <div class="status-item">
                            <span>{{ trans('home.Phép tồn năm trước') }}:</span>
                            <span>{{ formatNumber($employee->permission_lastyear, 1, 2, 1) }}</span>
                        </div>
                    </div>
                    <div class="status-2 clearfix">
                        <div class="status-item">
                            <span>{{ trans('home.Phép đã nghỉ') }}:</span>
                            <span>{{ formatNumber($employee->permission_leave, 1, 2, 1) }}</span>
                        </div>
                        <div class="status-item">
                            <span>{{ trans('home.Phép còn lại') }}:</span>
                            <span>{{ formatNumber($employee->permission_left, 1, 2, 1) }}</span>
                        </div>
                    </div>
                    
                    <div class="registration">
                        <a href="#" data-toggle="modal" data-target="#getFormAddEmployee" class="btn btn-primary btn-registration checkemployeeInYear">{{ trans('home.Đăng ký nghỉ phép') }}</a>
                    </div>
                </div>
            </div>
            <div class="box-footer" style="max-height: 610px; overflow-y: auto;">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="text-align: center;">{{ trans('home.Ngày/Lý do') }}</th>
                            <th style="text-align: center;" width="60%">{{ trans('home.Thông tin chi tiết') }}</th>
                            <th style="text-align: center;">{{ trans('home.Người duyệt') }} ({{ trans('home.Chờ') }})</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($checkemployee as $item)
                            <tr>
                                <td style="text-align: center;">
                                    {{ $item['checktype_name'] }}<br>
                                    {{ $item['fromdate'] == null ? "" : date("d/m/Y", strtotime($item['fromdate'])) }}
                                </td>
                                <td style="text-align: left;">
                                    {{ trans('home.Từ ngày') }}: <span>{{ $item['fromdate'] == null ? "" : date("d/m/Y", strtotime($item['fromdate'])) }} {{ $item['fromtime'] == "" ? "" : $fromtimetype[$item['fromtime']] }}</span> - {{ trans('home.Tới ngày') }}: <span>{{ $item['todate'] == null ? "" : date("d/m/Y", strtotime($item['todate'])) }} {{ $item['totime'] == "" ? "" : $totimetype[$item['totime']] }}</span><br>

                                    {{ trans('home.Số ngày nghỉ') }}: {{ $item['numday'] }}<br>

                                    {{ trans('home.Lý do nghỉ') }}: {{ $item['description'] }}<br>
                                    @if($item['status'] == 0)
                                        <div class="btn-group">
                                            <a href="{{ route('checkemployees-edit', ['employeeid' => $employeeid, 'id'=> $item['id']]) }}" style="color: #283b91;"><i class="fa fa-edit" aria-hidden="true"></i> {{ trans('home.Chỉnh sửa') }}</a> - 
                                            <a href="{{ route('checkemployees-delete', ['employeeid' => $employeeid, 'id'=> $item['id']]) }}" style="color: #283b91;"><i class="fa fa-trash" aria-hidden="true"></i> {{ trans('home.Xóa') }}</a>
                                        </div>  
                                    @elseif($item['status'] == 1)
                                        <b class="alert-success">{{ $approvetype[$item['status']] }}</b>
                                    @elseif($item['status'] == 2)
                                        <b class="alert-warning">{{ $approvetype[$item['status']] }}</b>
                                    @endif
                                </td>
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
@include('company-manage.checkemployee.add')
@endsection

@section('scripts')
@include('company-manage.employee.partials.script')
@endsection
