@extends('layouts.master')

@section('content')
@if(isset($infor))
<div class="alert alert-success">
    {{ $infor }} 
</div>
@endif

<form role="form" action="{{ route('monthinsurances-approved') }}" method="post" id="frm">
{{ csrf_field() }}
<input type='hidden' name='typereport' value=''>
<input type='hidden' name='month' value='{{ $month }}'>
<input type='hidden' name='year' value='{{ $year }}'>
<div class="box-header with-border">
    <h3 class="box-title">{{ trans('home.BẢNG TÍNH BẢO HIỂM XÃ HỘI THÁNG') }} {{ $month }}/{{ $year }}
    @if($approved == 0)
        <b class="alert-warning">{{ trans('home.Chưa duyệt') }}</b>
    @else
        <b class="alert-success">{{ trans('home.Đã duyệt') }}</b>
    @endif     
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
                            <th style="text-align: center; vertical-align: middle; background: #eeeeee">{{ trans('home.Mức lương đóng BHXH') }}</th>
                            <th style="text-align: center; background: #eeeeee">{{ trans('home.BHXH do Công ty đóng') }} <br> ({{ $configinsurances->bhxh_ct }}%)</th>
                            <th style="text-align: center; background: #eeeeee">{{ trans('home.BHTNLD_BNN do Công ty đóng') }} <br> ({{ $configinsurances->bhtnld_bnn_ct }}%)</th>
                            <th style="text-align: center; background: #eeeeee">{{ trans('home.BHYT do Công ty đóng') }} <br> ({{ $configinsurances->bhyt_ct }}%)</th>
                            <th style="text-align: center; background: #eeeeee">{{ trans('home.BHTN do Công ty đóng') }} <br> ({{ $configinsurances->bhtn_ct }}%)</th>
                            <th style="text-align: center; background: #eeeeee">{{ trans('home.BHXH do NLĐ đóng') }} <br> ({{ $configinsurances->bhxh_nld }}%)</th>
                            <th style="text-align: center; background: #eeeeee">{{ trans('home.BHTNLD_BNN do NLĐ đóng') }} <br> ({{ $configinsurances->bhtnld_bnn_nld }}%)</th>
                            <th style="text-align: center; background: #eeeeee">{{ trans('home.BHYT do NLĐ đóng') }} <br> ({{ $configinsurances->bhyt_nld }}%)</th>
                            <th style="text-align: center; background: #eeeeee">{{ trans('home.BHTN do NLĐ đóng') }} <br> ({{ $configinsurances->bhtn_nld }}%)</th>
                            <th style="text-align: center; vertical-align: middle; background: #eeeeee">{{ trans('home.Tổng cộng') }} <br> ({{ $configinsurances->bhxh_nld + $configinsurances->bhxh_ct + $configinsurances->bhtnld_bnn_nld + $configinsurances->bhtnld_bnn_ct + $configinsurances->bhyt_nld + $configinsurances->bhyt_ct + $configinsurances->bhtn_nld + $configinsurances->bhtn_ct}}%)</th>
                            <th width="5%" style="text-align: center; vertical-align: middle; background: #eeeeee">{{ trans('home.Chức năng') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach($monthinsurances as $item)
                            <tr>
                                <td style="text-align: center;">{{ $i++ }}</td>
                                <td style="text-align: left;">{{ $item['fullname'] }}</td>
                                <td style="text-align: left;">{{ $item['position_name'] }}</td>
                                <td style="text-align: left;">{{ $item['department_name'] }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['salary_insurance'], 1, 0, 0) }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['bhxh_ct'], 1, 0, 0) }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['bhtnld_bnn_ct'], 1, 0, 0) }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['bhyt_ct'], 1, 0, 0) }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['bhtn_ct'], 1, 0, 0) }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['bhxh_nld'], 1, 0, 0) }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['bhtnld_bnn_nld'], 1, 0, 0) }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['bhyt_nld'], 1, 0, 0) }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['bhtn_nld'], 1, 0, 0) }}</td>
                                <td style="text-align: right;">{{ formatNumber($item['sum_insurance'], 1, 0, 0) }}</td>
                                <td style="text-align: center;">
                                    @if($item['approved'] == "1")
                                        <img src="{{ asset('image/check.gif') }}">   
                                    @else
                                        <div class="btn-group">
                                            <a href="{{ route('monthinsurances-edit', ['id'=> $item['id']]) }}"><i class="fas fa-pencil-alt" style="margin-right: 10px; color: #283b91;"></i></a>
                                        </div>                                             
                                    @endif   
                                </td>

                            </tr>
                        @endforeach

                            <tr>
                                <th style="text-align: left;" colspan="5">{{ trans('home.Tổng cộng') }}:</th>
                                <th style="text-align: right;">{{ formatNumber($summonthinsurances['bhxh_ct'], 1, 0, 0) }}</th>
                                <th style="text-align: right;">{{ formatNumber($summonthinsurances['bhtnld_bnn_ct'], 1, 0, 0) }}</th>
                                <th style="text-align: right;">{{ formatNumber($summonthinsurances['bhyt_ct'], 1, 0, 0) }}</th>
                                <th style="text-align: right;">{{ formatNumber($summonthinsurances['bhtn_ct'], 1, 0, 0) }}</th>
                                <th style="text-align: right;">{{ formatNumber($summonthinsurances['bhxh_nld'], 1, 0, 0) }}</th>
                                <th style="text-align: right;">{{ formatNumber($summonthinsurances['bhtnld_bnn_nld'], 1, 0, 0) }}</th>
                                <th style="text-align: right;">{{ formatNumber($summonthinsurances['bhyt_nld'], 1, 0, 0) }}</th>
                                <th style="text-align: right;">{{ formatNumber($summonthinsurances['bhtn_nld'], 1, 0, 0) }}</th>
                                <th style="text-align: right;">{{ formatNumber($summonthinsurances['sum_insurance'], 1, 0, 0) }}</th>
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
        <button class="btn btn-default" onclick="processReports('frm', 'delete')">{{ trans('home.Xóa bảng tính') }}</button>
    @endif    
</div>
<div class="row">
    <div class="col-md-12">
        <h4>
            <small><small class="text-danger text"><font size=3>(*)</font></small> {{ trans('home.Bảng tính bảo hiểm xã hội chỉ được') }} <b>{{ trans('home.Xóa') }}</b> {{ trans('home.hoặc') }} <b>{{ trans('home.Tạo mới') }}</b> {{ trans('home.lại khi bảng tính bảo hiểm xã hội chưa được duyệt') }}.</small><br>
        </h4>
    </div>
</div>
<div class="box-body"> 
    <a href="{{ route('monthinsurances-index') }}" class="btn btn-default btn-cancel" style="width: 8%;"><i class="fa fa-arrow-left"></i> {{ trans('home.Quay lại') }}</a>  
</div>
</form>

@endsection

