@extends('layouts.master')

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('company-manage.applicationresources.partials.search-form')

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Danh sách trang truy cập</h3>
                <div class="box-tools">
                    <a href="{{ route('applicationresources-add') }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> Tạo mới</a>
                </div>
            </div>

            <div class="box-body no-padding">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align: center;">STT</th>
                            <th width="15%" style="text-align: center;">Mã trang truy cập</th>
                            <th width="25%" style="text-align: center;">Tên hiển thị menu</th>
                            <th width="20%" style="text-align: center;">File name</th>
                            <th width="15%" style="text-align: center;">Prefix</th>
                            <th width="10%" style="text-align: center;">Phân quyền</th>
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
                                <td style="text-align: left;">{{ $model->filename }}</td>
                                <td style="text-align: left;">{{ $model->prefix }}</td>
                                <td style="text-align: center;"><a href="{{ route('securityresources-index', ['applicationresourceid'=>$model->code]) }}">Phân quyền</a></td>
                                <td style="text-align: center;">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Thao tác <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="{{ route('applicationresources-edit', ['id'=> $model->id]) }}"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> Chỉnh sửa</a></li>
                                            <li><a href="javascript:void(0)" data-id="{{ $model->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
                                                <form style="margin: 0;" name="form-delete-{{ $model->id }}" method="post" action="{{ route('applicationresources-delete', ['id' => $model->id]) }}">
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
            <!-- /.box-body -->
            <div class="box-footer clearfix text-right">
                {{ $collections->appends(array('searchprefix'=>$searchprefix,'searchfilename'=>$searchfilename))->links() }}                
            </div>
        </div>
    </div>
</div>

<p style="margin-left:3px;font-size:11pt;">Để cập nhật thêm trang truy cập từ các route mới bổ sung, nhấn nút <b>Cập nhật thêm trang truy cập từ các route mới bổ sung</b> để thêm mới tự động các route mới chưa có trong danh sách trang truy cập.</p>
<form role="form" action="{{ route('applicationresources-getApplicationResources') }}?index=true" method="post" name="frm" id="frm">
{{ csrf_field() }}
<input type='hidden' name='typereport' value=''>
<button class="btn btn-success" style="width: 35%;" onclick="processReports('frm', 'getApplicationResources')">Cập nhật thêm trang truy cập từ các route mới bổ sung</button>&nbsp;&nbsp;
</form>
@endsection

@section('scripts')
@include('company-manage.applicationresources.partials.script')
@endsection
