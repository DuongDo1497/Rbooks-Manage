@extends('layouts.master')

@section('content')

@include('company-manage.monthinsurance.partials.search-form')

<form role="form" action="{{ route('monthinsurances-store') }}" method="post" id="frm">
{{ csrf_field() }}
<input type=hidden name='month' value='{{ $month }}'>
<input type=hidden name='year' value='{{ $year }}'>
<div class="box-header with-border">
    <h3 class="box-title">{{ trans('home.BẢNG TÍNH BẢO HIỂM XÃ HỘI THÁNG') }} {{ $month }}/{{ $year }}</h3>
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
                            </tr>
                    </tbody>

                </table>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="box-footer text-left">
    <button type="submit" class="btn btn-primary">{{ trans('home.Lưu bảng kê') }}</button>
</div>
<div class="box-body">
    <a href='{{ route('monthinsurances-index') }}'><img src='{{ asset('image/ed_undo.gif') }}' border='0' height='24' width='24' align='middle' hspace='2'><font size='2'> {{ trans('home.Quay lại') }}</font></a>    
</div>
</form>

@endsection

