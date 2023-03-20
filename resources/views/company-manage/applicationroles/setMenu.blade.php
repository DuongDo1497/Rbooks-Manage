@extends('layouts.master')

@section('content')

@if(isset($infor))
<div class="alert alert-success">
    {{ $infor }}
</div>
@endif

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<form role="form" action="{{ route('applicationroles-updateMenu') }}?continue=true" method="post" id="frm">
{{ csrf_field() }}

<input type='hidden' name='typereport' value=''>
<input type='hidden' name='roleid' value='{{$roleid}}'>
<input type='hidden' name='checkall' value='0'>
<input type='hidden' name='checkvalue' value='0'>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Phân quyền role: {{ $roleid }} -> Danh sách các menu chức năng</h3>
            </div>

            <div class="box-body no-padding">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align: center;">STT</th>
                            <th width="20%" style="text-align: center;">Menu truy cập</th>
                            <th width="4%" style="text-align: center;">&nbsp;</th>
                            <th width="17%" style="text-align: center;">File name</th>
                            <th width="8%" style="text-align: center;">Hiển thị</th>
                            <th width="8%" style="text-align: center;">Thêm mới</th>
                            <th width="8%" style="text-align: center;">Chỉnh sửa</th>
                            <th width="8%" style="text-align: center;">Xóa</th>
                            <th width="8%" style="text-align: center;">Duyệt</th>
                        </tr>
                        <tr>
                            <th style="text-align: center;"></th>
                            <th style="text-align: center;"></th>
                            <th style="text-align: center;"></th>
                            <th style="text-align: center;"></th>
                            <th style="text-align: center; font-size: 10pt;"><a href='javascript:checkView("v_1")'>Chọn</a> | <a href='javascript:checkView("v_0")'>Bỏ chọn</a></th>
                            <th style="text-align: center; font-size: 10pt;"><a href='javascript:checkView("a_1")'>Chọn</a> | <a href='javascript:checkView("a_0")'>Bỏ chọn</a></th>
                            <th style="text-align: center; font-size: 10pt;"><a href='javascript:checkView("u_1")'>Chọn</a> | <a href='javascript:checkView("u_0")'>Bỏ chọn</a></th>
                            <th style="text-align: center; font-size: 10pt;"><a href='javascript:checkView("d_1")'>Chọn</a> | <a href='javascript:checkView("d_0")'>Bỏ chọn</a></th>
                            <th style="text-align: center; font-size: 10pt;"><a href='javascript:checkView("r_1")'>Chọn</a> | <a href='javascript:checkView("r_0")'>Bỏ chọn</a></th>
                        </tr>
                    </thead>

                    <tbody>
                        @if(count($collections) === 0)
                            <tr>
                                <td colspan="8"><b>Không có dữ liệu</b></td>
                            </tr>
                        @endif
                        @php
                            $i = 1;
                        @endphp

                        @if(isset($collections) and count($collections) != 0)
                            @foreach($collections as $module)
                                <tr>
                                    <td style="text-align: center;">{{ $i++ }}</td>
                                    <td style="text-align: left; font-weight: bold;">{{ $module['name'] }}</td>
                                    <td style="text-align: center;"></td>
                                </tr>
                
                                @foreach($module['applicationfunctiongroups'] as $functiongroups)
                                        @if(isset($functiongroups['filename']) and $functiongroups['filename'] != '')
                                            @php
                                                $id = $functiongroups['securityresourcesid'];
                                                $cview_id  = "cview_$id";
                                                $cadd_id  = "cadd_$id";
                                                $cupdate_id  = "cupdate_$id";
                                                $cdelete_id  = "cdelete_$id";
                                                $capprove_id  = "capprove_$id";
                    
                                                if ($checkall == "v"){
                                                    $functiongroups['cview'] = $checkvalue;           
                                                }
                                                if ($checkall == "a"){
                                                    $functiongroups['cadd'] = $checkvalue;           
                                                }
                                                if ($checkall == "u"){
                                                    $functiongroups['cupdate'] = $checkvalue;           
                                                }
                                                if ($checkall == "d"){
                                                    $functiongroups['cdelete'] = $checkvalue;           
                                                }
                                                if ($checkall == "r"){
                                                    $functiongroups['capprove'] = $checkvalue;           
                                                }                            
                                            @endphp 

                                            <tr>
                                                <td style="text-align: center;">{{ $i++ }}</td>
                                                <td style="text-align: left;"><i class="{{ $functiongroups['image'] }}"></i>&nbsp;&nbsp;&nbsp;{{ $functiongroups['name'] }}</td>
                                                <td style="text-align: center;"></td>
                                                <td style="text-align: left;">{{ $functiongroups['filename'] }}</td>
                                                <td style="text-align: center;"><input type=checkbox name='{{$cview_id}}' value='1' {{ $functiongroups['cview']=='1'?'checked':'' }}></td>
                                                <td style="text-align: center;"><input type=checkbox name='{{$cadd_id}}' value='1' {{ $functiongroups['cadd']=='1'?'checked':'' }}></td>
                                                <td style="text-align: center;"><input type=checkbox name='{{$cupdate_id}}' value='1' {{ $functiongroups['cupdate']=='1'?'checked':'' }}></td>
                                                <td style="text-align: center;"><input type=checkbox name='{{$cdelete_id}}' value='1' {{ $functiongroups['cdelete']=='1'?'checked':'' }}></td>
                                                <td style="text-align: center;"><input type=checkbox name='{{$capprove_id}}' value='1' {{ $functiongroups['capprove']=='1'?'checked':'' }}></td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td style="text-align: center;">{{ $i++ }}</td>
                                                <td style="text-align: left;">
                                                <i class="{{ $functiongroups['image'] }}"></i>&nbsp;&nbsp;&nbsp;{{ $functiongroups['name'] }}
                                                @if(isset($functiongroups['functionassignment']) and count($functiongroups['functionassignment']) != 0)
                                                    <i class="fa fa-angle-down pull-right"></i>
                                                @endif
                                                </td>
                                                <td style="text-align: center;"></td>
                                                <td style="text-align: left;">{{ $functiongroups['filename'] }}</td>
                                            </tr>
                                        @endif
                                                
                                        @foreach($functiongroups['functionassignment'] as $functionassignment)
                                            @php
                                                $id = $functionassignment['securityresourcesid'];
                                                $cview_id  = "cview_$id";
                                                $cadd_id  = "cadd_$id";
                                                $cupdate_id  = "cupdate_$id";
                                                $cdelete_id  = "cdelete_$id";
                                                $capprove_id  = "capprove_$id";
                    
                                                if ($checkall == "v"){
                                                    $functionassignment['cview'] = $checkvalue;           
                                                }
                                                if ($checkall == "a"){
                                                    $functionassignment['cadd'] = $checkvalue;           
                                                }
                                                if ($checkall == "u"){
                                                    $functionassignment['cupdate'] = $checkvalue;           
                                                }
                                                if ($checkall == "d"){
                                                    $functionassignment['cdelete'] = $checkvalue;           
                                                }
                                                if ($checkall == "r"){
                                                    $functionassignment['capprove'] = $checkvalue;           
                                                }                            
                                            @endphp 
                                            <tr>
                                                <td style="text-align: center;">{{ $i++ }}</td>
                                                <td style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="{{ $functionassignment['image'] }}"></i>&nbsp;&nbsp;&nbsp;{{ $functionassignment['name'] }}</td>
                                                <td style="text-align: center;"></td>
                                                <td style="text-align: left;">{{ $functionassignment['filename'] }}</td>
                                                <td style="text-align: center;"><input type=checkbox name='{{$cview_id}}' value='1' {{ $functionassignment['cview']=='1'?'checked':'' }}></td>
                                                <td style="text-align: center;"><input type=checkbox name='{{$cadd_id}}' value='1' {{ $functionassignment['cadd']=='1'?'checked':'' }}></td>
                                                <td style="text-align: center;"><input type=checkbox name='{{$cupdate_id}}' value='1' {{ $functionassignment['cupdate']=='1'?'checked':'' }}></td>
                                                <td style="text-align: center;"><input type=checkbox name='{{$cdelete_id}}' value='1' {{ $functionassignment['cdelete']=='1'?'checked':'' }}></td>
                                                <td style="text-align: center;"><input type=checkbox name='{{$capprove_id}}' value='1' {{ $functionassignment['capprove']=='1'?'checked':'' }}></td>
                                            </tr>
                                        @endforeach
                                @endforeach
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<p style="margin-left:3px;font-size:11pt;">
- Để cập nhật lại phân quyền trang truy cập, nhấn nút <b>Cập nhật lại toàn bộ danh sách trang truy cập mới</b> để lấy lại danh sách phân quyền mặc định.
<br>- Nhấn nút <b>Lưu</b> để lưu lại phân quyền đã thiết lập.
</p>
<button class="btn btn-success" style="width: 35%;" onclick="processReports('frm', 'getResource')">Cập nhật lại toàn bộ danh sách trang truy cập mới</button>&nbsp;&nbsp;
<button class="btn btn-success" style="width: 15%;" onclick="processReports('frm', 'update')">Lưu</button>
<br><br>
<a href="{{ route('applicationroles-index') }}" style="width: 16%;"><i class="fa fa-arrow-left"></i> Quay lại</a>   
</form>
@endsection

@section('scripts')
@include('company-manage.applicationroles.partials.script')
@endsection
