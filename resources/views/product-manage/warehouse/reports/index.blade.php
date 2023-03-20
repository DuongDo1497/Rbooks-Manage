@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">

<style>
    .report-warehouse .note{
        color: #b8170b;
    }
</style>
@endsection

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('product-manage.warehouse.reports.partials.search-report', [
    'export_and_import_times' => $export_and_import_times,
    'export_and_import_quantity' => $export_and_import_quantity,
])

<div class="box box-table report-warehouse">
    <div class="box-content">
        <div class="box-header">
            <h2 class="box-title">
                Báo cáo kho hàng
            </h2>
            <div class="pagination-group">
                {{ $collections->links() }}
            </div>
        </div>

        <div class="box-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="4%">STT</th>
                        <th class="text-nowrap text-left" width="10%">{{ trans('home.Tên kho') }}</th>
                        <th class="text-nowrap" width="25%">Số lượng Nhập kho <b class="note">(Nhập kho + Nhập chuyển kho)</b></th>
                        <th class="text-nowrap" width="25%">Số lượng Xuất kho <b class="note">(Xuất kho + Xuất chuyển kho)</b></th>
                        <th class="text-nowrap">Tồn kho hiện tại</th>
                        <th width="8%" class="text-nowrap">{{ trans('home.Chức năng') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @if($collections->count() === 0)
                        <tr>
                            <td colspan="6"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                        </tr>
                    @endif
                    @foreach($collections as $warehouse)
                    <tr>
                        <td class="text-center">{{ $warehouse->id }}</td>
                        <td>{{ $warehouse->name }}</td>
                        <td class="text-center">{{ $warehouse->total_in }}</td>
                        <td class="text-center">{{ $warehouse->total_out }}</td>
                        <td class="text-center">{{ $warehouse->in_stock }}</td>
                        <td class="text-center">
                            <a href="{{ route('warehouses-report-details', $warehouse->id) }}" title="Xem chi tiết"><i class="fa fa-eye" aria-hidden="true"></i></a>
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
@endsection
