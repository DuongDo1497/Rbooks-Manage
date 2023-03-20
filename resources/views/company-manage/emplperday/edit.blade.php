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
    <form role="form" action="{{ route('emplperdays-update', ['id' => $emplperday->id]) }}?continue=true" method="post" id="emplperdays-form">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Chỉnh sửa đăng kí ngày nghỉ') }}</h3>
                </div>
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="box-body">
                    <div class="form-group">
                		<label>{{ trans('home.Họ tên') }}</label>
                        <select class="form-control select2" name="employee_id">
                            <option value="{{ $emplperday->employee_id }}">{{ $emplperday->employee->fullname }}</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Phép tồn năm trước') }}</label>
                        <input type="number" class="form-control" step="0.01" name="permission_lastyear" value="{{ $emplperday->permission_lastyear }}">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Phép được hưởng') }}</label>
                        <input type="number" class="form-control" step="0.01" name="permission_curryear" value="{{ $emplperday->permission_curryear }}">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Phép đã nghỉ') }}</label>
                        <input type="number" class="form-control" step="0.01" name="permission_leave" value="{{ $emplperday->permission_leave }}">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Phép còn lại') }}</label>
                        <input type="number" class="form-control" step="0.01" name="permission_left" value="{{ $emplperday->permission_left }}">
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
                    <a href="{{ route('emplperdays-index') }}" class="btn btn-default btn-cancel" tabindex="10">{{ trans('home.Trở về') }}</a>
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
            $('#emplperdays-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#emplperdays-form').attr('action', '');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#emplperdays-form').attr('action', '');
        });
    });
</script>
@endsection
