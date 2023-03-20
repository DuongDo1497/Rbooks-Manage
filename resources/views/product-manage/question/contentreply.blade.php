@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@section('content')

<form role="form" action="{{ route('answer') }}" method="post">
	<div class="row">
        @include('product-manage.question.reply')
		<div class="col-md-8">
			<div class="box box-primary">   
                <div class="box-header with-border">
                    <h2 class="box-title">{{ trans('home.Câu hỏi') }}</h2> 
                </div>             
                <div class="box-body">
                    <input type="text" hidden="true" name="question_id" value="{{ $questions->id }}">
                	<div style="margin-bottom: 20px;">{{ $questions->question }}</div>
                </div>
			</div>
		</div>
		<div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ trans('home.Chức năng') }}</h2> 
                </div>
                <div class="box-body">
                    <button type="button" data-toggle="modal" data-target="#modalAnswer" class="btn btn-primary btn-save" tabindex="5">{{ trans('home.Trả lời') }}</button>
                    <a href="{{ route('question-index') }}" class="btn btn-default btn-cancel" tabindex="6">{{ trans('home.Trở về') }}</a>
                </div>
            </div>
		</div>

		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Danh sách câu trả lời') }}</h3>
                </div>
                <div class="box-body no-padding">
                	<table class="table table-hover">
	                    <thead>
	                        <tr>
	                            <th width="1%">
	                                <label>
	                                    <input type="checkbox" class="minimal checkbox-all">
	                                </label>
	                            </th>
	                            <th>#</th>
	                            <th class="text-nowrap">{{ trans('home.Tên người dùng') }}</th>
	                            <th class="text-nowrap" width="40%">{{ trans('home.Nội dung câu trả lời') }}</th>
	                            <th class="text-nowrap">{{ trans('home.Tình trạng') }}</th>
	                            <th class="text-nowrap">{{ trans('home.Ngày trả lời') }}</th>
	                            <th class="text-nowrap">
	                                <span class="lbl-action">{{ trans('home.Chức năng') }}</span>
	                                <button class="btn btn-danger btn-xs btn-block hide btn-delete-selected">{{ trans('home.Xóa') }} <span class="lbl-selected-rows-count">0</span> {{ trans('home.đã chọn') }}</button>
	                            </th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    @if($questions->answers->count() === 0)
	                        <tr>
	                            <td colspan="8"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
	                        </tr>
                        @endif
                        @foreach($questions->answers as $answer)
                            <tr>
                                <td>
                                    <label>
                                        <input type="checkbox" class="minimal checkbox-item">
                                    </label>
                                </td>
                                <td>{{ $answer->id }}</td>
                                
                                <td class="text-nowrap" style="white-space: normal; text-align: justify;">{{ $answer->customer['fullname'] == null ? "Admin" : $answer->customer['fullname'] }}</td>
                                <td class="text-nowrap" style="white-space: normal; text-align: justify;">{{ $answer->answer }}</td>
                                <td class="text-nowrap">
                                    @switch($answer->status)
                                        @case(1)
                                            <span class="alert-success">{{ trans('home.Đã duyệt') }}</span>
                                            @break
                                        @case(2)
                                            <span class="alert-danger">{{ trans('home.Bỏ qua') }}</span>
                                            @break
                                        @default
                                            <span class="alert-info">{{ trans('home.Chưa duyệt') }}</span>
                                    @endswitch
                                </td>
                                <td class="text-nowrap">{{ $answer->created_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{ trans('home.Thao tác') }} <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            @switch($answer->status)
                                                @case(1)
                                                    <li><a href="{{ route('answer-skip', ['id' => $answer->id]) }}"><i class="fas fa-forward"></i> {{ trans('home.Bỏ qua') }}</a></li>
                                                    <li>
                                                        <a href="javascript:void(0)" data-id="{{ $answer->id }}" class="btn-delete"><i class="fa fa-trash"></i> {{ trans('home.Xóa') }}</a>
                                                        <form name="form-delete-{{ $answer->id }}" method="post" action="{{ route('answer-delete', ['id' => $answer->id]) }}">
                                                            {{ csrf_field() }}
                                                            {{ method_field('delete') }}
                                                        </form>
                                                    </li>
                                                    @break
                                                @case(2)
                                                    <li><a href="{{ route('answer-confirm', ['id' => $answer->id]) }}"><i class="fas fa-check-circle"></i> {{ trans('home.Duyệt') }}</a></li>
                                                    <li>
                                                        <a href="javascript:void(0)" data-id="{{ $answer->id }}" class="btn-delete"><i class="fa fa-trash"></i> {{ trans('home.Xóa') }}</a>
                                                        <form name="form-delete-{{ $answer->id }}" method="post" action="{{ route('answer-delete', ['id' => $answer->id]) }}">
                                                            {{ csrf_field() }}
                                                            {{ method_field('delete') }}
                                                        </form>
                                                    </li>
                                                    @break
                                                @default
                                                    <li><a href="{{ route('answer-confirm', ['id' => $answer->id]) }}"><i class="fas fa-check-circle"></i> {{ trans('home.Xác nhận') }}</a></li>
                                                    <li><a href="{{ route('answer-skip', ['id' => $answer->id]) }}"><i class="fas fa-forward"></i> {{ trans('home.Bỏ qua') }}</a></li>
                                                    <li>
                                                        <a href="javascript:void(0)" data-id="{{ $answer->id }}" class="btn-delete"><i class="fa fa-trash"></i> {{ trans('home.Xóa') }}</a>
                                                        <form name="form-delete-{{ $answer->id }}" method="post" action="{{ route('answer-delete', ['id' => $answer->id]) }}">
                                                            {{ csrf_field() }}
                                                            {{ method_field('delete') }}
                                                        </form>
                                                    </li>
                                            @endswitch
                                        </ul>
                                    </div>
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
@include('product-manage.supplier.partials.script')
@endsection