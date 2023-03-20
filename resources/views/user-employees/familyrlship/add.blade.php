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
                <h3 class="box-title">{{ trans('home.Thông tin quan hệ nhân thân') }}</h3>
            </div>
            <form role="form" action="{{ route('familyrlships-store') }}?index=true" method="post" id="frm">
                {{ csrf_field() }}
                <input type="hidden" name="employeeid"  value="{{ $employeeid }}">                
                <div class="box-body">
                    <div class="form-group">
                        <label>{{ trans('home.Quan hệ') }} <small class="text-danger text"> (*)</small>: </label>
                        <select class="form-control select2" name="relation">
                            @foreach($relationshiptype as $key=>$value)
                                @if($key == old('relation'))
                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>                                                                    
                                @endif
                            @endforeach
                        </select>
                        @if($errors->has('relation'))<span class="text-danger">{{ $errors->first('relation') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Họ tên') }} <small class="text-danger text"> (*)</small>: </label>
                        <input type="text" class="form-control" name="fullname" value="{{ old('fullname') }}">
                         @if($errors->has('fullname'))<span class="text-danger">{{ $errors->first('fullname') }}</span>@endif                       
                    </div>                    
                    <div class="form-group">
                        <label>{{ trans('home.Ngày sinh') }}: </label>
                        <input type="date" class="form-control" name="birthday" value="{{ old('birthday') }}">
                        @if($errors->has('birthday'))<span class="text-danger">{{ $errors->first('birthday') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Địa chỉ') }}: </label>
                        <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Công việc / Điện thoại liên lạc') }}:</label>
                        <input type="text" class="form-control" name="work" value="{{ old('work') }}">
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
                <a href="{{ route('familyrlships-index', ['employeeid' => $employeeid]) }}" class="btn btn-default btn-cancel" tabindex="6">{{ trans('home.Trở về') }}</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@include('user-employees.familyrlship.partials.script')
@endsection