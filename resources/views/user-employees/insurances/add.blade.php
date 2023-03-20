@extends('layouts.master')

@section('head')
@endsection

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('home.Thông tin đóng Bảo hiểm xã hội') }}</h3>
            </div>
            <form role="form" action="{{ route('insurances-store') }}?index=true" method="post" id="frm">
                {{ csrf_field() }}
                <input type="hidden" name="employeeid"  value="{{ $employeeid }}">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.Mức lương đóng BHXH') }} <small class="text-danger text"> (*)</small>: </label>
                            <input type="text" class="form-control" name="salaryinsurance" onkeyup='this.value=formatNumberDecimal(this.value)' value="{{ old('salaryinsurance') }}">
                            @if($errors->has('salaryinsurance'))<span class="text-danger">{{ $errors->first('salaryinsurance') }}</span>@endif
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.Phụ cấp đóng BHXH') }}: </label>
                            <input type="text" class="form-control" name="extrainsurance" onkeyup='this.value=formatNumberDecimal(this.value)' value="{{ old('extrainsurance') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Ngày bắt đầu hiệu lực') }} <small class="text-danger text"> (*)</small>: </label>
                        <input type="date" class="form-control" name="effectdate" value="{{ old('effectdate') }}">
                        @if($errors->has('effectdate'))<span class="text-danger">{{ $errors->first('effectdate') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Ghi chú') }}: </label>
                        <textarea class="form-control" name="description" rows="2">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Kích hoạt') }}:</label>
                        <input type="checkbox" tabindex="4" name="active" value="1" id="chk-active" {{ old( 'active')==1 ? 'checked="checked"' : '' }}> <br>(<font size='1'><u>{{ trans('home.Ghi chú') }}:</u> {{ trans('home.chỉ có 1 mức lương đóng BHXH được kích hoạt ở cùng thời điểm') }}.</font>)
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
                <a href="{{ route('insurances-index', ['employeeid' => $employeeid]) }}" class="btn btn-default btn-cancel" tabindex="6">{{ trans('home.Trở về') }}</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@include('user-employees.insurances.partials.script')
@endsection