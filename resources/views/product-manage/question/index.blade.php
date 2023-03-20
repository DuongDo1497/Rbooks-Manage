@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('product-manage.question.partials.search-form')
@include('product-manage.question.reply')
<div class="box box-table question">
    <div class="box-content">
        <div class="box-header">
            <h2 class="box-title">
                {{ trans('home.Danh sách hỏi, đáp') }}
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
                        <a href="#" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</a>
                        <a href="#" class="btn btn-default"><i class="fas fa-download" aria-hidden="true"></i> {{ trans('home.Xuất tất cả') }}</a>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> {{ trans('home.Hiển thị') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('question-index', filter_data($filter, 'limit', 10)) }}">10 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('question-index', filter_data($filter, 'limit', 25)) }}">25 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('question-index', filter_data($filter, 'limit', 50)) }}">50 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('question-index', filter_data($filter, 'limit', 100)) }}">100 {{ trans('home.dòng / trang') }}</a></li>
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-sort" aria-hidden="true"></i> {{ trans('home.Sắp xếp') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="{{ route('question-index', filter_data($filter, 'orderBy', 'id')) }}">{{ trans('home.Mã câu hỏi') }}</a></li>
                                <li><a href="{{ route('question-index', filter_data($filter, 'orderBy', 'name')) }}">{{ trans('home.Tên') }}</a></li>
                                <li><a href="{{ route('question-index', filter_data($filter, 'orderBy', 'created_at')) }}">{{ trans('home.Ngày khởi tạo') }}</a></li>
                                <li><a href="{{ route('question-index', filter_data($filter, 'orderBy', 'updated_at')) }}">{{ trans('home.Ngày chỉnh sửa') }}</a></li>
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
                                <li><a href="{{ route('question-index', filter_data($filter, 'sortedBy', 'desc')) }}"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}</a></li>
                                <li><a href="{{ route('question-index', filter_data($filter, 'sortedBy', 'asc')) }}"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center" width="1%">STT</th>
                        <th class="text-nowrap text-left">{{ trans('home.Tên sản phẩm') }}</th>
                        <th class="text-nowrap text-left" width="30%">{{ trans('home.Nội dung câu hỏi') }}</th>
                        <th class="text-nowrap">{{ trans('home.Độc giả') }}</th>
                        <th class="text-nowrap">{{ trans('home.Tình trạng') }}</th>
                        <th class="text-nowrap">{{ trans('home.Ngày đặt câu hỏi') }}</th>
                        <th width="8%" class="text-nowrap">{{ trans('home.Chức năng') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @if($collections->count() === 0)
                        <tr>
                            <td colspan="7"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                        </tr>
                    @endif
                    @foreach($collections as $question)
                    <tr>
                        <td class="text-center">{{ $question->id }}</td>
                        <td class="text-nowrap" style="white-space: normal; text-align: justify;">{{ $question->products['name'] }}</td>
                        <td class="text-nowrap" style="white-space: normal; text-align: justify;">{{ $question->question }}</td>
                        <td class="text-nowrap text-center">{{ $question->customers['fullname'] }}</td>
                        <td class="text-nowrap text-center">
                            @switch($question->status)
                                @case(1)
                                    <span class="alert alert-success">{{ trans('home.Đã duyệt') }}</span>
                                    @break
                                @case(2)
                                    <span class="alert alert-danger">{{ trans('home.Bỏ qua') }}</span>
                                    @break
                                @default
                                    <span class="alert alert-info">{{ trans('home.Chưa duyệt') }}</span>
                            @endswitch
                        </td>
                        <td class="text-nowrap text-center">{{ $question->created_at }}</td>
                        <td class="text-center">
                            @switch($question->status)
                                @case(1)
                                    <a href="{{ route('contentReply', ['id' => $question->id]) }}" title="Trả lời"><i class="fas fa-reply"></i></a>

                                    <a href="{{ route('question-skip', ['id' => $question->id]) }}" title="Bỏ qua"><i class="fa fa-times-circle" aria-hidden="true"></i></a>

                                    <a href="javascript:void(0)" data-id="{{ $question->id }}" class="btn-delete" title="Xóa"><i class="fa fa-trash"></i></a>
                                    <form name="form-delete-{{ $question->id }}" method="post" action="{{ route('question-delete', ['id' => $question->id]) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                    </form>
                                    @break
                                @case(2)
                                    <a href="{{ route('question-confirm', ['id' => $question->id]) }}" title="Duyệt"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>

                                    <a href="javascript:void(0)" data-id="{{ $question->id }}" class="btn-delete" title="Xóa"><i class="fa fa-trash"></i></a>
                                    <form name="form-delete-{{ $question->id }}" method="post" action="{{ route('question-delete', ['id' => $question->id]) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                    </form>
                                    @break
                                @default
                                    <a href="{{ route('question-confirm', ['id' => $question->id]) }}" title="Xác nhận"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>

                                    <a href="{{ route('question-skip', ['id' => $question->id]) }}" title="Bỏ qua"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                    
                                    <a href="javascript:void(0)" data-id="{{ $question->id }}" class="btn-delete" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    <form name="form-delete-{{ $question->id }}" method="post" action="{{ route('question-delete', ['id' => $question->id]) }}">
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
@include('product-manage.question.partials.script')
@endsection
