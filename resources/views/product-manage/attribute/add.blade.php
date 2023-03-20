@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Thêm mới</h3>
            </div>
            <form method="post" action="{{ route("attributes-store") }}?continue=true" role="form" id="attribute-form">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
                        <label for="name">Tên thuộc tính</label>
                        <input id="name" type="text" class="form-control" placeholder="Tên thuộc tính" name="name" tabindex="1" value="{{ old('name') }}">
                        @if($errors->has('name'))<span class="help-block">{{ $errors->first('name') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control select2" name="type" tabindex="2" id="type">
                            <option value="text">text</option>
                            <option value="number">number</option>
                            <option value="select">select</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Thuộc tính SELECT</label>
                        <input type="text" class="form-control" placeholder="Option" name="option" tabindex="3" id="option" readonly="true">
                    </div>
                </div>
                <input type="hidden" name="image_id" id="image_id">
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Chức năng</h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label class="cur-pointer"><input type="checkbox" class="flat-red" tabindex="4"{{ old('continue') === 1 ? ' checked="checked"' : '' }} name="continue" value="1" checked="checked" id="chk-continue"> Lưu và thêm mới</label>
                </div>
                <button type="submit" class="btn btn-primary btn-save" tabindex="5">Lưu</button>
                <a href="{{ route('attributes-index') }}" class="btn btn-default btn-cancel" tabindex="6">Trở về</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $('.btn-save').click(function(){
        $('#attribute-form').submit();
    });

    $('#type').change(function(){
        if($(this).val() == 'select'){
            $('#option').removeAttr('readonly');
        }
        else{
            $('#option').attr('readonly', 'true');
        }
    });
</script>
@endsection
