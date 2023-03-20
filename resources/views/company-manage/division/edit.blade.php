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
    <form role="form" action="{{ route('divisions-update', ['id' => $division->id]) }}?continue=true" method="post" id="division-form">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Chỉnh sửa bộ phận') }}</h3>
                </div>
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="box-body">
                    <div class="form-group{{ ($errors->has('code_division')) ? ' has-error' : '' }}">
                        <label>{{ trans('home.Mã bộ phận') }}</label>
                        <input type="text" class="form-control" placeholder="{{ $division->code_division }}" name="code_division" value="{{ $division->code_division }}" tabindex="1">
                        @if($errors->has('code_division'))<span class="help-block">{{ $errors->first('code_division') }}</span>@endif
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <label>{{ trans('home.Tên bộ phận') }}</label>
                        <input type="text" class="form-control" placeholder="{{ $division->name }}" name="name" value="{{ $division->name }}" tabindex="6">
                        @if($errors->has('name'))<span class="text-danger">{{ $errors->first('name') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Phòng ban') }}</label>
                        <select class="form-control select2" name="department_id">
                            <option value="{{ $division->department == Null ? 0 : $division->department->id }}">{{ $division->department == Null ? '' : $division->department->name }}</option>
                            @foreach($departments->where('id', '<>', $division->department == Null ? 0 : $division->department->id) as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
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
                    <a href="{{ route('divisions-index') }}" class="btn btn-default btn-cancel" tabindex="10">{{ trans('home.Trở về') }}</a>
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
            $('#division-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#division-form').attr('action', '{{ route('divisions-edit', ['id' => $division->id]) }}?continue=true');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#division-form').attr('action', '{{ route('divisions-edit', ['id' => $division->id]) }}');
        });
    });
</script>
@endsection
