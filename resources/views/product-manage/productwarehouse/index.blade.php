@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<div class="box box-default">
    @include('product-manage.productwarehouse.partials.search-form')
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Danh sách sản phẩm phiếu: <b>#{{ $warehouse_id }}</b> <small>(Hiển thị {{-- $collections->count() --}} dòng / trang)</small></h3>
                <div class="box-tools">
                    <div class="btn-group btn-group-sm">
                        <div class="btn-group" role="group">
                            <a class="btn btn-success" href="{{ route('productwarehouses-importwarehouse', ['id' => $warehouse_id]) }}"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> Nhập kho</a>
                        </div>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#getFile"><i class="fa fa-upload" aria-hidden="true"></i> Nhập dữ liệu</button>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-download" aria-hidden="true"></i> Xuất danh sách
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('productwarehouses-export') }}"><i class="fa fa-file-text-o" aria-hidden="true"></i> Xuất tất cả</a></li>
                                <li><a href="#"><i class="fa fa-file-text" aria-hidden="true"></i> Xuất danh mục đã chọn</a></li>
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
                                <li><a href="{{ route('productwarehouses-index', filter_data($filter, 'limit', 10)) }}">10 dòng / trang</a></li>
                                <li><a href="{{ route('productwarehouses-index', filter_data($filter, 'limit', 25)) }}">25 dòng / trang</a></li>
                                <li><a href="{{ route('productwarehouses-index', filter_data($filter, 'limit', 50)) }}">50 dòng / trang</a></li>
                                <li><a href="{{ route('productwarehouses-index', filter_data($filter, 'limit', 100)) }}">100 dòng / trang</a></li>
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
                            <th width="1%">
                                <label>
                                    <input type="checkbox" class="minimal checkbox-all">
                                </label>
                            </th>
                            <th class="text-center" width="5%">#</th>
                            <th class="text-nowrap">Thông tin sách</th>
                            <th class="text-nowrap">Số lượng</th>
                            <th class="text-nowrap">Giá</th>
                            <th class="text-nowrap">Chiết khấu</th>
                            <th>
                                <span class="lbl-action">Chức năng</span>
                                <button class="btn btn-danger btn-xs btn-block hide btn-delete-selected">Xóa <span class="lbl-selected-rows-count">0</span> sản phẩm</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($collections as $productwarehouse)
                            <tr>
                                <td>
                                    <label>
                                        <input type="checkbox" class="minimal checkbox-item">
                                    </label>
                                </td>
                                <td class="text-center">{{ $productwarehouse->id }}</td>
                                <td>
                                    <ul>
                                        <li>Tên sách: <b>{{ $productwarehouse->product->name }}</b></li>
                                        <li>Giá: </li>
                                    </ul>
                                </td>
                                <td><div id="quantity">{{ $productwarehouse->quantity }}</div></td>
                                <td>{{ number_format($productwarehouse->price) }}  VNĐ</td>
                                <td>{{ $productwarehouse->discount }} %</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Thao tác <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="{{ route('productwarehouses-edit', ['id' => $productwarehouse->id, 'warehouse_id' => $warehouse_id ]) }}" class="list-group-item"><i class="fa fa-pencil" aria-hidden="true"></i> Chỉnh sửa</a></li>
                                            <li>
                                                <a href="javascript:void(0)" data-id="{{ $productwarehouse->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
                                                <form name="form-delete-{{ $productwarehouse->id }}" method="post" action="{{ route('productwarehouses-delete', ['id' => $productwarehouse->id, 'warehouse_id' => $warehouse_id ]) }}">
                                                    {{ csrf_field() }}
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th width="1%">
                                <label>
                                    <input type="checkbox" class="minimal checkbox-all">
                                </label>
                            </th>
                            <th class="text-center" width="1%">#</th>
                            <th class="text-nowrap">Thông tin sách</th>
                            <th class="text-nowrap">Số lượng</th>
                            <th class="text-nowrap">Giá</th>
                            <th class="text-nowrap">Chiết khấu</th>
                            <th>
                                <span class="lbl-action">Chức năng</span>
                                <button class="btn btn-danger btn-xs btn-block hide btn-delete-selected">Xóa <span class="lbl-selected-rows-count">0</span> sản phẩm</button>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-right">
                {{-- $collections->links() --}} 
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
    });
</script>
@endsection
