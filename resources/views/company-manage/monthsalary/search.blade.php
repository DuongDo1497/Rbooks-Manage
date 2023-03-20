@extends('layouts.master')

@section('content')
@if(isset($infor))
<div class="alert-success">
    {{ $infor }} 
</div>
@endif

<form role="form" action="{{ route('monthsalarys-approved') }}" method="post" id="frm">
{{ csrf_field() }}
<input type='hidden' name='typereport' value=''>
<input type='hidden' name='month' value='{{ $month }}'>
<input type='hidden' name='year' value='{{ $year }}'>
<div class="box-header with-border">
    <h3 class="box-title">{{ trans('home.BẢNG TÍNH LƯƠNG THÁNG') }} {{ $month }}/{{ $year }}
    @if($approved == 0)
        <b class="alert-warning">{{ trans('home.Chưa duyệt') }}</b>
    @else
        <b class="alert-success">{{ trans('home.Đã duyệt') }}</b>
    @endif     
    </h3>    
    </h3>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body no-padding">
                <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>

                        <tr>
                            <th style="text-align: center; vertical-align: middle; background: #eeeeee">{{ trans('home.STT') }}</th>
                            <th style="text-align: left; vertical-align: middle; background: #eeeeee">{{ trans('home.Họ tên') }}</th>
                            <th style="text-align: left; vertical-align: middle; background: #eeeeee">{{ trans('home.Chức vụ') }}</th>
                            <th style="text-align: left; vertical-align: middle; background: #eeeeee">{{ trans('home.Phòng ban') }}</th>
                            <th style="text-align: center; background: #eeeeee">{{ trans('home.Tiền lương theo công việc') }}</th>
                            <th style="text-align: center; background: #eeeeee">{{ trans('home.Số ngày tính lương trong tháng') }}</th>
                            <th style="text-align: center; background: #eeeeee">{{ trans('home.Số ngày làm việc thực tế') }}</th>
                            <th style="text-align: center; background: #eeeeee">{{ trans('home.Lương tháng') }} <br> (8)=(5)*(6)/(7)</th>
                            <th style="text-align: center; background: #eeeeee">{{ trans('home.BHXH do NLĐ đóng') }}</th>
                            <th style="text-align: center; background: #eeeeee">{{ trans('home.BHTNLD_BNN do NLĐ đóng') }}</th>
                            <th style="text-align: center; background: #eeeeee">{{ trans('home.BHYT do NLĐ đóng') }}</th>
                            <th style="text-align: center; background: #eeeeee">{{ trans('home.BHTN do NLĐ đóng') }}</th>
                            <th style="text-align: center; background: #eeeeee">{{ trans('home.Lương thực lĩnh') }} <br> (13)=(8)-(9)-(10)-(11)-(12)</th>
                            <th style="text-align: center; background: #eeeeee">{{ trans('home.Các loại phụ cấp') }}</th>
                            <th style="text-align: center; background: #eeeeee">{{ trans('home.Lương được lĩnh chưa trích thuế TNCN') }} <br> (15)=(13)+(14)</th>
                            <th style="text-align: center; vertical-align: middle; background: #eeeeee">{{ trans('home.Chức năng') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach($monthsalarys as $item)
                            <tr>
                                <td style="text-align: center;">{{ $i++ }}</td>
                                <td style="text-align: left;">{{ $item['fullname'] }}</td>
                                <td style="text-align: left;">{{ $item['position_name'] }}</td>
                                <td style="text-align: left;">{{ $item['department_name'] }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['worksalary'], 1, 0, 0) }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['numworkday_salary'], 1, 1, 0) }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['numworkday'], 1, 1, 0) }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['sum_salary'], 1, 0, 0) }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['bhxh'], 1, 0, 0) }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['bhtnld_bnn'], 1, 0, 0) }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['bhyt'], 1, 0, 0) }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['bhtn'], 1, 0, 0) }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['luongthuclinh'], 1, 0, 0) }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['phucap'], 1, 0, 0) }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['thucnhankynay'], 1, 0, 0) }}</td>

                                <td style="text-align: center;">
                                    @if($item['approved'] == "1")
                                        <img src="{{ asset('image/check.gif') }}">   
                                    @else
                                        <div class="btn-group">
                                            <a href="{{ route('monthsalarys-edit', ['id'=> $item['id']]) }}"><i class="fas fa-pencil-alt" style="margin-right: 10px; color: #283b91;"></i></a>
                                        </div>                                             
                                    @endif   
                                </td>

                            </tr>
                        @endforeach

                            <tr>
                                <th style="text-align: left;" colspan="7">{{ trans('home.Tổng cộng') }}:</th>
                                <th style="text-align: right;">{{ formatNumber($summonthsalarys['sum_salary'], 1, 0, 0) }}</th>
                                <th style="text-align: right;">{{ formatNumber($summonthsalarys['bhxh'], 1, 0, 0) }}</th>
                                <th style="text-align: right;">{{ formatNumber($summonthsalarys['bhtnld_bnn'], 1, 0, 0) }}</th>
                                <th style="text-align: right;">{{ formatNumber($summonthsalarys['bhyt'], 1, 0, 0) }}</th>
                                <th style="text-align: right;">{{ formatNumber($summonthsalarys['bhtn'], 1, 0, 0) }}</th>
                                <th style="text-align: right;">{{ formatNumber($summonthsalarys['luongthuclinh'], 1, 0, 0) }}</th>
                                <th style="text-align: right;">{{ formatNumber($summonthsalarys['phucap'], 1, 0, 0) }}</th>
                                <th style="text-align: right;">{{ formatNumber($summonthsalarys['thucnhankynay'], 1, 0, 0) }}</th>
                                <th style="text-align: right;">&nbsp;</th>
                            </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="box-footer text-left">
    <button class="btn btn-success" onclick="processReports('frm', 'approved')">{{ trans('home.Đồng ý duyệt') }}</button>
    <button class="btn btn-danger" onclick="processReports('frm', 'cancelapproved')">{{ trans('home.Bỏ duyệt') }}</button>
    @if($approved == 0)
        <button class="btn btn-default" onclick="processReports('frm', 'delete')">{{ trans('home.Xóa bảng lương') }}</button>
    @endif    
</div>
<div class="row">
    <div class="col-md-12">
        <h4>
        <small><small class="text-danger text"><font size=3>(*)</font></small> {{ trans('home.Bảng tính lương chỉ được') }} <b>{{ trans('home.Xóa') }}</b> {{ trans('home.hoặc') }} <b>{{ trans('home.Tạo mới') }}</b> {{ trans('home.lại khi bảng tính lương chưa được duyệt') }}.</small><br>
        </h4>
    </div>
</div>
<div class="box-body">
    <a href="{{ route('monthsalarys-index') }}" class="btn btn-default btn-cancel" style="width: 8%;"><i class="fa fa-arrow-left"></i> {{ trans('home.Quay lại') }}</a>  
</div>
</form>

@endsection

