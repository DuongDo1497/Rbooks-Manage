@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Bảng bảo hiểm xã hội</h3>
                <div class="box-tools">
                    <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#getFormAdd"><i class="fa fa-plus" aria-hidden="true"></i> Tạo mới</button>
                </div>
            </div>

            <div class="box-body">
                @include('user-employees.partials.aboutEmployees')
            </div>

            <div class="box-footer">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">STT</th>
                            <th width="10%">Mã NV</th>
                            <th>Mức lương đóng BHXH</th>
                            <th>Ngày hiệu lực</th>
                            <th width="20%">Ghi chú</th>
                            <th>Kích hoạt</th>
                            <th width="8%">Chức năng</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td style="text-align: center;">01</td>
                            <td style="text-align: center;">19070012</td>
                            <td style="text-align: center;">4472000</td>
                            <td style="text-align: center;">01/10/2019</td>
                            <td></td>
                            <td style="text-align: center;"><b class="alert alert-success">Đã kích hoạt</b></td>
                            <td style="text-align: right;">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Thao tác <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="#"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> Chỉnh sửa</a></li>
                                        <li><a href="javascript:void(0)" data-id="" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
                                            <form name="form-delete" method="post" action="" style="margin: 0;">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function() {
        $('.btn-delete').click(function(){
            var id = $(this).data('id');
            swal({
                title: "Bạn có chắc không?",
                text: "Nội dung xóa sẽ được đưa vào thùng rác",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((value) => {
                console.log(value);
                if(value) {
                    document.forms['form-delete-'+id].submit();
                }
            });
        });
    });
</script>
@endsection
