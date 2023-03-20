@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('product-manage.transfer.partials.search-form')

<div class="box box-table transfer-product">
    <div class="box-content">
        <div class="box-header">
            <h2 class="box-title">
                {{ trans('home.Danh sách chuyển kho') }}
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
                        <a href="{{ route('warehouses-transfers-add') }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</a>
                        <a href="#" class="btn btn-default"><i class="fas fa-download" aria-hidden="true"></i> {{ trans('home.Xuất tất cả') }}</a>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> {{ trans('home.Hiển thị') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('warehouses-transfers-index', filter_data($filter, 'limit', 10)) }}">10 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('warehouses-transfers-index', filter_data($filter, 'limit', 25)) }}">25 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('warehouses-transfers-index', filter_data($filter, 'limit', 50)) }}">50 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('warehouses-transfers-index', filter_data($filter, 'limit', 100)) }}">100 {{ trans('home.dòng / trang') }}</a></li>
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-sort" aria-hidden="true"></i> {{ trans('home.Sắp xếp') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('warehouses-transfers-index', filter_data($filter, 'orderBy', 'created_at')) }}">{{ trans('home.Ngày khởi tạo') }}</a></li>
                                <li><a href="{{ route('warehouses-transfers-index', filter_data($filter, 'orderBy', 'updated_at')) }}">{{ trans('home.Ngày chỉnh sửa') }}</a></li>
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
                                <li><a href="{{ route('warehouses-transfers-index', filter_data($filter, 'sortedBy', 'asc')) }}"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}</a></li>
                                <li><a href="{{ route('warehouses-transfers-index', filter_data($filter, 'sortedBy', 'desc')) }}"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th class="text-nowrap text-left">{{ trans('home.Kho xuất ra') }}</th>
                        <th class="text-nowrap">{{ trans('home.Mã chuyển kho') }}</th>
                        <th class="text-nowrap">{{ trans('home.Kho nhập vào') }}</th>
                        <th class="text-nowrap">{{ trans('home.Tổng số lượng') }}</th>
                        <th class="text-nowrap">{{ trans('home.Ghi chú') }}</th>
                        <th class="text-nowrap">{{ trans('home.Tình trạng') }}</th>
                        <th class="text-nowrap">{{ trans('home.Ngày lập phiếu') }}</th>
                        <th width="8%" class="text-nowrap">{{ trans('home.Chức năng') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @if($collections->count() === 0)
                        <tr>
                            <td colspan="7"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                        </tr>
                    @endif
                    @foreach($collections as $transfer)
                    <tr>
                        <td class="text-center">{{ $transfer->id }}</td>
                        <td>{{ $transfer->code_transfer }}</td>
                        <td class="text-center">{{ $transfer->warehousefrom->name }}</td>
                        <td class="text-center">{{ $transfer->warehouseto->name }}</td>
                        <td class="text-center">{{ $transfer->quantity }}</td>
                        <td>{{ $transfer->note }}</td>
                        <td class="text-center">
                            @switch($status = $transfer->status)
                                @case('XAC_NHAN')
                                    <span class="alert alert-dismissable">{{ trans('home.Xác nhận') }}</span>
                                    @break;
                                @case('CHUYEN_KHO')
                                    <span class="alert alert-info">Đã chuyển kho</span>
                                    @break;
                                @case('MOI_TAO')
                                    <span class="alert alert-warning">{{ trans('home.Mới tạo') }}</span>
                                    @break;
                                @case('DE_XUAT_DUYET')
                                    <span style="background-color: #FF0080; color: white;">Chờ duyệt</span>
                                    @break;
                                @case('KHONG_DUYET')
                                    <span class="alert alert-danger">Không duyệt</span>
                                    @break;
                                @case('DA_DUYET')
                                    <span class="alert alert-success">Đã duyệt</span>
                                    @break;
                                @default
                                    <span class="alert alert-danger">{{ trans('home.Hủy') }}</span>
                                    @break;
                            @endswitch
                        </td>
                        <td class="text-center">{{ $transfer->created_at }}</td>
                        <td class="text-center">
                            <a href="{{ route('warehouses-transfers-edit', ['id' => $transfer->id]) }}" title="Chỉnh sửa"><i class="fas fa-pencil-alt"></i></a>

                            <a href="{{ route('warehouses-transfers-export', ['id' => $transfer->id]) }}" title="Xuất dữ liệu"><i class="fa fa-download" aria-hidden="true"></i></a>

                            @if(Auth()->user()->roles()->get()->first()->name == "owner")
                            <a href="javascript:void(0)" data-id="{{ $transfer->id }}" class="btn-delete" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <form name="form-delete-{{ $transfer->id }}" method="post" action="{{ route('warehouses-transfers-delete', ['id'=> $transfer->id]) }}">
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
@include('product-manage.transfer.partials.script')
@endsection
