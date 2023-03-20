@extends('layouts.master')

@section('content')
@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<div class="row">
    <form role="form" action="{{ route('checkbusiness-update', ['id' => $checkbusiness->id]) }}?continue=false" method="post" id="frm">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Chỉnh sửa đăng kí ngày công tác</h3>
                </div>
                {{ csrf_field() }}
                {{ method_field('put') }}
                <input type="hidden" name="employeeid"  value="{{ $employeeid }}">
                <div class="box-body">

                    <div class="form-group">
                        <label>Lý do công tác <small class="text-danger text"> (*)</small>:</label>
                        <select class="form-control select2" name="checktype_id" required>
                            <option value=""></option>
                            @foreach($checktypes->where('showtype', 2) as $checktype)
                                @if($checkbusiness->checktype_id == $checktype->id)
                                    <option value="{{ $checktype->id }}" selected>{{ $checktype->description }}</option>
                                @else
                                    <option value="{{ $checktype->id }}">{{ $checktype->description }}</option>
                                @endif
                            @endforeach
                            @if($errors->has('checktype_id'))<span class="text-danger">{{ $errors->first('checktype_id') }}</span>@endif
                        </select>
                    </div>
                    <div class="form-group from_start_box">
                        <label>Ngày bắt đầu <small class="text-danger text"> (*)</small>:</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="date" class="form-control fromdate" name="fromdate" value="{{ $checkbusiness->fromdate }}" required>
                                @if($errors->has('fromdate'))<span class="text-danger">{{ $errors->first('fromdate') }}</span>@endif
                            </div>
                            <div class="col-md-6" id="fromtime_box">
                                <select class="form-control select2 fromtime" name="fromtime" required>
                                    @foreach($timetype as $key=>$value)
                                        @if($checkbusiness->fromtime == $key)
                                            <option value="{{ $key }}" selected>{{ $value }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if($errors->has('fromtime'))<span class="text-danger">{{ $errors->first('fromtime') }}</span>@endif                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group to_end_box">
                        <label>Ngày kết thúc <small class="text-danger text"> (*)</small>:</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="date" class="form-control todate" name="todate" value="{{ $checkbusiness->todate }}" required>
                                @if($errors->has('todate'))<span class="text-danger">{{ $errors->first('todate') }}</span>@endif
                            </div>
                            <div class="col-md-6" id="totime_box">
                                <select class="form-control select2 totime" name="totime" required>
                                    @foreach($timetype as $key=>$value)
                                        @if($checkbusiness->totime == $key)
                                            <option value="{{ $key }}" selected>{{ $value }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if($errors->has('totime'))<span class="text-danger">{{ $errors->first('totime') }}</span>@endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tổng ngày nghỉ <small class="text-danger text"> (*)</small>:</label>
                        <input type="number" class="form-control numday" step="0.01" name="numday" value="{{ $checkbusiness->numday }}" required>
                        @if($errors->has('numday'))<span class="text-danger">{{ $errors->first('numday') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>Nơi đến <small class="text-danger text"> (*)</small>:</label>
                        <input type="text" class="form-control" name="place" value="{{ $checkbusiness->place }}" required">
                        @if($errors->has('place'))<span class="text-danger">{{ $errors->first('place') }}</span>@endif                        
                    </div>                       
                    <div class="form-group">
                        <label>Diễn giải <small class="text-danger text"> (*)</small>:</label>
                        <textarea class="form-control" name="description" rows="2" required>{{ $checkbusiness->description }}</textarea>                        
                        @if($errors->has('description'))<span class="text-danger">{{ $errors->first('description') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>Phương tiện <small class="text-danger text"> (*)</small>:</label>                    
                        <select class="form-control select2 totime" name="transportation" required>
                        @foreach($transportationtype as $key=>$value)
                            @if($checkbusiness->transportation == $key)
                                <option value="{{ $key }}" selected>{{ $value }}</option>
                            @else
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endif
                        @endforeach
                        </select>
                        @if($errors->has('transportation'))<span class="text-danger">{{ $errors->first('transportation') }}</span>@endif
                    </div>  
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Chức năng</h3>
                </div>
                <div class="box-body">
                    <button type="submit" class="btn btn-primary btn-save" tabindex="9">Lưu</button>
                    <a href="{{ route('checkbusiness-empl', [ 'parameter' => $employeeid ]) }}" class="btn btn-default btn-cancel" tabindex="10">Trở về</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('scripts')
@include('company-manage.checkbusiness.partials.script')
@endsection
