@extends('layouts.master')
@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">

<style>
    @-webkit-keyframes glowing {
        0% { color: black;  }
        50% { color: red;  }
        100% { color: black;  }
    }

    @-moz-keyframes glowing {
        0% { color: black;  }
        50% { color: red;  }
        100% { color: black;  }
    }

    @-o-keyframes glowing {
        0% { color: black; }
        50% { color: red; }
        100% { color: black;  }
    }

    @keyframes glowing {
        0% { color: black;  }
        50% { color: red; }
        100% { color: black;  }
    }

    .warning {
        -webkit-animation: glowing 1000ms infinite;
        -moz-animation: glowing 1000ms infinite;
        -o-animation: glowing 1000ms infinite;
        animation: glowing 1000ms infinite;
    }
</style>
@endsection

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('product-manage.product.partials.search-form')
<div class="box box-table product">
    <div class="box-content">
        <div class="box-header">
            <h2 class="box-title">
                {{ trans('home.Danh sách sản phẩm') }}
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
                        <a href="{{ route('products-add') }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</a>
                        <a href="{{route('product-export')}}" class="btn btn-default"><i class="fas fa-download" aria-hidden="true"></i> {{ trans('home.Xuất tất cả') }}</a>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> {{ trans('home.Hiển thị') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('products-index', filter_data($filter, 'limit', 10)) }}">10 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('products-index', filter_data($filter, 'limit', 25)) }}">25 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('products-index', filter_data($filter, 'limit', 50)) }}">50 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('products-index', filter_data($filter, 'limit', 100)) }}">100 {{ trans('home.dòng / trang') }}</a></li>
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-sort" aria-hidden="true"></i> {{ trans('home.Sắp xếp') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('products-index', filter_data($filter, 'orderBy', 'id')) }}">{{ trans('home.Mã sách') }}</a></li>
                                <li><a href="{{ route('products-index', filter_data($filter, 'orderBy', 'name')) }}">{{ trans('home.Tên sản phẩm') }}</a></li>
                                <li><a href="{{ route('products-index', filter_data($filter, 'orderBy', 'barcode')) }}">Barcode</a></li>
                                <li><a href="{{ route('products-index', filter_data($filter, 'orderBy', 'sku')) }}">Sku</a></li>
                                <li><a href="{{ route('products-index', filter_data($filter, 'orderBy', 'quantity')) }}">{{ trans('home.Số lượng') }}</a></li>
                                <li><a href="{{ route('products-index', filter_data($filter, 'orderBy', 'cover_price')) }}">{{ trans('home.Giá bìa') }}</a></li>
                                <li><a href="{{ route('products-index', filter_data($filter, 'orderBy', 'sale_price')) }}">{{ trans('home.Giá bán') }}</a></li>
                                <li><a href="{{ route('products-index', filter_data($filter, 'orderBy', 'promotion_price')) }}">{{ trans('home.Giá khuyến mãi') }}</a></li>
                                <li><a href="{{ route('products-index', filter_data($filter, 'orderBy', 'publishing_year')) }}">{{ trans('home.Năm xuất bản') }}</a></li>
                                <li><a href="{{ route('products-index', filter_data($filter, 'orderBy', 'status')) }}">{{ trans('home.Trạng thái') }}</a></li>
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
                                <li><a href="{{ route('products-index', filter_data($filter, 'sortedBy', 'desc')) }}"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}</a></li>
                                <li><a href="{{ route('products-index', filter_data($filter, 'sortedBy', 'asc')) }}"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th class="text-left" width="30%">{{ trans('home.Sản phẩm') }}</th>
                        <th>{{ trans('home.Giá') }}</th>
                        <th class="text-left">{{ trans('home.Tồn kho') }}</th>
                        <th>{{ trans('home.Ngày chỉnh sửa') }}</th>
                        <th width="8%" class="text-nowrap">{{ trans('home.Chức năng') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @if($collections->count() === 0)
                        <tr>
                            <td colspan="6"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                        </tr>
                    @endif
                    @foreach($collections as $product)
                    <tr>
                        <td width="1%">
                            <img src="{{ asset(empty($product->images->last()) ? RBOOKS_NO_IMAGE_URL : $product->images->last()->path) }}" class="product-thumbnail">
                        </td>

                        <td>
                            <ul class="list-unstyled">
                                <li>{{ $product->name }}</li>
                                <li class="text-muted">#{{ $product->id }} - SKU: {{ $product->sku }}</li>
                                <li class="text-muted">ISBN: {{ $product->isbn }}</li>
                                <li class="text-muted">Mã vạch: {{ $product->barcode }}</li>
                                <li class="text-muted">
                                @if(count($product->productwarehouses) == 0)
                                    <a class="warning" style="font-weight: 700">
                                        {{ trans('home.Hiện tại trong kho chưa có sản phẩm') }}.
                                    </a>
                                    <li>
                                        <a class="warning" style="font-weight: 700">
                                        {{ trans('home.Yêu cầu nhập thêm !') }}'
                                        </a>
                                    </li>
                                @elseif(count($product->productwarehouses) > 0 && $product->productwarehouses[1]->quantity < 100)
                                    <a class="warning" style="font-weight: 700">
                                        {{ trans('home.Kho chỉ còn') }}: {{$product->productwarehouses[1]->quantity}} {{ trans('home.Sản phẩm') }}
                                    </a>
                                    <li>
                                        <a class="warning" style="font-weight: 700">
                                        {{ trans('home.Yêu cầu nhập thêm !') }}
                                        </a>
                                    </li>
                                @endif
                                </li>
                            </ul>
                        </td>

                        <td class="text-center">
                            <ul class="list-unstyled">
                                <li><b>{{ trans('home.Giá') }}:</b> {{ price_format($product->cover_price) }}</li>
                                <li><b>{{ trans('home.Giá bán') }}:</b> {{ price_format($product->sale_price) }}</li>
                            </ul>
                        </td>

                        <td>
                            <ul class="list-unstyled">
                                <li>
                                    <b>
                                        {{ trans('home.Kho Tổng') }}:
                                    </b>
                                {{( $product->productwarehouses->where('warehouse_id', '<>', 1)->sum('quantity') )}}
                                </li>
                                @foreach($product->productwarehouses as $quantityWarehouse)
                                <li>
                                    <b>
                                        {{ $product->warehouses->find($quantityWarehouse->warehouse_id) != null ? $product->warehouses->find($quantityWarehouse->warehouse_id)->name : $quantityWarehouse->warehouse_id }}:
                                    </b>
                                    {{ $quantityWarehouse->quantity }}
                                </li>
                                @endforeach
                            </ul>
                        </td>

                        <td class="text-center">{{ $product->updated_at }}</td>
                        
                        <td class="text-center">
                            <a href="#" title="Xem chi tiết"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a href="{{ route('products-edit', ['id' => $product->id]) }}" title="Chỉnh sửa nội dung"><i class="fas fa-pencil-alt"></i></a>
                            <a href="{{ route('frm-upload', ['id' => $product->id]) }}" title="Chỉnh sửa hình ảnh"><i class="fa fa-picture-o" aria-hidden="true"></i></a>
                            <a href="javascript:void(0)" data-id="{{ $product->id }}" class="btn-delete" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <form name="form-delete-{{ $product->id }}" method="post" action="{{ route('products-delete', ['id'=> $product->id]) }}">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                            </form>
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
@include('product-manage.product.partials.script')
@endsection
