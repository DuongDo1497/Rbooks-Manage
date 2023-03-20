@extends('layouts.master')

@section('head')
@endsection

@section('content')
<div class="row">
    <form  method="post" action="{{ route('debts-update', ['id' => $model->id ]) }}" role="form" id="debt-form">
    {{ csrf_field() }}
    {{ method_field('put') }}
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Chỉnh sửa công nợ</h3>
                </div>
                    <div class="box-body">
                        <div class="form-group {{ ($errors->has('name')) ? ' has-error' : '' }}">
                            <label>Nhà cung cấp</label>
                            <select class="form-control" name="supplier_id">
                                <option value="{{ $model->suppliers->id }}">{{ $model->suppliers->name }}</option>
                                @foreach($suppliers->where('id', '<>', $model->suppliers->id) as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Phiếu nhập hàng</label>
                            <select class="form-control select2" name="import_id">
                                <option value="{{ $model->imports->id }}">{{ $model->imports->code }}</option>
                                @foreach($imports->where('id', '<>', $model->imports->id) as $import)
                                    <option value="{{ $import->id }}">{{ $import->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Ngày lập công nợ</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control pull-right" id="datepicker" name="start_date" value="{{ date("d-m-Y", strtotime($model->start_date)) }}">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Ngày trả nợ</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control pull-right" id="datepicker1" name="end_date" value="{{ date("d-m-Y", strtotime($model->end_date)) }}">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tổng tiền phiếu nhập</label>
                                    <div class="input-group">
                                    <input type="text" class="form-control pull-right" name="total" value="{{ number_format($model->total) }}">
                                    <div class="input-group-addon">VNĐ</div>
                                    </div>
                                </div>
                            </div>
                           <div class="col-md-6">
                                <div class="form-group">
                                    <label>Số tiền trả trước</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control pull-right" name="paymented_debt" value="{{ $model->paymented_debt }}">
                                        <div class="input-group-addon">VNĐ</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Ghi chú</label>
                            <textarea class="form-control" name="note" tabindex="3">{{ $model->note }}</textarea>
                            @if($errors->has('note'))<span class="help-block">{{ $errors->first('note') }}</span>@endif
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
                    <a href="{{ route('debts-index') }}" class="btn btn-default btn-cancel" tabindex="10">Trở về</a>
                    <hr>
                    <ul class="list-unstyled">
                        <li><b>Ngày khởi tạo:</b> {{ $model->created_at }}</li>
                        <li><b>Ngày chỉnh sửa:</b> {{ $model->updated_at }}</li>
                        <li><b>Người sửa cuối:</b> <a href="{{-- TODO: add link to user's page --}}#" target="_blank" title="Click mở trong tab mới">{{ $model->updated_user_id }} <i class="fa fa-external-link" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
@include('product-manage.debt.partials.script');
@endsection
