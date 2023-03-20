@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('product-manage.debt.partials.search-form')
@include('product-manage.debt.partials.add')

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    Danh sách công nợ
                    <small>(Hiển thị {{ $filter['limit'] }} dòng / trang) </small>
                </h3>
                <div class="box-tools">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#getFormAdd"><i class="fa fa-plus" aria-hidden="true"></i> Tạo mới</button>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-download" aria-hidden="true"></i> Xuất danh sách
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('debts-export') }}"><i class="fas fa-download" aria-hidden="true"></i> Xuất tất cả</a></li>
                                <li><a href="#"><i class="fa fa-file-text" aria-hidden="true"></i> Xuất đã chọn</a></li>
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
                                <li><a href="{{ route('debts-index', filter_data($filter, 'limit', 10)) }}">10 dòng / trang</a></li>
                                <li><a href="{{ route('debts-index', filter_data($filter, 'limit', 25)) }}">25 dòng / trang</a></li>
                                <li><a href="{{ route('debts-index', filter_data($filter, 'limit', 50)) }}">50 dòng / trang</a></li>
                                <li><a href="{{ route('debts-index', filter_data($filter, 'limit', 100)) }}">100 dòng / trang</a></li>
                            </ul>
                        </div>

                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-sort" aria-hidden="true"></i> Sắp xếp
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('debts-index', filter_data($filter, 'orderBy', 'id')) }}">Mã phiếu chuyển kho</a></li>
                                <li><a href="{{ route('debts-index', filter_data($filter, 'orderBy', 'email')) }}">Ghi chú</a></li>
                                <li><a href="{{ route('debts-index', filter_data($filter, 'orderBy', 'created_at')) }}">Ngày tạo</a></li>
                                <li><a href="{{ route('debts-index', filter_data($filter, 'orderBy', 'updated_at')) }}">Ngày chỉnh sửa</a></li>
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
                                <li><a href="{{ route('debts-index', filter_data($filter, 'sortedBy', 'asc')) }}"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> Tăng dần</a></li>
                                <li><a href="{{ route('debts-index', filter_data($filter, 'sortedBy', 'desc')) }}"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> Giảm dần</a></li>
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
                            <th>#</th>
                            <th class="text-nowrap">Nhà cung cấp</th>
                            <th class="text-nowrap">Phiếu nhập</th>
                            <th class="text-nowrap">Ngày lập công nợ</th>
                            <th class="text-nowrap">Ngày trả</th>
                            <th class="text-nowrap">Số tiền</th>
                            <th class="text-nowrap">Tình trạng</th>
                            <th class="text-nowrap">Ghi chú</th>
                            <th class="text-nowrap">Ngày chỉnh sửa</th>
                            <th class="text-nowrap">
                                <span class="lbl-action">Chức năng</span>
                                <button class="btn btn-danger btn-xs btn-block hide btn-delete-selected">Xóa <span class="lbl-selected-rows-count">0</span> đã chọn</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($collections->count() === 0)
                        <tr>
                            <td colspan="8"><b>Không có dữ liệu!!!</b></td>
                        </tr>
                        @endif
                        @foreach($collections as $debt)
                            <tr>
                                <td>
                                    <label>
                                        <input type="checkbox" class="minimal checkbox-item">
                                    </label>
                                </td>
                                <td>{{ $debt->id }}</td>
                                <td>{{ $debt->suppliers->name }}</td>
                                <td>{{ $debt->imports->code }}</td>
                                <td>{{ date("d-m-Y", strtotime($debt->start_date)) }}</td>
                                <td>{{ date("d-m-Y", strtotime($debt->end_date)) }}</td>
                                <td>
                                    <ul>
                                        <li>Tổng số tiền phiếu nhập:<b> {{ number_format($debt->total) }} </b>VNĐ</li>
                                        <li>Số tiền trả trước:<b> {{ number_format($debt->paymented_debt) }} </b>VNĐ</li>
                                        <li>Số tiền còn nợ:<b> {{ number_format($debt->outstanding_debt) }} </b>VNĐ</li>
                                    </ul>
                                </td>
                                <td>
                                    @if($debt->status == 1)
                                        <b class="btn-default">Đang chỉnh sửa</b>
                                    @elseif($debt->status == 2)
                                        <b>Chờ bổ sung</b>
                                    @elseif($debt->status == 3)
                                        <b class="btn-success">Hoàn thành</b>
                                    @else
                                        <b class="btn-danger">Hủy</b>
                                    @endif
                                </td>
                                <td>{{ $debt->note }}</td>
                                <td>{{ $debt->updated_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Thao tác <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="{{ route('debts-edit', ['id' => $debt->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Chỉnh sửa</a></li>
                                            <li>
                                                <a href="javascript:void(0)" data-id="{{ $debt->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
                                                <form name="form-delete-{{ $debt->id }}" method="post" action="{{ route('debts-delete', ['id'=> $debt->id]) }}">
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
                    <tfoot>
                        <tr>
                            <th width="1%">
                                <label>
                                    <input type="checkbox" class="minimal checkbox-all">
                                </label>
                            </th>
                            <th>#</th>
                            <th class="text-nowrap">Nhà cung cấp</th>
                            <th class="text-nowrap">Phiếu nhập</th>
                            <th class="text-nowrap">Ngày lập công nợ</th>
                            <th class="text-nowrap">Ngày trả</th>
                            <th class="text-nowrap">Số tiền</th>
                            <th class="text-nowrap">Tình trạng</th>
                            <th class="text-nowrap">Ghi chú</th>
                            <th class="text-nowrap">Ngày chỉnh sửa</th>
                            <th class="text-nowrap">
                                <span class="lbl-action">Chức năng</span>
                                <button class="btn btn-danger btn-xs btn-block hide btn-delete-selected">Xóa <span class="lbl-selected-rows-count">0</span> đã chọn</button>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix text-right">
                {{ $collections->links() }}
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection

@section('scripts')
@include('product-manage.debt.partials.script')
@endsection
