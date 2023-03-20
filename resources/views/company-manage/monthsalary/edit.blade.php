@extends('layouts.master')

@section('head')
@endsection

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<form role="form" action="{{ route('monthsalarys-update', ['id' => $model->id]) }}?continue=false" method="post" id="frm">
{{ csrf_field() }}
{{ method_field('put') }}
<input type='hidden' name='typereport' value=''>
<input type='hidden' name='month' value='{{ $model->month }}'>
<input type='hidden' name='year' value='{{ $model->year }}'>
<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('home.Thông tin bảng lương') }}</h3>
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
                            <label>{{ trans('home.Tiền lương theo công việc') }}: </label>
                            <input type="text" class="form-control" name="worksalary" value="{{ formatNumber($model->worksalary, 1, 0, 0) }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.Số ngày tính lương trong tháng') }} <small class="text-danger text"> (*)</small>: </label>
                            <input type="text" class="form-control" name="numworkday_salary" onkeyup='this.value=formatNumberDecimal(this.value)' value="{{ formatNumber($model->numworkday_salary, 1, 1, 0) }}">
                            @if($errors->has('numworkday_salary'))<span class="text-danger">{{ $errors->first('numworkday_salary') }}</span>@endif
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.Số ngày làm việc thực tế') }} <small class="text-danger text"> (*)</small>: </label>
                            <input type="text" class="form-control" name="numworkday" onkeyup='this.value=formatNumberDecimal(this.value)' value="{{ formatNumber($model->numworkday, 1, 1, 0) }}">
                            @if($errors->has('numworkday'))<span class="text-danger">{{ $errors->first('numworkday') }}</span>@endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.Lương tháng') }} <small class="text-danger text"> (*)</small>: </label>
                            <input type="text" class="form-control" name="totalsalary" onkeyup='this.value=formatNumberDecimal(this.value)' value="{{ formatNumber($model->totalsalary, 1, 0, 0) }}">
                            @if($errors->has('totalsalary'))<span class="text-danger">{{ $errors->first('totalsalary') }}</span>@endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.BHXH') }} : </label>
                            <input type="text" class="form-control" name="bhxh" value="{{ formatNumber($model->bhxh, 1, 0, 0) }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.BHTNLD_BNN') }} : </label>
                            <input type="text" class="form-control" name="bhtnld_bnn" value="{{ formatNumber($model->bhtnld_bnn, 1, 0, 0) }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.BHYT') }} : </label>
                            <input type="text" class="form-control" name="bhyt" value="{{ formatNumber($model->bhyt, 1, 0, 0) }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.BHTN') }} : </label>
                            <input type="text" class="form-control" name="bhtn" value="{{ formatNumber($model->bhtn, 1, 0, 0) }}" readonly>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.Lương thực lĩnh') }} <small class="text-danger text"> (*)</small>: </label>
                            <input type="text" class="form-control" name="luongthuclinh" onkeyup='this.value=formatNumberDecimal(this.value)' value="{{ formatNumber($model->luongthuclinh, 1, 0, 0) }}">
                            @if($errors->has('luongthuclinh'))<span class="text-danger">{{ $errors->first('luongthuclinh') }}</span>@endif
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.Các loại phụ cấp') }} <small class="text-danger text"> (*)</small>: </label>
                            <input type="text" class="form-control" name="phucap" onkeyup='this.value=formatNumberDecimal(this.value)' value="{{ formatNumber($model->phucap, 1, 0, 0) }}">
                            @if($errors->has('phucap'))<span class="text-danger">{{ $errors->first('phucap') }}</span>@endif
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ trans('home.Lương được lĩnh chưa trích thuế TNCN') }} <small class="text-danger text"> (*)</small>: </label>
                            <input type="text" class="form-control" name="thucnhankynay" onkeyup='this.value=formatNumberDecimal(this.value)' value="{{ formatNumber($model->thucnhankynay, 1, 0, 0) }}">
                            @if($errors->has('thucnhankynay'))<span class="text-danger">{{ $errors->first('thucnhankynay') }}</span>@endif
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
