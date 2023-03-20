@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/authors.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('product-manage.author.partials.search-form')

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    Danh sách tác giả
                    <small>(Hiển thị {{ $filter['limit'] }} dòng / trang) </small>
                </h3>
                <div class="box-tools">
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('authors-add') }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> Tạo mới</a>
                        <a class="btn btn-default" href="{{ route('customers-export') }}"><i class="fa fa-download"></i> Xuất tất cả</a>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> Hiển thị
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('authors-index', filter_data($filter, 'limit', 10)) }}">10 dòng / trang</a></li>
                                <li><a href="{{ route('authors-index', filter_data($filter, 'limit', 25)) }}">25 dòng / trang</a></li>
                                <li><a href="{{ route('authors-index', filter_data($filter, 'limit', 50)) }}">50 dòng / trang</a></li>
                                <li><a href="{{ route('authors-index', filter_data($filter, 'limit', 100)) }}">100 dòng / trang</a></li>
                            </ul>
                        </div>

                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-sort" aria-hidden="true"></i> Sắp xếp
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('authors-index', filter_data($filter, 'orderBy', 'id')) }}">Mã tác giả</a></li>
                                <li><a href="{{ route('authors-index', filter_data($filter, 'orderBy', 'name')) }}">Họ và tên</a></li>
                                <li><a href="{{ route('authors-index', filter_data($filter, 'orderBy', 'created_at')) }}">Ngày tạo</a></li>
                                <li><a href="{{ route('authors-index', filter_data($filter, 'orderBy', 'updated_at')) }}">Ngày chỉnh sửa</a></li>
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
                                <li><a href="{{ route('authors-index', filter_data($filter, 'sortedBy', 'asc')) }}"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> Tăng dần</a></li>
                                <li><a href="{{ route('authors-index', filter_data($filter, 'sortedBy', 'desc')) }}"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> Giảm dần</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="1%">
                                <label>
                                    <input type="checkbox" class="minimal checkbox-all" value="1">
                                </label>
                            </th>
                            <th class="text-nowrap" width="1%">#</th>
                            <th class="text-nowrap" width="40%">Tác giả</th>
                            <th class="text-nowrap">Thông tin tác giả</th>
                            <th class="text-nowrap">Ngày khởi tạo</th>
                            <th class="text-nowrap">Ngày chỉnh sửa</th>
                            <th width="1%">
                                <span class="lbl-action">Chức năng</span>
                                <button class="btn btn-danger btn-xs btn-block hide btn-delete-selected">Xóa <span class="lbl-selected-rows-count">0</span> tác giả</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($collections->count() === 0)
                        <tr>
                            <td colspan="7"><b>Không có dữ liệu!!!</b></td>
                        </tr>
                        @endif
                        @foreach($collections as $author)
                        <tr>
                            <td width="1%">
                                <label>
                                    <input type="checkbox" class="minimal checkbox-item" data-id="{{ $author->id }}">
                                </label>
                            </td>
                            <td class="text-center">{{ $author->id }}</td>
                            <td>
                                <img src="{{ asset(empty($author->image) ? RBOOKS_NO_IMAGE_URL : $author->image->path) }}" class="pull-left author-thumbnail">
                                <ul class="list-unstyled pull-left">
                                    <li>{{ $author->name }}</li>
                                    <li><small><a href="{{ url($author->slug) }}" target="_blank" title="Click để mở trong tab mới">{{ $author->slug }} <i class="fa fa-external-link" aria-hidden="true"></i></a></small></li>
                                </ul>
                            </td>
                            <td>{!! $author->description !!}</td>
                            <td>{{ $author->created_at }}</td>
                            <td>{{ $author->updated_at }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Thao tác <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{ route('authors-edit', ['id' => $author->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Chỉnh sửa</a></li>
                                        <li>
                                            <a href="javascript:void(0)" data-id="{{ $author->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
                                            <form name="form-delete-{{ $author->id }}" method="post" action="{{ route('authors-delete', ['id'=> $author->id]) }}">
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
                                    <input type="checkbox" class="minimal checkbox-all" value="1">
                                </label>
                            </th>
                            <th class="text-nowrap" width="1%">#</th>
                            <th class="text-nowrap" width="40%">Tác giả</th>
                            <th class="text-nowrap">Thông tin tác giả</th>
                            <th class="text-nowrap">Ngày tạo</th>
                            <th class="text-nowrap">Ngày chỉnh sửa</th>
                            <th width="1%">
                                <span class="lbl-action">Chức năng</span>
                                <button class="btn btn-danger btn-xs btn-block hide btn-delete-selected">Xóa <span class="lbl-selected-rows-count">0</span> tác giả</button>
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
@include('product-manage.author.partials.script')
@endsection
