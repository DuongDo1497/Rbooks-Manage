@extends('layouts.master')

@section('head')
@endsection

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<form role="form" action="{{ route('monthinsurances-update', ['id' => $model->id]) }}?continue=false" method="post" id="frm">
{{ csrf_field() }}
{{ method_field('put') }}
<input type='hidden' name='typereport' value=''>
<input type='hidden' name='month' value='{{ $model->month }}'>
<input type='hidden' name='year' value='{{ $model->year }}'>
<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('home.Thông tin đóng Bảo hiểm xã hội') }}</h3>
            </div>
            
                <div class="box-body">
                    <div class="about about-1 clearfix">
                        <div class="about-item">
                            <span>{{ trans('home.Nhân viên') }}:</span>
                            <span><b>{{ $employee_name }}</b></span>
                        </div>
                    </div>
                    <div class="about about-2">
                        <div class="about-item">
                            <span>{{ trans('home.Chức vụ') }}:</span>
                            <span><b>{{ $position_name }}</b></span>
                        </div>
                    </div>
                    <div class="about about-3">
                        <div class="about-item">
                            <span>{{ trans('home.Phòng ban') }}:</span>
                            <span><b>{{ $department_name }}</b></span>
                        </div>
                    </div>
                </div>       
                 

                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.BHXH do Công ty đóng') }} <small class="text-danger text"> (*)</small>: </label>
                            <input type="text" class="form-control" name="bhxh_cn" onkeyup='this.value=formatNumberDecimal(this.value)' value="{{ formatNumber($model->bhxh_cn, 1, 0, 0) }}">
                            @if($errors->has('bhxh_cn'))<span class="text-danger">{{ $errors->first('bhxh_cn') }}</span>@endif
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.BHXH do NLĐ đóng') }} <small class="text-danger text"> (*)</small>: </label>
                            <input type="text" class="form-control" name="bhxh" onkeyup='this.value=formatNumberDecimal(this.value)' value="{{ formatNumber($model->bhxh, 1, 0, 0) }}">
                            @if($errors->has('bhxh'))<span class="text-danger">{{ $errors->first('bhxh') }}</span>@endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.BHTNLD_BNN do Công ty đóng') }} <small class="text-danger text"> (*)</small>: </label>
                            <input type="text" class="form-control" name="bhtnld_bnn_cn" onkeyup='this.value=formatNumberDecimal(this.value)' value="{{ formatNumber($model->bhtnld_bnn_cn, 1, 0, 0) }}">
                            @if($errors->has('bhtnld_bnn_cn'))<span class="text-danger">{{ $errors->first('bhtnld_bnn_cn') }}</span>@endif
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.BHTNLD_BNN do NLĐ đóng') }} <small class="text-danger text"> (*)</small>: </label>
                            <input type="text" class="form-control" name="bhtnld_bnn" onkeyup='this.value=formatNumberDecimal(this.value)' value="{{ formatNumber($model->bhtnld_bnn, 1, 0, 0) }}">
                            @if($errors->has('bhtnld_bnn'))<span class="text-danger">{{ $errors->first('bhtnld_bnn') }}</span>@endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.BHYT do Công ty đóng') }} <small class="text-danger text"> (*)</small>: </label>
                            <input type="text" class="form-control" name="bhyt_cn" onkeyup='this.value=formatNumberDecimal(this.value)' value="{{ formatNumber($model->bhyt_cn, 1, 0, 0) }}">
                            @if($errors->has('bhyt_cn'))<span class="text-danger">{{ $errors->first('bhyt_cn') }}</span>@endif
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.BHYT do NLĐ đóng') }} <small class="text-danger text"> (*)</small>: </label>
                            <input type="text" class="form-control" name="bhyt" onkeyup='this.value=formatNumberDecimal(this.value)' value="{{ formatNumber($model->bhyt, 1, 0, 0) }}">
                            @if($errors->has('bhyt'))<span class="text-danger">{{ $errors->first('bhyt') }}</span>@endif
                        </div>
                    </div>
                    
                     <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.BHTN do Công ty đóng') }} <small class="text-danger text"> (*)</small>: </label>
                            <input type="text" class="form-control" name="bhtn_cn" onkeyup='this.value=formatNumberDecimal(this.value)' value="{{ formatNumber($model->bhtn_cn, 1, 0, 0) }}">
                            @if($errors->has('bhtn_cn'))<span class="text-danger">{{ $errors->first('bhtn_cn') }}</span>@endif
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.BHTN do NLĐ đóng') }} <small class="text-danger text"> (*)</small>: </label>
                            <input type="text" class="form-control" name="bhtn" onkeyup='this.value=formatNumberDecimal(this.value)' value="{{ formatNumber($model->bhtn, 1, 0, 0) }}">
                            @if($errors->has('bhtn'))<span class="text-danger">{{ $errors->first('bhtn') }}</span>@endif
                        </div>
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
                <button class="btn btn-primary btn-save" tabindex="5" onclick="processReports('frm', 'update')">{{ trans('home.Lưu') }}</button>
                <button class="btn btn-primary btn-cancel" tabindex="6" onclick="processReports('frm', 'view')">{{ trans('home.Trở về') }}</button>                
                               
            </div>
        </div>
    </div>
</div>
</form>  

@endsection
