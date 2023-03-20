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
                <h3 class="box-title">{{ trans('home.Thông tin quá trình công tác nhân viên') }}</h3>
            </div>
            <form role="form" action="{{ route('historyworks-update', ['id' => $model->id]) }}?continue=false" method="post" id="frm">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <input type="hidden" name="employeeid"  value="{{ $employeeid }}">                
                <div class="box-body">
                    <div class="form-group">
                        <label>{{ trans('home.Phòng ban') }} <small class="text-danger text"> (*)</small>: </label>
                        <select class="form-control select2" name="department_id">
                            @foreach($departments as $item)
                                @if($item->id == $model->department_id)
                                    <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                @else
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>                                                                    
                                @endif
                            @endforeach
                        </select>
                        @if($errors->has('department_id'))<span class="text-danger">{{ $errors->first('department_id') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Chức vụ') }} <small class="text-danger text"> (*)</small>: </label>
                        <select class="form-control select2" name="position_id">
                            @foreach($positions as $item)
                                @if($item->id == $model->position_id)
                                    <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                @else
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>                                                                    
                                @endif
                            @endforeach
                        </select>
                        @if($errors->has('position_id'))<span class="text-danger">{{ $errors->first('position_id') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Số tháng đã làm') }} <small class="text-danger text"> (*)</small>: </label>
                        <input type="text" class="form-control" name="nummonths" value="{{ $model->nummonths }}">
                        @if($errors->has('nummonths'))<span class="text-danger">{{ $errors->first('nummonths') }}</span>@endif
                    </div>
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
                        <label>{{ trans('home.Mô tả công việc') }}: </label>
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
                <a href="{{ route('historyworks-index', ['employeeid' => $employeeid]) }}" class="btn btn-default btn-cancel" tabindex="6">{{ trans('home.Trở về') }}</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@include('user-employees.historywork.partials.script')
@endsection