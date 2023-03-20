@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('product-manage.export.partials.search-form')

<div class="box box-table export-product">
    <div class="box-content">
        <div class="box-header">
            <h2 class="box-title">
                {{ trans('home.Danh sách phiếu xuất hàng') }}
            </h2>
            <div class="pagination-group">
                {{ $collections->links() }}
            </div>
        </div>

        <div class="box-body">
            <div class="box-info">
                <p>{{ trans('home.Hiển thị') }} {{ $filter['limit'] }} {{ trans('home.dòng / trang') }}</p>
            
                <div class="box-tools">
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('warehouses-exports-add') }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</a>
                        <a href="{{ route('warehouses-export-all') }}" class="btn btn-default"><i class="fas fa-download" aria-hidden="true"></i> {{ trans('home.Xuất tất cả') }}</a>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> {{ trans('home.Hiển thị') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('warehouses-exports-index', filter_data($filter, 'limit', 10)) }}">10 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('warehouses-exports-index', filter_data($filter, 'limit', 25)) }}">25 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('warehouses-exports-index', filter_data($filter, 'limit', 50)) }}">50 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('warehouses-exports-index', filter_data($filter, 'limit', 100)) }}">100 {{ trans('home.dòng / trang') }}</a></li>
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-sort" aria-hidden="true"></i> {{ trans('home.Sắp xếp') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('warehouses-exports-index', filter_data($filter, 'orderBy', 'created_at')) }}">{{ trans('home.Ngày khởi tạo') }}</a></li>
                                <li><a href="{{ route('warehouses-exports-index', filter_data($filter, 'orderBy', 'updated_at')) }}">{{ trans('home.Ngày chỉnh sửa') }}</a></li>
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if($filter['sortedBy'] == 'asc' || empty($filter['sortedBy']))
                                    <i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}
                                @else
                                    <i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}
                                @endif
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('warehouses-exports-index', filter_data($filter, 'sortedBy', 'asc')) }}"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}</a></li>
                                <li><a href="{{ route('warehouses-exports-index', filter_data($filter, 'sortedBy', 'desc')) }}"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-nowrap" width="6%">{{ trans('home.Mã xuất') }}</th>
                        <th class="text-nowrap text-left" width="15%">{{ trans('home.Mã xuất kho') }}</th>
                        <th class="text-nowrap" width="15%">{{ trans('home.Đại lý') }}</th>
                        <th class="text-nowrap">{{ trans('home.Tổng tiền') }}</th>
                        <th class="text-nowrap">{{ trans('home.Trạng thái') }}</th>
                        <th class="text-nowrap">{{ trans('home.Ghi chú') }}</th>
                        <th class="text-nowrap">{{ trans('home.Ngày lập phiếu') }}</th>
                        <th width="8%" class="text-nowrap">{{ trans('home.Chức năng') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @if($collections->count() === 0)
                        <tr>
                            <td colspan="8"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                        </tr>
                    @endif
                    @foreach($collections as $export)
                    <tr>
                        <td class="text-center">{{ $export->order == NULL ? "" : $export->order->id }}</td>
                        <td>{{ $export->warehouse_export_code }}</td>
                        <td class="text-center">{{ $export->agencies }}</td>
                        <td>
                            <ul style="padding: 0; list-style-type: none;">
                                <li><b>{{ trans('home.Chưa chiết khấu') }}: </b> {{ number_format($export->sub_total) }} VNĐ</li>
                                <li><b>Đã chiết khấu (VAT): </b> {{ number_format($export->total) }} VNĐ</li>
                                @if($export->gift_fee == 20000)
                                <li><b>{{ trans('home.Phí gói quà') }}: </b> {{ number_format($export->gift_fee) }} VNĐ</li>
                                @endif
                                <li><b>{{ trans('home.Phí vận chuyển') }}: </b> {{ number_format($export->ship_total) }} VNĐ</li>
                            </ul>
                        </td>
                        <td class="text-center">
                            @switch($status = $export->status)
                                @case('DE_XUAT_DUYET')
                                    <span style="background-color: #FF0080; color: white;">{{ trans('home.Chờ duyệt') }}</span>
                                    @break;
                                @case('DUYET')
                                    <span class="alert alert-success">{{ trans('home. Đã duyệt') }}</span>
                                    @break;
                                @case('KHONG_DUYET')
                                    <span class="alert alert-dismissable">{{ trans('home.Không duyệt') }}</span>
                                    @break;    
                                @case('DA_XUAT_KHO')
                                    <span class="alert alert-dismissable">{{ trans('home.Xác nhận') }}</span>
                                    @break;
                                @case('DANG_VAN_CHUYEN')
                                    <span class="alert alert-info">{{ trans('home.Đang vận chuyển') }}</span>
                                    @break;
                                @case('GIAO_HANG_THANH_CONG')
                                    <span class="alert alert-info">{{ trans('home.Giao hàng thành công') }}</span>
                                    @break;
                                @case('HOAN_THANH')
                                    <span class="alert alert-info">{{ trans('home.Hoàn thành') }}</span>
                                    @break;
                                @case('THANH_TOAN')
                                    <span class="alert alert-success">{{ trans('home.Thanh toán') }}</span>
                                    @break;
                                @case('MOI_TAO')
                                    <span class="alert alert-warning">{{ trans('home.Mới tạo') }}</span>
                                    @break;
                                @default
                                    <span class="alert alert-danger">{{ trans('home.Hủy') }}</span>
                                    @break;
                            @endswitch
                        </td>
                        <td class="text-center">{{ $export->note }}</td>
                        <td class="text-center">{{ $export->created_at }}</td>
                        <td class="text-center">
                            <a href="{{ route('warehouses-exports-edit', ['id' => $export->id]) }}" title="Chỉnh sửa"><i class="fas fa-pencil-alt"></i></a>

                            <a href="{{ route('warehouses-exports-print', ['id' => $export->id]) }}" title="In đơn"><i class="fa fa-print"></i></a>

                            <a href="{{ route('warehouses-exports-export', ['id' => $export->id]) }}" title="Xuất dữ liệu"><i class="fa fa-download" aria-hidden="true"></i></a>

                            @if(Auth()->user()->roles()->get()->first()->name == "owner")
                            <a href="javascript:void(0)" data-id="{{ $export->id }}" class="btn-delete" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <form name="form-delete-{{ $export->id }}" method="post" action="{{ route('warehouses-exports-delete', ['id' => $export->id ]) }}">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="box-footer text-right">
            {{ $collections->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
@include('product-manage.export.partials.script')
@endsection
