@extends('layouts.master')

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Thông tin module chức năng</h3>
            </div>
            <form role="form" action="{{ route('securityresources-update', ['id' => $model->id]) }}?continue=true" method="post" id="frm">
                <input type="hidden" name="resourcecode"  value="{{ $applicationresourceid }}">
                <input type="hidden" name="filename"  value="{{ $applicationresources->filename }}">                
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label>Trang truy cập <small class="text-danger text"> (*)</small>:</label><br>
                        <font size=2>{{ $applicationresourceid . '. ' . $applicationresources->name }}</font>
                    </div>
                    <div class="form-group">
                        <label>File name <small class="text-danger text"> (*)</small>:</label><br>
                        <font size=2>{{ $applicationresources->filename }}</font>
                    </div>                      
                    <div class="form-group">
                        <label>Nhóm truy cập <small class="text-danger text"> (*)</small>:</label>
                        <select class="form-control select2" name="rolecode">
                            <option value=""></option>
                            @foreach($applicationroles as $item)
                                @if($item->code == $model->rolecode)
                                    <option value="{{ $item->code }}" selected>{{ $item->code . '. ' . $item->name }}</option>
                                @else
                                    <option value="{{ $item->code }}">{{ $item->code . '. ' . $item->name }}</option>
                                @endif
                            @endforeach
                            @if($errors->has('rolecode'))<span class="text-danger">{{ $errors->first('rolecode') }}</span>@endif
                        </select>
                    </div>                     
                    <div class="form-group">
                        <label>View:&nbsp;&nbsp;</label>
                        <input type="checkbox" tabindex="4" name="cview" value="1" {{ $model->cview==1 ? 'checked="checked"' : '' }}>
                    </div>  
                    <div class="form-group">
                        <label>Add:&nbsp;&nbsp;</label>
                        <input type="checkbox" tabindex="4" name="cadd" value="1" {{ $model->cadd==1 ? 'checked="checked"' : '' }}>
                    </div> 
                    <div class="form-group">
                        <label>Delete:&nbsp;&nbsp;</label>
                        <input type="checkbox" tabindex="4" name="cdelete" value="1" {{ $model->cdelete==1 ? 'checked="checked"' : '' }}>
                    </div> 
                    <div class="form-group">
                        <label>Update:&nbsp;&nbsp;</label>
                        <input type="checkbox" tabindex="4" name="cupdate" value="1" {{ $model->cupdate==1 ? 'checked="checked"' : '' }}>
                    </div> 
                    <div class="form-group">
                        <label>Approve:&nbsp;&nbsp;</label>
                        <input type="checkbox" tabindex="4" name="capprove" value="1" {{ $model->capprove==1 ? 'checked="checked"' : '' }}>
                    </div> 
                    
                    <div class="form-group">
                        <label>User view :</label><br>
                        <SELECT class="form-control select2" multiple id="cuserview" name="cuserview[]">                        
                            @foreach($users as $item)
                            @if(in_array($item->id, $model->cuserview))
                                <option value="{{ $item->id }}" selected>{{ $item->id . '. ' . $item->name }}</option>
                            @else
                                <option value="{{ $item->id }}">{{ $item->id . '. ' . $item->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>                     
                    
                    <div class="form-group">
                        <label>Ghi chú : </label>
                        <textarea class="form-control" name="description" rows="2">{{ $model->description }}</textarea>
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
                <a href="{{ route('securityresources-index', ['applicationresourceid'=> $model->resourcecode]) }}" class="btn btn-default btn-cancel" tabindex="6">Trở về</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@include('company-manage.securityresources.partials.script')
@endsection