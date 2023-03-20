@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@section('content')

<form role="form" action="{{ route('answer_commentCmt') }}" method="post">
    <div class="row">
        @include('product-manage.comment.reply')
        <div class="col-md-8">
            <div class="box box-primary">   
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Nội dung nhận xét') }}</h3>
                </div>             
                <div class="box-body">
                    <input type="text" hidden="true" name="comment_id" value="{{ $comments->id }}">
                    <p class="comments-index text-justify">
                        {{ $comments->content }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary box-control">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ trans('home.Chức năng') }}</h2> 
                </div>
                <div class="box-body">
                    <div class="btn-group">
                        <button type="button" data-toggle="modal" data-target="#modalAnswer" class="btn btn-primary btn-save" tabindex="7">
                            <img src="{{ asset('img/icon-save.png') }}" alt="">
                            <span><b>{{ trans('home.Trả lời') }}</b></span>
                        </button>
                        <a href="{{ route('comments-index') }}" class="btn btn-default btn-cancel" tabindex="8">
                            <img src="{{ asset('img/icon-cancel.png') }}" alt="">
                            <span><b>Thoát</b></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="box box-table">
                <div class="box-header">
                    <h3 class="box-title">{{ trans('home.Danh sách câu trả lời') }}</h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">{{ trans('home.STT') }}</th>
                                <th class="text-nowrap">{{ trans('home.Tên người dùng') }}</th>
                                <th class="text-nowrap text-left" width="40%">{{ trans('home.Nội dung câu trả lời') }}</th>
                                <th class="text-nowrap">{{ trans('home.Tình trạng') }}</th>
                                <th class="text-nowrap">{{ trans('home.Ngày trả lời') }}</th>
                                <th class="text-nowrap">{{ trans('home.Chức năng') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($comments->answer_comments->count() === 0)
                                <tr>
                                    <td colspan="6"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                                </tr>
                            @endif
                            
                            @foreach($comments->answer_comments as $answer_comment)
                            <tr>
                                <td class="text-nowrap text-center">01</td>
                                <td class="text-nowrap text-center">{{ $answer_comment->customer['fullname'] == null ? "Rbooks" : $answer_comment->customer['fullname'] }}</td>
                                <td class="text-nowrap text-justify">{{ $answer_comment->answer_cmt }}</td>
                                <td class="text-nowrap text-center">
                                    @switch($answer_comment->status)
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
                                <td class="text-nowrap text-center">{{ $answer_comment->created_at }}</td>
                                <td class="text-nowrap text-center">
                                @switch($answer_comment->status)
                                    @case(1)
                                        <a href="{{ route('answer_comment-skip', ['id' => $answer_comment->id]) }}" title="Bỏ qua"><i class="fa fa-times-circle" aria-hidden="true"></i></a>

                                        <a href="javascript:void(0)" data-id="{{ $answer_comment->id }}" class="btn-delete" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        <form name="form-delete-{{ $answer_comment->id }}" method="post" action="{{ route('answer_comment-delete', ['id' => $answer_comment->id]) }}">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                        </form>
                                        @break
                                    @case(2)
                                        <a href="{{ route('answer_comment-confirm', ['id' => $answer_comment->id]) }}" title="Duyệt"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>

                                        <a href="javascript:void(0)" data-id="{{ $answer_comment->id }}" class="btn-delete" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        <form name="form-delete-{{ $answer_comment->id }}" method="post" action="{{ route('answer_comment-delete', ['id' => $answer_comment->id]) }}">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                        </form>
                                        @break
                                    @default
                                        <a href="{{ route('answer_comment-confirm', ['id' => $answer_comment->id]) }}" title="Xác nhận"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>

                                        <a href="{{ route('answer_comment-skip', ['id' => $answer_comment->id]) }}" title="Bỏ qua"><i class="fa fa-times-circle" aria-hidden="true"></i></a>

                                        <a href="javascript:void(0)" data-id="{{ $answer_comment->id }}" class="btn-delete" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        <form name="form-delete-{{ $answer_comment->id }}" method="post" action="{{ route('answer_comment-delete', ['id' => $answer_comment->id]) }}">
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
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
@include('product-manage.comment.partials.script')
@endsection