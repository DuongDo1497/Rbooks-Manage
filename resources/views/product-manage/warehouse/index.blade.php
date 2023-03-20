@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@section('content')

@if(session()->has('success'))
@include('layouts.partials.messages.success')
@endif

@include('product-manage.warehouse.partials.search-form')
<div class="box box-table warehouse">
    <div class="box-content">
        <div class="box-header">
            <h2 class="box-title">
                {{ trans('home.Danh sách kho hàng') }}
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
                        <a href="{{ route('warehouses-add') }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</a>
                        <a href="{{ route('warehouses-export') }}" class="btn btn-default"><i class="fas fa-download" aria-hidden="true"></i> {{ trans('home.Xuất tất cả') }}</a>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> {{ trans('home.Hiển thị') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('warehouses-index', filter_data($filter, 'limit', 10)) }}">10 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('warehouses-index', filter_data($filter, 'limit', 25)) }}">25 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('warehouses-index', filter_data($filter, 'limit', 50)) }}">50 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('warehouses-index', filter_data($filter, 'limit', 100)) }}">100 {{ trans('home.dòng / trang') }}</a></li>
                            </ul>
                        </div>

                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-sort" aria-hidden="true"></i> {{ trans('home.Sắp xếp') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('warehouses-index', filter_data($filter, 'orderBy', 'created_at')) }}">{{ trans('home.Ngày khởi tạo') }}</a></li>
                                <li><a href="{{ route('warehouses-index', filter_data($filter, 'orderBy', 'updated_at')) }}">{{ trans('home.Ngày chỉnh sửa') }}</a></li>
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
                                <li><a href="{{ route('warehouses-index', filter_data($filter, 'sortedBy', 'desc')) }}"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}</a></li>
                                <li><a href="{{ route('warehouses-index', filter_data($filter, 'sortedBy', 'asc')) }}"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-nowrap">STT</th>
                        <th class="text-nowrap text-left" width="12%">{{ trans('home.Tên kho') }}</th>
                        <th class="text-nowrap text-left" width="8%">{{ trans('home.Ký tự') }}</th>
                        <th class="text-nowrap text-left">{{ trans('home.Địa chỉ') }}</th>
                        <th class="text-nowrap">Trạng thái</th>
                        <th class="text-nowrap">{{ trans('home.Số điện thoại') }}</th>
                        <th class="text-nowrap">{{ trans('home.Lệ phí') }}</th>
                        <th class="text-nowrap">{{ trans('home.Lợi nhuận') }}</th>
                        <th class="text-nowrap">{{ trans('home.Ngày khởi tạo') }}</th>
                        <th class="text-nowrap">{{ trans('home.Ngày chỉnh sửa') }}</th>
                        <th class="text-nowrap">{{ trans('home.Chức năng') }}</th>
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
                        <td>{{ $warehouse->characters }}</td>
                        <td>{{ $warehouse->address }}</td>
                        <td class="text-nowrap">
                            <span class="alert @if ($warehouse->status==0) alert-error @endif  @if ($warehouse->status==1) alert-success @endif ">{{ $warehouse->status_text }}</span>
                        </td>
                        <td class="text-nowrap text-center">{{ $warehouse->phone }}</td>
                        <td class="text-center">{{ $warehouse->fee_percent }}</td>
                        <td class="text-center">{{ $warehouse->profit_percent }}</td>
                        <td class="text-center">{{ $warehouse->created_at }}</td>
                        <td class="text-center">{{ $warehouse->updated_at }}</td>
                        <td class="text-center">
                            <a href="{{ route('warehouses-edit', ['id' => $warehouse->id]) }}" title="Chỉnh sửa"><i class="fas fa-pencil-alt"></i></a>

                            <a href="javascript:void(0)" data-id="{{ $warehouse->id }}" class="btn-delete" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <form name="form-delete-{{ $warehouse->id }}" method="post" action="{{ route('warehouses-delete', ['id'=> $warehouse->id]) }}">
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
@include('product-manage.warehouse.partials.script')
@endsection