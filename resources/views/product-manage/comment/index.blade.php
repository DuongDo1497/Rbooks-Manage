@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('product-manage.comment.partials.search-form')
<div class="box box-table comment">
    <div class="box-content">
        <div class="box-header">
            <h2 class="box-title">
                {{ trans('home.Danh sách đánh giá/nhận xét') }}
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
                        <a href="{{ route('comments-add') }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</a>
                        <a href="#" class="btn btn-default"><i class="fas fa-download" aria-hidden="true"></i> {{ trans('home.Xuất tất cả') }}</a>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> {{ trans('home.Hiển thị') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('comments-index', filter_data($filter, 'limit', 10)) }}">10 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('comments-index', filter_data($filter, 'limit', 25)) }}">25 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('comments-index', filter_data($filter, 'limit', 50)) }}">50 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('comments-index', filter_data($filter, 'limit', 100)) }}">100 {{ trans('home.dòng / trang') }}</a></li>
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-sort" aria-hidden="true"></i> {{ trans('home.Sắp xếp') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('comments-index', filter_data($filter, 'orderBy', 'id')) }}">{{ trans('home.Mã nhà xuất bản') }}</a></li>
                                <li><a href="{{ route('comments-index', filter_data($filter, 'orderBy', 'name')) }}">{{ trans('home.Tên') }}</a></li>
                                <li><a href="{{ route('comments-index', filter_data($filter, 'orderBy', 'created_at')) }}">{{ trans('home.Ngày khởi tạo') }}</a></li>
                                <li><a href="{{ route('comments-index', filter_data($filter, 'orderBy', 'updated_at')) }}">{{ trans('home.Ngày chỉnh sửa') }}</a></li>
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
                                <li><a href="{{ route('comments-index', filter_data($filter, 'sortedBy', 'asc')) }}"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}</a></li>
                                <li><a href="{{ route('comments-index', filter_data($filter, 'sortedBy', 'desc')) }}"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th class="text-nowrap text-left">{{ trans('home.Tiêu đề') }}</th>
                        <th class="text-nowrap text-left" width="30%">{{ trans('home.Nội dung') }}</th>
                        <th class="text-nowrap">{{ trans('home.Đánh giá') }}</th>
                        <th class="text-nowrap">{{ trans('home.Tình trạng') }}</th>
                        <th class="text-nowrap">{{ trans('home.Ngày nhận xét') }}</th>
                        <th width="8%" class="text-nowrap">{{ trans('home.Chức năng') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @if($collections->count() === 0)
                        <tr>
                            <td colspan="7"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                        </tr>
                    @endif
                    @foreach($collections as $comment)
                    <tr>
                        <td class="text-center">{{ $comment->id }}</td>
                        <td class="text-nowrap">
                            @switch($comment->rate)
                                @case(1)
                                    <span class="ml-3 h5">{{ trans('home.Rất không hài lòng') }}</span>
                                    @break
                                @case(2)
                                    <span class="ml-3 h5">{{ trans('home.Không hài lòng') }}</span>
                                    @break
                                @case(3)
                                    <span class="ml-3 h5">{{ trans('home.Bình thường') }}</span>
                                    @break
                                @case(4)
                                    <span class="ml-3 h5">{{ trans('home.Hài lòng') }}</span>
                                    @break
                                @default
                                    <span class="ml-3 h5">{{ trans('home.Rất hài lòng') }}</span>
                            @endswitch
                        </td>
                        <td class="text-nowrap" style="white-space: normal; text-align: justify;">{{ $comment->content }}</td>

                        <td class="text-nowrap text-center">{{ $comment->rate }} {{ trans('home.Sao') }}</td>
                        <td class="text-nowrap text-center">
                            @switch($comment->status)
                                @case(1)
                                    <span class="alert alert-success">{{ trans('home.Đã xác nhận') }}</span>
                                    @break
                                @case(2)
                                    <span class="alert alert-danger">{{ trans('home.Bỏ qua') }}</span>
                                    @break
                                @default
                                    <span class="alert alert-info">{{ trans('home.Chưa xác nhận') }}</span>
                            @endswitch
                        </td>
                        <td class="text-nowrap text-center">{{ $comment->created_at }}</td>
                        <td class="text-center">
                            @switch($comment->status)
                                @case(1)
                                    <a href="{{ route('contentReplyCmt', ['id' => $comment->id ]) }}" title="Trả lời"><i class="fas fa-reply"></i></a>

                                    <a href="{{ route('comments-skip', ['id' => $comment->id]) }}" title="Bỏ qua"><i class="fa fa-times-circle" aria-hidden="true"></i></a>

                                    <a href="javascript:void(0)" data-id="{{ $comment->id }}" class="btn-delete" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    <form name="form-delete-{{ $comment->id }}" method="post" action="{{ route('comments-delete', ['id' => $comment->id]) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                    </form>
                                    @break
                                @case(2)
                                    <a href="{{ route('comments-confirm', ['id' => $comment->id]) }}" title="Xác nhận"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>

                                    <a href="javascript:void(0)" data-id="{{ $comment->id }}" class="btn-delete" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    <form name="form-delete-{{ $comment->id }}" method="post" action="{{ route('comments-delete', ['id' => $comment->id]) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                    </form>
                                    @break
                                @default
                                    <a href="{{ route('comments-confirm', ['id' => $comment->id]) }}" title="Xác nhận"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>

                                    <a href="{{ route('comments-skip', ['id' => $comment->id]) }}" title="Bỏ qua"><i class="fa fa-times-circle" aria-hidden="true"></i></a>

                                    <a href="javascript:void(0)" data-id="{{ $comment->id }}" class="btn-delete" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    <form name="form-delete-{{ $comment->id }}" method="post" action="{{ route('comments-delete', ['id' => $comment->id]) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                    </form>
                            @endswitch
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
@include('product-manage.comment.partials.script')
@endsection
