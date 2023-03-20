@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@section('content')

@include(
    'product-manage.warehouse.reports.partials.search-report-detail',
    ['name' => $warehouse->name, 'in_stock' => $in_stock]
)

<div class="box box-table report-warehouse">
    <div class="box-content">
        <div class="box-header">
            <h2 class="box-title">
                Chi tiết Nhập/Xuất kho
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
                        <th class="text-nowrap text-center">Mã phiếu</th>
                        <th class="text-nowrap" width="10%">Tình trạng Nhập/Xuất</th>
                        <th class="text-nowrap text-left" width="25%">Tên phiếu</th>
                        <th class="text-nowrap text-center">Số lượng sản phẩm</th>
                        <th class="text-nowrap text-center">Ngày thực hiện</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $stt = 1;
                    @endphp
                    @if($collections->count() === 0)
                        <tr>
                            <td colspan="6"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                        </tr>
                    @endif
                    @foreach($collections as $collection)
                    <tr>
                        <td class="text-center">{{$stt}}</td>
                        <td class="text-center">{{ $collection['id'] }}</td>
                        @if (isset($collection['code_transfer']))
                            {{-- Nếu có code_transfer thì đây là phiếp xuất chuyển kho hoặc xuất chuyển kho --}}
                            @if ($collection['warehouseto_id'] == $warehouse->id)
                                <td class="text-center">
                                    <span class="alert alert-success">Nhập chuyển kho</span>
                                </td>
                            @else
                                <td class="text-center">
                                    <span class="alert alert-danger">Xuất chuyển kho</span>
                                </td>
                            @endif
                            <td>{{ $collection['code_transfer'] }}</td>
                        @elseif (isset($collection['import_code']))
                            {{-- Nếu có import_code thì đây là phiếp nhập kho --}}
                            <td class="text-center">
                                <span class="alert alert-success">Nhập kho</span>
                            </td>
                            <td>{{ $collection['warehouse_import_code'] }}</td>
                        @elseif (isset($collection['export_code']))
                            {{-- Nếu có import_code thì đây là phiếp xuất kho --}}
                            <td class="text-center">
                                <span class="alert alert-danger">Xuất kho</span>
                            </td>
                            <td>{{ $collection['warehouse_export_code'] }}</td>
                        @endif
                        <td class="text-center">{{ $collection['quantity'] }}</td>
                        <td class="text-center">{{ $collection['updated_at'] }}</td>
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
