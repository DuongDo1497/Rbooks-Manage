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
                <h3 class="box-title">{{ trans('home.Thông tin khen thưởng / kỷ luật') }}</h3>
            </div>
            <form role="form" action="{{ route('disciplines-update', ['id' => $model->id]) }}?continue=false" method="post" id="frm">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <input type="hidden" name="employeeid"  value="{{ $employeeid }}">                
                <div class="box-body">
                    <div class="form-group">
                        <label>{{ trans('home.Ngày bắt đầu') }} <small class="text-danger text"> (*)</small>: </label>
                        <input type="date" class="form-control" name="fromdate" value="{{ $model->fromdate }}">
                        @if($errors->has('fromdate'))<span class="text-danger">{{ $errors->first('fromdate') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Loại') }} <small class="text-danger text"> (*)</small>:</label>
                        <select class="form-control select2" name="checktype_id">
                            @foreach($disciplinetype as $key=>$value)
                                @if($key == $model->checktype_id)
                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>                                                                    
                                @endif
                            @endforeach
                        </select>
                        @if($errors->has('checktype_id'))<span class="text-danger">{{ $errors->first('checktype_id') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Số quyết định') }} <small class="text-danger text"> (*)</small>:</label>
                        <input type="text" class="form-control" name="disciplinenumber" value="{{ $model->disciplinenumber }}">
                        @if($errors->has('disciplinenumber'))<span class="text-danger">{{ $errors->first('disciplinenumber') }}</span>@endif                        
                    </div>                      
                    <div class="form-group">
                        <label>{{ trans('home.Nội dung') }} <small class="text-danger text"> (*)</small>:</label>
                        <input type="text" class="form-control" name="contentdiscipline" value="{{ $model->contentdiscipline }}">
                        @if($errors->has('contentdiscipline'))<span class="text-danger">{{ $errors->first('contentdiscipline') }}</span>@endif                        
                    </div>                      
                    <div class="form-group">
                        <label>{{ trans('home.Hình thức') }} :</label>
                        <input type="text" class="form-control" name="formdiscipline" value="{{ $model->formdiscipline }}">
                    </div>                      
                    <div class="form-group">
                        <label>{{ trans('home.Mô tả') }} : </label>
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
                <a href="{{ route('disciplines-index', ['employeeid' => $employeeid]) }}" class="btn btn-default btn-cancel" tabindex="6">{{ trans('home.Trở về') }}</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@include('user-employees.discipline.partials.script')
@endsection