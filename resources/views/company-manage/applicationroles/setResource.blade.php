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

<form role="form" action="{{ route('applicationroles-updateResource') }}?continue=true" method="post" id="frm">
{{ csrf_field() }}

<input type='hidden' name='typereport' value=''>
<input type='hidden' name='roleid' value='{{$roleid}}'>
<input type='hidden' name='checkall' value=''>
<input type='hidden' name='checkvalue' value=''>

@include('company-manage.applicationroles.partials.search-form')

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Phân quyền</h3>
            </div>

            <div class="box-body no-padding">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align: center;">STT</th>
                            <th width="8%" style="text-align: center;">Mã trang</th>
                            <th width="18%" style="text-align: center;">Tên menu hiển thị</th>
                            <th width="15%" style="text-align: center;">File name</th>
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
                        @if($collections->count() === 0)
                            <tr>
                                <td style="text-align: left; font-size: 11pt; color: #ff0000" colspan="8">Không có dữ liệu. Vui lòng nhấn nút cập nhật danh sách trang truy cập mới để khởi tạo danh sách trang phân quyền.</td>
                            </tr>
                        @endif
                        @php
                            $i = 1;
                        @endphp
                        @foreach($collections as $model)
                        @php
                            $id = $model->id;
                            $cview_id  = "cview_$id";
                            $cadd_id  = "cadd_$id";
                            $cupdate_id  = "cupdate_$id";
                            $cdelete_id  = "cdelete_$id";
                            $capprove_id  = "capprove_$id";

                            if ($checkall == "v"){
                                $model->cview = $checkvalue;           
                            }
                            if ($checkall == "a"){
                                $model->cadd = $checkvalue;           
                            }
                            if ($checkall == "u"){
                                $model->cupdate = $checkvalue;           
                            }
                            if ($checkall == "d"){
                                $model->cdelete = $checkvalue;           
                            }
                            if ($checkall == "r"){
                                $model->capprove = $checkvalue;           
                            }                            
                        @endphp                                
                            <tr>
                                <td style="text-align: center;">{{ $i++ }}</td>
                                <td style="text-align: center;">{{ $model->resourcecode }}</td>
                                <td style="text-align: left;">{{ $model->applicationresources()->first()->name }}</td>
                                <td style="text-align: left;" class="text-nowrap">{{ $model->filename }}</td>
                                <td style="text-align: center;"><input type=checkbox name='{{$cview_id}}' value='1' {{ $model->cview=='1'?'checked':'' }}></td>
                                <td style="text-align: center;"><input type=checkbox name='{{$cadd_id}}' value='1' {{ $model->cadd=='1'?'checked':'' }}></td>
                                <td style="text-align: center;"><input type=checkbox name='{{$cupdate_id}}' value='1' {{ $model->cupdate=='1'?'checked':'' }}></td>
                                <td style="text-align: center;"><input type=checkbox name='{{$cdelete_id}}' value='1' {{ $model->cdelete=='1'?'checked':'' }}></td>
                                <td style="text-align: center;"><input type=checkbox name='{{$capprove_id}}' value='1' {{ $model->capprove=='1'?'checked':'' }}></td>
                            </tr>
                        @endforeach
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
<button class="btn btn-success" style="width: 15%;" onclick="processReports('frm', 'update')">Lưu</button>&nbsp;&nbsp;
<button class="btn btn-success" style="width: 35%;" onclick="processReports('frm', 'getResource')">Cập nhật lại toàn bộ danh sách trang truy cập mới</button>&nbsp;&nbsp;
<br><br>
<a href="{{ route('applicationroles-index') }}" style="width: 16%;"><i class="fa fa-arrow-left"></i> Quay lại</a>   

</form>
@endsection

@section('scripts')
@include('company-manage.applicationroles.partials.script')
@endsection
