@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('product-manage.supplier.partials.search-form')
<div class="box box-table supplier">
    <div class="box-content">
        <div class="box-header">
            <h2 class="box-title">
                Danh sách đối tác RB
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
                        <a href="{{ route('suppliers-add') }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</a>
                        <a href="{{ route('suppliers-export') }}" class="btn btn-default"><i class="fas fa-download" aria-hidden="true"></i> {{ trans('home.Xuất tất cả') }}</a>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> {{ trans('home.Hiển thị') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('suppliers-index', filter_data($filter, 'limit', 10)) }}">10 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('suppliers-index', filter_data($filter, 'limit', 25)) }}">25 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('suppliers-index', filter_data($filter, 'limit', 50)) }}">50 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('suppliers-index', filter_data($filter, 'limit', 100)) }}">100 {{ trans('home.dòng / trang') }}</a></li>
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-sort" aria-hidden="true"></i> {{ trans('home.Sắp xếp') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('suppliers-index', filter_data($filter, 'orderBy', 'id')) }}">{{ trans('home.Mã nhà xuất bản') }}</a></li>
                                <li><a href="{{ route('suppliers-index', filter_data($filter, 'orderBy', 'name')) }}">{{ trans('home.Tên') }}</a></li>
                                <li><a href="{{ route('suppliers-index', filter_data($filter, 'orderBy', 'created_at')) }}">{{ trans('home.Ngày khởi tạo') }}</a></li>
                                <li><a href="{{ route('suppliers-index', filter_data($filter, 'orderBy', 'updated_at')) }}">{{ trans('home.Ngày chỉnh sửa') }}</a></li>
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
                                <li><a href="{{ route('suppliers-index', filter_data($filter, 'sortedBy', 'asc')) }}"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}</a></li>
                                <li><a href="{{ route('suppliers-index', filter_data($filter, 'sortedBy', 'desc')) }}"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th class="text-nowrap text-left">Tên đối tác</th>
                        <th class="text-nowrap text-left" width="30%">{{ trans('home.Liên hệ') }}</th>
                        <th class="text-nowrap">{{ trans('home.Chiết khấu') }}</th>
                        <th class="text-nowrap">{{ trans('home.Ngày khởi tạo') }}</th>
                        <th class="text-nowrap">{{ trans('home.Ngày chỉnh sửa') }}</th>
                        <th width="8%" class="text-nowrap">{{ trans('home.Chức năng') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @if($collections->count() === 0)
                        <tr>
                            <td colspan="8"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                        </tr>
                    @endif
                    @foreach($collections as $supplier)
                    <tr>
                        <td class="text-center">{{ $supplier->id }}</td>
                        <td class="text-nowrap">{{ $supplier->name }}</td>
                        <td class="text-nowrap">
                            <ul class="list-unstyled">
                                <li><b>{{ trans('home.Địa chỉ') }}:</b> {{ $supplier->address }}</li>
                                <li><b>{{ trans('home.Điện thoại') }}:</b> {{ $supplier->phone }}</li>
                                <li><b>Email:</b> {{ $supplier->email }}</li>
                            </ul>
                        <td class="text-nowrap text-center">{{ $supplier->discount }} %</td>
                        <td class="text-nowrap text-center">{{ $supplier->created_at }}</td>
                        <td class="text-nowrap text-center">{{ $supplier->updated_at }}</td>
                        <td class="text-center">
                            <a href="{{ route('suppliers-edit', ['id' => $supplier->id]) }}" title="Chỉnh sửa"><i class="fas fa-pencil-alt"></i></a>

                            <a href="javascript:void(0)" data-id="{{ $supplier->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <form name="form-delete-{{ $supplier->id }}" method="post" action="{{ route('suppliers-delete', ['id'=> $supplier->id]) }}">
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
@include('product-manage.supplier.partials.script')
@endsection
