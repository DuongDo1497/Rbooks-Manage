@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<style>

    .table > thead > tr > th[rowspan]{
        vertical-align: middle;
    }

    .table > thead > tr > th[colspan]{
        text-align: center;
        border-bottom: none;
    }

    .table > thead > tr > th{
        text-align: center;
    }

</style>

@include('financial-manage.cptt_enterprises.partials.search-form')

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    Danh sách chi phí quản lý doanh nghiệp
                    <small>(Hiển thị {{ $filter['limit'] }} dòng / trang) </small>
                </h3>
                <div class="box-tools">
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('cptt_dn-add') }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> Tạo mới</a>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-download" aria-hidden="true"></i> Xuất danh sách
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#"><i class="fas fa-download" aria-hidden="true"></i> Xuất tất cả</a></li>
                                <li><a href="#"><i class="fa fa-file-text" aria-hidden="true"></i> Xuất đã chọn</a></li>
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-filter" aria-hidden="true"></i> Lọc
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#">Sách</a></li>
                                <li><a href="#">Dịch vụ sách</a></li>
                                <li><a href="#">Dịch vụ in ấn</a></li>
                                <li><a href="#">Doanh thu khác</a></li>
                                <li><a href="#">Tất cả</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> Hiển thị
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('cptt_dn-index', filter_data($filter, 'limit', 10)) }}">10 dòng / trang</a></li>
                                <li><a href="{{ route('cptt_dn-index', filter_data($filter, 'limit', 25)) }}">25 dòng / trang</a></li>
                                <li><a href="{{ route('cptt_dn-index', filter_data($filter, 'limit', 50)) }}">50 dòng / trang</a></li>
                                <li><a href="{{ route('cptt_dn-index', filter_data($filter, 'limit', 100)) }}">100 dòng / trang</a></li>
                            </ul>
                        </div>

                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if($filter['sortedBy'] == 'asc' || empty($filter['sortedBy']))
                                    <i class="fa fa-sort-amount-asc" aria-hidden="true"></i> Tăng dần
                                @else
                                    <i class="fa fa-sort-amount-desc" aria-hidden="true"></i> Giảm dần
                                @endif
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('cptt_dn-index', filter_data($filter, 'sortedBy', 'asc')) }}"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> Tăng dần</a></li>
                                <li><a href="{{ route('cptt_dn-index', filter_data($filter, 'sortedBy', 'desc')) }}"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> Giảm dần</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="1%" rowspan="2">
                                <label>
                                    <input type="checkbox" class="minimal checkbox-all">
                                </label>
                            </th>
                            <th width="2.5%" rowspan="2">STT</th>
                            <th rowspan="2" width="15%">Mã phiếu chi</th>
                            <th rowspan="2">Ngày chi</th>
                            <th rowspan="2">Bên nhận</th>
                            <th width="12%" rowspan="2">Nội dung chi</th>
                            <th style="text-align: center;" colspan="2" width="15%">Tổng tiền</th>
                            <th rowspan="2">Hình thức chi</th>
                            <th rowspan="2" width="20%">Ghi chú</th>
                            <th rowspan="2" width="6%">
                                <span class="lbl-action">Chức năng</span>
                                <button class="btn btn-danger btn-xs btn-block hide btn-delete-selected">Xóa <span class="lbl-selected-rows-count">0</span> đã chọn</button>
                            </th>
                        </tr>

                        <tr>
                            <th>Không VAT</th>
                            <th>VAT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($collections->count() === 0)
                            <tr><td colspan="8"><b>Không có dữ liệu!!!</b></td></tr>
                        @endif
                        @php
                            $i = 1
                        @endphp
                        @foreach($collections as $enterprise)
                            <tr>
                                <td>
                                    <label>
                                        <input type="checkbox" class="minimal checkbox-item">
                                    </label>
                                </td>
                                <td style="text-align: center;">{{ $i }}</td>
                                <td style="text-align: center;">{{ $enterprise->code }}</td>
                                <td style="text-align: center;">{{ $enterprise->date_created }}</td>
                                <td style="text-align: center;">{{ $enterprise->supplier_name }}</td>
                                <td style="text-align: center;">{{ $enterprise->content }}</td>
                                <td style="text-align: center;">{{ number_format($enterprise->notvatcost) }}</td>
                                <td style="text-align: center;">{{ number_format($enterprise->vatcost) }}</td>
                                <td style="text-align: center;">{{ $enterprise->methodcost }}</td>
                                <td>{{ $enterprise->note }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Thao tác <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="#"><i class="fa fa-info-circle" style="margin-right: 10px;"></i> Chi tiết</a></li>
                                            <li><a href="#"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> Chỉnh sửa</a></li>
                                            <li><a href="javascript:void(0)" data-id="" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
                                                <form style="margin: 0;" name="form-delete" method="post" action="">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete') }}
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @php
                            $i++
                        @endphp
                        @endforeach
                    </tbody>

                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix text-right">
                
            </div>
        </div>
        <!-- /.box -->
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

        @if(!empty($filter['searchFields']))
        $('#searchFields').val('{{ $filter['searchFields'] }}').trigger('change');
        @endif

        $('#reservation').daterangepicker();
    });
</script>
@endsection
