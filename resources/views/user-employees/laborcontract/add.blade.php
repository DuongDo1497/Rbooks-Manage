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
                <h3 class="box-title">{{ trans('home.Thông tin hợp đồng lao động') }}</h3>
            </div>
            <form role="form" action="{{ route('laborcontracts-store') }}?index=true" method="post" id="frm">
                {{ csrf_field() }}
                <input type="hidden" name="employeeid"  value="{{ $employeeid }}">                
                <div class="box-body">
                    <div class="form-group">
                        <label>{{ trans('home.Loại hợp đồng') }} <small class="text-danger text"> (*)</small>: </label>
                        <select class="form-control select2" name="labortype">
                            @foreach($labortype as $key=>$value)
                                @if($key == old('labortype'))
                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>                                                                    
                                @endif
                            @endforeach
                        </select>
                        @if($errors->has('labortype'))<span class="text-danger">{{ $errors->first('labortype') }}</span>@endif
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Ngày bắt đầu') }} <small class="text-danger text"> (*)</small>: </label>
                                <input type="date" class="form-control" name="fromdate" value="{{ old('fromdate') }}">
                                @if($errors->has('fromdate'))<span class="text-danger">{{ $errors->first('fromdate') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Ngày kết thúc') }} : </label>
                                <input type="date" class="form-control" name="todate" value="{{ old('todate') }}">
                                @if($errors->has('todate'))<span class="text-danger">{{ $errors->first('todate') }}</span>@endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>{{ trans('home.Ghi chú') }}: </label>
                        <textarea class="form-control" name="description" rows="2">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Kích hoạt') }}:</label>
                        <input type="checkbox" tabindex="4" name="active" value="1" id="chk-active" {{ old( 'active')==1 ? 'checked="checked"' : '' }}> <br>(<font size='1'><u>{{ trans('home.Ghi chú') }}:</u> {{ trans('home.chỉ có 1 loại HĐLĐ được kích hoạt ở cùng thời điểm') }}.</font>)
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
                <a href="{{ route('laborcontracts-index', ['employeeid' => $employeeid]) }}" class="btn btn-default btn-cancel" tabindex="6">{{ trans('home.Trở về') }}</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@include('user-employees.laborcontract.partials.script')
@endsection