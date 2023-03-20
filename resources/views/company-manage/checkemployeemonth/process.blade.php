@extends('layouts.master')

@section('content')

<form role="form" action="{{ route('checkemployeemonths-store') }}" method="post" id="frm">
{{ csrf_field() }}
<input type=hidden name='month' value='{{ $month }}'>
<input type=hidden name='year' value='{{ $year }}'>
<div class="box-header with-border">
    <h3 class="box-title">{{ trans('home.BẢNG TỔNG HỢP CÔNG THÁNG') }} {{ $month }}/{{ $year }}</h3>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box">

            <div class="box-body no-padding">
                <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="text-align: center; vertical-align: middle;">{{ trans('home.STT') }}</th>
                            <th style="text-align: left; vertical-align: middle;">{{ trans('home.Họ tên') }}</th>
                            <th style="text-align: left; vertical-align: middle;">{{ trans('home.Chức vụ') }}</th>
                            <th style="text-align: left; vertical-align: middle;">{{ trans('home.Phòng ban') }}</th>
                            @foreach($listdaymonth as $key=>$value)
                                <td class="text-nowrap" style="text-align: center;">{{ $value }}<br>{{ $key }}</td>
                            @endforeach

                            @foreach($listchecktype as $item)
                                <td class="text-nowrap" style="text-align: center; background: #cccccc">{{ $item->signno }}</td>
                            @endforeach
                                <td class="text-nowrap" style="text-align: center; font-weight:bold; background: #cccccc">NLV</td>
                                <td class="text-nowrap" style="text-align: center; font-weight:bold; background: #cccccc">NHL</td>
                                <td class="text-nowrap" style="text-align: center; font-weight:bold; background: #cccccc">A/TR</td>
                                <td class="text-nowrap" style="text-align: center; font-weight:bold; background: #cccccc">PCL</td>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach($checkemployeemonths as $item)
                            <tr>
                                <td style="text-align: center;">{{ $i++ }}</td>
                                <td style="text-align: left;">{{ $item['fullname'] }}</td>
                                <td style="text-align: left;">{{ $item['position_name'] }}</td>
                                <td style="text-align: left;">{{ $item['department_name'] }}</td>

                                @foreach($listdaymonth as $key=>$value)
                                    <td class="text-nowrap" style="text-align: center;">{{ $item[$key] }}</td>
                                @endforeach
                                @foreach($listchecktype as $checktype)
                                    <td class="text-nowrap" style="text-align: center; background: #cccccc">{{ $item[$checktype->signno] }}</td>
                                @endforeach
                                <td class="text-nowrap" style="text-align: center; font-weight:bold; background: #cccccc">{{ $item['NLV'] }}</td>
                                <td class="text-nowrap" style="text-align: center; font-weight:bold; background: #cccccc">{{ $item['NHL'] }}</td>
                                <td class="text-nowrap" style="text-align: center; font-weight:bold; background: #cccccc">{{ $item['A/TR'] }}</td>
                                <td class="text-nowrap" style="text-align: center; font-weight:bold; background: #cccccc">{{ $item['PCL'] }}</td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="box-footer text-left">
    <button type="submit" class="btn btn-success" style="width: 15%;">{{ trans('home.Lưu bảng tổng hợp chấm công') }}</button>
</div>
<div class="box-body">
    <a href="{{ route('checkemployeemonths-index') }}" class="btn btn-default btn-cancel" style="width: 8%;"><i class="fa fa-arrow-left"></i> {{ trans('home.Quay lại') }}</a>   
</div>
</form>

@endsection

