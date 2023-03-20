@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@include('product-manage.category.partials.search-form')
@include('product-manage.category.partials.importData')
<div class="box box-table category">
    <div class="box-content">
        <div class="box-header">
            <h2 class="box-title">
                {{ trans('home.Danh sách danh mục') }}
            </h2>
            <div class="pagination-group">
                {{ $collections->links() }}
            </div>
        </div>

        <div class="box-body">
            <div class="box-info">
                <p>{{ trans('home.Hiển thị') }} {{$collections->count()}} {{ trans('home.dòng / trang') }}</p>
            
                <div class="box-tools">
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('categories-add') }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</a>
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal"><i class="fa fa-upload" aria-hidden="true"></i> {{ trans('home.Nhập dữ liệu') }}</button>
                        <a href="{{ route('categories-export') }}" class="btn btn-default"><i class="fas fa-download" aria-hidden="true"></i> {{ trans('home.Xuất tất cả') }}</a>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> {{ trans('home.Hiển thị') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('categories-index', filter_data($filter, 'limit', 10)) }}">10 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('categories-index', filter_data($filter, 'limit', 25)) }}">25 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('categories-index', filter_data($filter, 'limit', 50)) }}">50 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('categories-index', filter_data($filter, 'limit', 100)) }}">100 {{ trans('home.dòng / trang') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center" width="1%">STT</th>
                        <th class="text-nowrap text-left" width="20%">{{ trans('home.Danh mục') }}</th>
                        <th class="text-nowrap text-left">{{ trans('home.Mô tả') }}</th>
                        <th class="text-nowrap" width="20%">{{ trans('home.Mã danh mục cha') }}</th>
                        <th class="text-nowrap">{{ trans('home.Ngày khởi tạo') }}</th>
                        <th class="text-nowrap">{{ trans('home.Ngày chỉnh sửa') }}</th>
                        <th width="8%" class="text-nowrap">{{ trans('home.Chức năng') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @if($collections->count() === 0)
                        <tr>
                            <td colspan="7"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                        </tr>
                    @endif
                    @foreach($collections as $category)
                    <tr>
                        <td class="text-center">{{ $category->id }}</td>
                        <td>
                            <div>
                                <div>{{ sub_category_depth_tab($category->depth) . $category->name }}</div>
                            </div>
                        </td>
                        <td>{!! $category->description !!}</td>
                        <td class="text-center">{{ $category->parent_id }}</td>
                        <td class="text-center">{{ $category->created_at }}</td>
                        <td class="text-center">{{ $category->updated_at }}</td>
                        <td class="text-center">
                            <a href="{{ route('categories-edit', ['id' => $category->id]) }}" title="Chỉnh sửa"><i class="fas fa-pencil-alt"></i></a>

                            <a href="javascript:void(0)" data-id="{{ $category->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <form name="form-delete-{{ $category->id }}" method="post" action="{{ route('categories-delete', ['id' => $category->id ]) }}">
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
@include('product-manage.category.partials.script')
@endsection
