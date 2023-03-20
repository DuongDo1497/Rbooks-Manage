@extends('layouts.master')

@section('content')
@if(isset($infor))
<div class="alert alert-success">
    {{ $infor }} 
</div>
@endif

<form role="form" action="{{ route('checkemployeemonths-approved') }}" method="post" id="frm">
{{ csrf_field() }}
<input type='hidden' name='typereport' value=''>
<input type='hidden' name='month' value='{{ $month }}'>
<input type='hidden' name='year' value='{{ $year }}'>
<div class="box-header with-border">
    <h3 class="box-title">
    BẢNG TỔNG HỢP CÔNG THÁNG {{ $month }}/{{ $year }}
    @if($approved == 0)
        <b class="alert-warning">Chưa duyệt</b>
    @else
        <b class="alert-success">Đã duyệt</b>
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
                            <th style="text-align: center; vertical-align: middle;">STT</th>
                            <th style="text-align: left; vertical-align: middle;">Họ tên</th>
                            <th style="text-align: left; vertical-align: middle;">Chức vụ</th>
                            <th style="text-align: left; vertical-align: middle;">Phòng ban</th>
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
    <button class="btn btn-primary btn-approved" onclick="processReports('frm', 'approved')">Đồng ý duyệt</button>
    <button class="btn btn-primary btn-cancelapproved" onclick="processReports('frm', 'cancelapproved')">Bỏ duyệt</button>

    @if($approved == 0)
        <button class="btn btn-primary btn-delete" onclick="processReports('frm', 'delete')">Xóa bảng chấm công</button>
    @endif    

</div>
<div class="container">
<h4>
<small><small class="text-danger text"><font size=3>(*)</font></small> Bảng tổng hợp chấm công chỉ được <b>Xóa</b> hoặc <b>Tạo mới</b> lại khi bảng tổng hợp chấm công <b>chưa được duyệt</b>.</small><br>
</h4>
</div>
<div class="box-body">
    <a href='{{ route('checkemployeemonths-index') }}'><img src='{{ asset('image/ed_undo.gif') }}' border='0' height='24' width='24' align='middle' hspace='2'><font size='2'> Quay lại</font></a>    
</div>
</form>

@endsection

