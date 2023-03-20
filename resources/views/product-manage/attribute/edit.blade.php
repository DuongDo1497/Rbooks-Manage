@extends('layouts.master')

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Chỉnh sửa</h3>
            </div>
            <form role="form" action="{{ route('attributes-update', ['id' => $model->id]) }}?continue=true" method="post" id="attribute-form">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="box-body">
                    <div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
                        <label>Tên thuộc tính</label>
                        <input type="text" class="form-control" placeholder="Tên thuộc tính" name="name" value="{{ $model->name }}" tabindex="1">
                        @if($errors->has('name'))<span class="help-block">{{ $errors->first('name') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>Giới tính</label>
                        <select class="form-control select2" name="type" tabindex="2">
                                <option value="{{ $model->type }}">{{ $model->type }}</option>
                                <option value="text">text</option>
                                <option value="number">number</option>
                                <option value="select">select</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Option</label>
                        <input type="text" class="form-control" placeholder="Option" name="option" value="{{ $model->option }}" tabindex="6">
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
                <div class="form-group">
                    <label class="cur-pointer"><input type="checkbox" class="flat-red" tabindex="8"{{ old('continue') === 1 ? ' checked="checked"' : '' }} name="continue" value="1" checked="checked" id="chk-continue" tabindex="8"> Lưu và tiếp tục chỉnh sửa</label>
                </div>
                <button type="submit" class="btn btn-primary btn-save" tabindex="9">Lưu</button>
                <a href="{{ route('attributes-index') }}" class="btn btn-default btn-cancel" tabindex="10">Trở về</a>
                <hr>
                <ul class="list-unstyled">
                    <li><b>Ngày khởi tạo:</b> {{ $model->created_at }}</li>
                    <li><b>Ngày chỉnh sửa:</b> {{ $model->updated_at }}</li>
                    <li><b>Người sửa cuối:</b> <a href="{{-- TODO: add link to user's page --}}#" target="_blank" title="Click mở trong tab mới">{{ ($model->updated_user) ? $model->updated_user->name : "Error" }} <i class="fa fa-external-link" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#attribute-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#attribute-form').attr('action', '{{ route('attributes-edit', ['id' => $model->id]) }}?continue=true');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#attribute-form').attr('action', '{{ route('attributes-edit', ['id' => $model->id]) }}');
        });
    });
</script>
@endsection
