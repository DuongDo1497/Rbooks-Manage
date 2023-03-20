@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('home.Thông tin lương & phụ cấp') }}</h3>
            </div>
            <form role="form" action="{{ route('payrolls-update', ['id' => $model->id]) }}?continue=false" method="post" id="frm">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <input type="hidden" name="employeeid"  value="{{ $employeeid }}">                
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.Lương công việc') }} <small class="text-danger text"> (*)</small>: </label>
                            <input type="text" class="form-control" name="worksalary" onkeyup='this.value=formatNumberDecimal(this.value)' value="{{ formatNumber($model->worksalary, 1, 0, 0) }}">
                            @if($errors->has('worksalary'))<span class="text-danger">{{ $errors->first('worksalary') }}</span>@endif
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.Phụ cấp') }}: </label>
                            <input type="text" class="form-control" name="extrasalary" onkeyup='this.value=formatNumberDecimal(this.value)' value="{{ formatNumber($model->extrasalary, 1, 0, 0) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Ngày bắt đầu hiệu lực') }} <small class="text-danger text"> (*)</small>: </label>
                        <input type="date" class="form-control" name="effectdate" value="{{ $model->effectdate }}">
                        @if($errors->has('effectdate'))<span class="text-danger">{{ $errors->first('effectdate') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Ghi chú') }}: </label>
                        <textarea class="form-control" name="description" rows="2">{{ $model->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Kích hoạt') }}:</label>
                        <input type="checkbox" tabindex="4" name="active" value="1" id="chk-active" {{ $model->active==1 ? 'checked="checked"' : '' }}> <br>(<font size='1'><u>{{ trans('home.Ghi chú') }}:</u> {{ trans('home.chỉ có 1 mức lương đóng BHXH được kích hoạt ở cùng thời điểm') }}.</font>)
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('home.Chức năng') }}</h3>
            </div>
            <div class="box-body">
                <button type="submit" class="btn btn-primary btn-save" tabindex="5">{{ trans('home.Lưu') }}</button>
                <a href="{{ route('payrolls-index', ['employeeid' => $employeeid]) }}" class="btn btn-default btn-cancel" tabindex="6">{{ trans('home.Trở về') }}</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@include('user-employees.payrolls.partials.script')
@endsection