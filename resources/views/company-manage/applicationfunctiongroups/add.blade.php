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
                <h3 class="box-title">Thông tin nhóm chức năng</h3>
            </div>
            <form role="form" action="{{ route('applicationfunctiongroups-store') }}?index=true" method="post" id="frm">
                {{ csrf_field() }}
                <input type="hidden" name="applicationmoduleid"  value="{{ $applicationmoduleid }}">                
                <div class="box-body">
                    <div class="form-group">
                        <label>Module chức năng <small class="text-danger text"> (*)</small>:</label><br>
                        {{ $applicationmodules->id . '. ' . $applicationmodules->applicationmodulename }}
                    </div>                      
                    <div class="form-group">
                        <label>Nhóm chức năng <small class="text-danger text"> (*)</small>:</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                        @if($errors->has('name'))<span class="text-danger">{{ $errors->first('name') }}</span>@endif                        
                    </div>                      
                    <div class="form-group">
                        <label>Thứ tự <small class="text-danger text"> (*)</small>: </label>
                        <input type="text" class="form-control" name="displayorder" value="{{ old('displayorder') }}">
                    </div>
                    <div class="form-group">
                        <label>Image : </label>
                        <input type="text" class="form-control" name="image" value="{{ old('image') }}">
                    </div>
                    <div class="form-group">
                        <label>Chức năng <small class="text-danger text"> (*)</small>:</label>
                        <select class="form-control select2" name="applicationresourceid">
                            <option value=""></option>
                            @foreach($applicationresources as $item)
                                @if($item->id == old('applicationresourceid'))
                                    <option value="{{ $item->id }}" selected>{{ $item->code . '. ' . $item->name }}</option>
                                @else
                                    <option value="{{ $item->id }}">{{ $item->code . '. ' . $item->name }}</option>
                                @endif
                            @endforeach
                            @if($errors->has('applicationresourceid'))<span class="text-danger">{{ $errors->first('applicationresourceid') }}</span>@endif
                        </select>
                    </div>                                                           
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Chức năng</h3>
            </div>
            <div class="box-body">
                <button type="submit" class="btn btn-primary btn-save" tabindex="5">Lưu</button>
                <a href="{{ route('applicationfunctiongroups-index', ['applicationmoduleid' => $applicationmoduleid]) }}" class="btn btn-default btn-cancel" tabindex="6">Trở về</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@include('company-manage.applicationfunctiongroups.partials.script')
@endsection