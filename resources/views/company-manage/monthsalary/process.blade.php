@extends('layouts.master')

@section('content')

@include('company-manage.monthsalary.partials.search-form')

<form role="form" action="{{ route('monthsalarys-store') }}" method="post" id="frm">
{{ csrf_field() }}
<input type=hidden name='month' value='{{ $month }}'>
<input type=hidden name='year' value='{{ $year }}'>
<div class="box-header with-border">
    <h3 class="box-title">{{ trans('home.BẢNG TÍNH LƯƠNG THÁNG') }} {{ $month }}/{{ $year }}</h3>
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
                        </tr>
                        <tr>
                        @for ($i = 1; $i <= 15; $i++)
                            <td style="text-align: center;">({{ $i }})</td>
                        @endfor                        
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
    <a href='{{ route('monthsalarys-index') }}'><img src='{{ asset('image/ed_undo.gif') }}' border='0' height='24' width='24' align='middle' hspace='2'><font size='2'> {{ trans('home.Quay lại') }}</font></a>    
</div>
</form>

@endsection

