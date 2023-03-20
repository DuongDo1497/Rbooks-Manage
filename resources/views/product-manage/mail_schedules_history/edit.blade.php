@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <form role="form" action="{{ route('mail_schedules-update', ['id' => $model->id]) }}?continue=true" method="post" id="mail_schedules-form">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Chỉnh sửa lịch gửi thư</h3>
                </div>
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="box-body">
                    <div class="form-group{{ ($errors->has('fullname')) ? ' has-error' : '' }}">
                        <label>{{ trans('home.Họ tên khách hàng') }}</label>
                        <input type="text" class="form-control" value="{{ $model->fullname }}" name="fullname">
                        @if($errors->has('fullname'))<span class="help-block">{{ $errors->first('fullname') }}</span>@endif
                    </div>
                    <div class="form-group{{ ($errors->has('email')) ? ' has-error' : '' }}">
                        <label>{{ trans('home.Email') }}</label>
                        <input type="email" class="form-control" value="{{ $model->email }}" name="email">
                        @if($errors->has('email'))<span class="help-block">{{ $errors->first('email') }}</span>@endif
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <label>{{ trans('home.Số điện thoại') }}</label>
                        <input type="text" class="form-control" value="{{ $model->phone }}" name="phone">
                        @if($errors->has('phone'))<span class="text-danger">{{ $errors->first('phone') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Ghi chú') }}</label>
                        <textarea class="form-control" rows="4" name="note">{{ $model->note }}</textarea>
                        @if($errors->has('note'))<span class="text-danger">{{ $errors->first('note') }}</span>@endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Chức năng') }}</h3>
                </div>
                <div class="box-body">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary btn-save" tabindex="7">
                            <img src="{{ asset('img/icon-save.png') }}" alt="">
                            <span><b>{{ trans('home.Lưu') }}</b></span>
                        </button>
                        <a href="{{ route('mail_schedules-index') }}" class="btn btn-default btn-cancel" tabindex="8">
                            <img src="{{ asset('img/icon-cancel.png') }}" alt="">
                            <span><b>Thoát</b></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#mail_schedules-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#mail_schedules-form').attr('action', '');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#mail_schedules-form').attr('action', '');
        });
    });
</script>
@endsection
