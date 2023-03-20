@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<div class="row">
    <form role="form" action="{{ route('positions-update', ['id' => $position->id]) }}?continue=true" method="post" id="position-form">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Chỉnh sửa chức vụ') }}</h3>
                </div>
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="box-body">
                    <div class="form-group{{ ($errors->has('code_position')) ? ' has-error' : '' }}">
                        <label>{{ trans('home.Mã chức vụ') }}</label>
                        <input type="text" class="form-control" placeholder="{{ $position->code_position }}" name="code_position" value="{{ $position->code_position }}" tabindex="1">
                        @if($errors->has('code_position'))<span class="help-block">{{ $errors->first('code_position') }}</span>@endif
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <label>{{ trans('home.Chức vụ') }}</label>
                        <input type="text" class="form-control" placeholder="{{ $position->name }}" name="name" value="{{ $position->name }}" tabindex="6">
                        @if($errors->has('name'))<span class="text-danger">{{ $errors->first('name') }}</span>@endif
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
                    <button type="submit" class="btn btn-primary btn-save" tabindex="9">{{ trans('home.Lưu') }}</button>
                    <a href="{{ route('positions-index') }}" class="btn btn-default btn-cancel" tabindex="10">{{ trans('home.Trở về') }}</a>
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
            $('#position-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#position-form').attr('action', '{{ route('positions-edit', ['id' => $position->id]) }}?continue=true');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#position-form').attr('action', '{{ route('positions-edit', ['id' => $position->id]) }}');
        });
    });
</script>
@endsection
