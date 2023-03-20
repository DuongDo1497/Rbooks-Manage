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
                <h3 class="box-title">{{ trans('home.Thông tin quá trình đào tạo') }}</h3>
            </div>
            <form role="form" action="{{ route('educations-update', ['id' => $model->id]) }}?continue=false" method="post" id="frm">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <input type="hidden" name="employeeid"  value="{{ $employeeid }}">                
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Ngày bắt đầu') }} <small class="text-danger text"> (*)</small>: </label>
                                <input type="date" class="form-control" name="fromdate" value="{{ $model->fromdate }}">
                                @if($errors->has('fromdate'))<span class="text-danger">{{ $errors->first('fromdate') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Ngày kết thúc') }} : </label>
                                <input type="date" class="form-control" name="todate" value="{{ $model->todate }}">
                                @if($errors->has('todate'))<span class="text-danger">{{ $errors->first('todate') }}</span>@endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Trường / Trung tâm') }} :</label>
                        <input type="text" class="form-control" name="schoolname" value="{{ $model->schoolname }}">
                        @if($errors->has('schoolname'))<span class="text-danger">{{ $errors->first('schoolname') }}</span>@endif                        
                    </div>                      
                    <div class="form-group">
                         <label>{{ trans('home.Bằng cấp') }} : </label>
                        <select class="form-control select2" name="level">
                            <option value="">{{ trans('home.Chọn') }}</option>
                            @foreach($educationtype as $key=>$value)
                                @if($key == $model->level)
                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>                                                                    
                                @endif
                            @endforeach
                        </select>
                        @if($errors->has('level'))<span class="text-danger">{{ $errors->first('level') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Chuyên ngành') }} :</label>
                        <input type="text" class="form-control" name="major" value="{{ $model->major }}">
                    </div>                                           
                    <div class="form-group">
                        <label>{{ trans('home.Mô tả') }}: </label>
                        <textarea class="form-control" name="description" rows="2">{{ $model->description }}</textarea>
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
                <a href="{{ route('educations-index', ['employeeid' => $employeeid]) }}" class="btn btn-default btn-cancel" tabindex="6">{{ trans('home.Trở về') }}</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@include('user-employees.education.partials.script')
@endsection