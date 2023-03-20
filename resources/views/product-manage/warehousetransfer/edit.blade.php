@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@section('content')
<div class="row">
    <form  method="post" action="{{ route('warehousetransfers-update', ['id' => $model->id ]) }}" role="form" id="users-form">
    {{ csrf_field() }}
    {{ method_field('put') }}
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Chỉnh sửa phiếu chuyển kho</h3>
                </div>
                    <div class="box-body">
                        <div class="form-group {{ ($errors->has('name')) ? ' has-error' : '' }}">
                            <label>Kho xuất ra</label>
                            <select class="form-control" name="warehousefrom_id">
                                <option value="{{ $model->warehousefrom_id }}">{{ $model->warehousefrom->name }}</option>
                                @foreach($warehouses->where('id', '<>', $model->warehousefrom_id) as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kho nhập vào</label>
                            <select class="form-control" name="warehouseto_id">
                                <option value="{{ $model->warehouseto_id }}">{{ $model->warehouseto->name }}</option>
                                @foreach($warehouses->where('id', '<>', $model->warehouseto_id) as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Ngày chuyển kho</label>
                            <div class="input-group date">
                                <input type="text" class="form-control pull-right" id="datepicker" name="date" value="{{ date("d-m-Y", strtotime($model->date)) }}">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Ghi chú</label>
                            <textarea class="form-control" name="note" tabindex="3">{{ $model->note }}</textarea>
                            @if($errors->has('date'))<span class="help-block">{{ $errors->first('date') }}</span>@endif
                        </div>
                    </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Trạng thái</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <select class="form-control" name="status">
                            @if($model->status == 1)
                                <option value="1"> Đang chỉnh sửa</option>
                                <option value="2"> Chờ bổ sung</option>
                                <option value="3"> Hoàn thành</option>
                                <option value="4"> Hủy phiếu</option>
                            @elseif($model->status == 2)
                                <option value="2"> Chờ bổ sung</option>
                                <option value="1"> Đang chỉnh sửa</option>
                                <option value="3"> Hoàn thành</option>
                                <option value="4"> Hủy phiếu</option>
                            @elseif($model->status == 3)
                                <option value="3"> Hoàn thành</option>
                                <option value="1"> Đang chỉnh sửa</option>
                                <option value="2"> Chờ bổ sung</option>
                                <option value="4"> Hủy phiếu</option>
                            @else
                                <option value="4"> Hủy phiếu</option>
                                <option value="1"> Đang chỉnh sửa</option>
                                <option value="2"> Chờ bổ sung</option>
                                <option value="3"> Hoàn thành</option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Chức năng</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="cur-pointer"><input type="checkbox" class="flat-red" tabindex="8"{{ old('continue') === 1 ? ' checked="checked"' : '' }} name="continue" value="1" checked="checked" id="chk-continue"> Lưu và tiếp tục chỉnh sửa</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-save" tabindex="9">Lưu</button>
                    <a href="{{ route('warehousetransfers-index') }}" class="btn btn-default btn-cancel" tabindex="10">Trở về</a>
                    <hr>
                    <ul class="list-unstyled">
                        <li><b>Ngày khởi tạo:</b> {{ $model->created_at }}</li>
                        <li><b>Ngày chỉnh sửa:</b> {{ $model->updated_at }}</li>
                        <li><b>Người sửa cuối:</b> <a href="{{-- TODO: add link to user's page --}}#" target="_blank" title="Click mở trong tab mới">{{ $model->users->name }} <i class="fa fa-external-link" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
@include('product-manage.warehousetransfer.partials.script');
@endsection
