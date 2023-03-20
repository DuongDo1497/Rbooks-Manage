@extends('layouts.master')

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Thông tin role chức năng</h3>
            </div>
            <form role="form" action="{{ route('applicationroles-update', ['id' => $model->id]) }}?continue=true" method="post" id="frm">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label>Mã role chức năng <small class="text-danger text"> (*)</small>:</label>
                        <input type="text" class="form-control" name="code" value="{{ $model->code }}">
                        @if($errors->has('code'))<span class="text-danger">{{ $errors->first('code') }}</span>@endif                        
                    </div>                      
                    <div class="form-group">
                        <label>Tên role <small class="text-danger text"> (*)</small>:</label>
                        <input type="text" class="form-control" name="name" value="{{ $model->name }}">
                        @if($errors->has('name'))<span class="text-danger">{{ $errors->first('name') }}</span>@endif                        
                    </div>                                           
                    <div class="form-group">
                        <label>Module truy cập <small class="text-danger text"> (*)</small>: </label><br>
                            @foreach($applicationmodules as $item)
                                {{$item->id}}. {{$item->applicationmodulename}}&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" name="modules_{{$item->id}}" value="{{$item->id}}" {{ in_array($item->id,$modulesallowed) ? 'checked' : '' }}> <br> 
                            @endforeach
                    </div>
                    <div class="form-group">
                        <label>Ghi chú : </label>
                        <input type="text" class="form-control" name="description" value="{{ $model->description }}">
                    </div>  
                    <div class="form-group">
                        <label>Sao y các quyền truy cập của nhóm:</label>
                        <select class="form-control select2" name="code_cp">
                            <option value=""></option>
                            @foreach($applicationroles as $item)
                                @if($item->code == $model->code_cp)
                                    <option value="{{ $item->code }}" selected>{{ $item->code . '. ' . $item->name }}</option>
                                @else
                                    <option value="{{ $item->code }}">{{ $item->code . '. ' . $item->name }}</option>
                                @endif
                            @endforeach
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
                <a href="{{ route('applicationroles-index') }}" class="btn btn-default btn-cancel" tabindex="6">Trở về</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@include('company-manage.applicationroles.partials.script')
@endsection