@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">

<!-- <style>
    .requests input:first-child,
    .quantity input:first-child{
        margin-right: 10px;
    }
</style> -->
@endsection

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('product-manage.product.partials.search-product-statistical')

<div class="box box-table product-statistical">
    <div class="box-content">
        <div class="box-header">
            <h2 class="box-title">
                Thống kê sản phẩm
            </h2>
            <div class="pagination-group">
                {{ $collections->appends(request()->query())->links() }}
            </div>
        </div>

        <div class="box-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-nowrap" width="1%">STT</th>
                        <th class="text-nowrap">Mã phiếu</th>
                        <th class="text-nowrap text-left" width="25%">Đơn hàng</b></th>
                        <th class="text-nowrap">Ngày đơn hàng</b></th>
                        <th class="text-nowrap">Nhập</th>
                        <th class="text-nowrap">Số lượng nhập</th>
                        <th class="text-nowrap">Xuất</th>
                        <th class="text-nowrap">Số lượng xuất</th>
                    </tr>
                </thead>

                <tbody>
                    @if($collections->count() === 0)
                        <tr>
                            <td colspan="8"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                        </tr>
                    @endif

                    @php
                        $stt = 0;
                    @endphp

                    @foreach($collections as $collection)

                    @php
                        $stt ++;
                    @endphp
                    <tr>
                        <td class="text-center">{{$stt}}</td>
                        <td class="text-center">{{ $collection['id'] }}</td>

                        @if (isset($collection['import_code']))
                            {{-- Nếu có import_code thì đây là phiếp nhập kho --}}
                            <td style="word-break: break-word;">{{ $collection['warehouse_import_code'] }}</td>
                        @elseif (isset($collection['export_code']))
                            {{-- Nếu có import_code thì đây là phiếp xuất kho --}}
                            <td style="word-break: break-word;">{{ $collection['warehouse_export_code'] }}</td>
                        @endif

                        <td class="text-center">{{ $collection['updated_at'] }}</td>

                        @if (isset($collection['import_code']))
                            {{-- Nếu có import_code thì đây là phiếp nhập kho --}}
                            <td class="text-center"><span class="alert alert-success">Nhập</span></td>
                            <td class="text-center">{{$collection['quantity']}}</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        @elseif (isset($collection['export_code']))
                            {{-- Nếu có import_code thì đây là phiếp xuất kho --}}
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"><span class="alert alert-danger">Xuất</span></td>
                            <td class="text-center">{{$collection['quantity']}}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="box-footer text-right">
            {{ $collections->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(function() {
        $('.search-code').select2({
            placeholder: '{{ trans('home.Tìm kiếm sản phẩm') }}',
            ajax: {
                url: '{{ route('api-products-search') }}',
                processResults: function (data) {
                    return {
                        results: data.items
                    };
                }
            }
        }).change(function() {
            var product_id = $(this).val();
            $('#product_statistical_search').val(product_id);
        });
    });
</script>

@if(isset($product))
<script>
    $(function() {
        $('.search-code').trigger('change');
    });
</script>
@endif
@endsection
