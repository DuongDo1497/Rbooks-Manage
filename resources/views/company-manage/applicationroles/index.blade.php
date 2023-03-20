@extends('layouts.master')

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Danh sách role chức năng</h3>
                <div class="box-tools">
                    <a href="{{ route('applicationroles-add') }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> Tạo mới</a>
                </div>
            </div>
            <div class="box-body" style="font-size:11pt;">
            - Các nhóm chức năng (role) dùng để phân quyền cho người dùng truy cập vào các chức năng được phép của hệ thống.<br> 
            - Trong các nhóm chức năng (role) sẽ bao gồm danh sách các Page (route) truy cập, quản trị hệ thống sẽ phân quyền xem, thêm, sửa, xóa trên các Page (route) truy cập này.<br>
            - <b>Thiết lập quyền truy cập theo menu</b>: chỉ thiết lập quyền trên chức năng hiển thị của menu bên trái.<br>
            - <b>Thiết lập quyền truy cập theo trang chức năng</b>: hiển thị đầy đủ danh sách các trang truy cập để phân quyền.            
            </div>

            <div class="box-body no-padding">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align: center;">STT</th>
                            <th width="8%" style="text-align: center;">Mã role</th>
                            <th width="17%" style="text-align: center;">Tên role</th>
                            <th width="15%" style="text-align: center;">Module truy cập</th>
                            <th width="20%" style="text-align: center;">Thiết lập quyền truy cập <br> theo menu</th>
                            <th width="20%" style="text-align: center;">Thiết lập quyền truy cập <br> theo trang chức năng</th>
                            <th width="20%" style="text-align: center;">Ghi chú</th>
                            <th style="text-align: center;">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if($collections->count() === 0)
                            <tr>
                                <td colspan="8"><b>Không có dữ liệu</b></td>
                            </tr>
                        @endif
                        @php
                            $i = 1
                        @endphp
                        @foreach($collections as $model)
                            <tr>
                                <td style="text-align: center;">{{ $i++ }}</td>
                                <td style="text-align: left;">{{ $model->code }}</td>
                                <td style="text-align: left;">{{ $model->name }}</td>
                                <td style="text-align: left;">{{ $model->modulesallowed }}</td>
                                <td style="text-align: center;"><a href="{{ route('applicationroles-setMenu', ['rolecode'=> $model->code]) }}">Phân theo menu</a></td>
                                <td style="text-align: center;"><a href="{{ route('applicationroles-setResource', ['rolecode'=> $model->code]) }}">Phân theo trang</a></td>
                                <td style="text-align: left;">{{ $model->description }}</td>
                                <td style="text-align: center;">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Thao tác <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="{{ route('applicationroles-edit', ['id'=> $model->id]) }}"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> Chỉnh sửa</a></li>
                                            <li><a href="javascript:void(0)" data-id="{{ $model->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
                                                <form style="margin: 0;" name="form-delete-{{ $model->id }}" method="post" action="{{ route('applicationroles-delete', ['id' => $model->id]) }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete') }}
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<p style="margin-left:3px;font-size:11pt;">
Để cập nhật trang truy cập mới vào các role chức năng, nhấn nút <b>Cập nhật trang truy cập vào role</b> hiện có để thêm mới tự động các trang mới vào role.
<br><b><u>Lưu ý:</u></b> các trang mới phải tồn tại trong danh sách hệ thống các <b> Page (route) truy cập</b> 
</p>
<form role="form" action="{{ route('applicationroles-getApplicationRoles') }}?index=true" method="post" name="frm" id="frm">
{{ csrf_field() }}
<input type='hidden' name='typereport' value=''>
<button class="btn btn-success" style="width: 25%;" onclick="processReports('frm', 'getResource')">Cập nhật trang truy cập vào role</button>
</form>


@endsection

@section('scripts')
@include('company-manage.applicationroles.partials.script')
@endsection
