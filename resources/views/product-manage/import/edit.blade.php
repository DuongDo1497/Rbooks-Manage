@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection


@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<div class="row">
    <form role="form" action="{{ route('warehouses-imports-update', ['id' => $model->id]) }}?continue=true" method="post" id="customer-form">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Chỉnh sửa Phiếu nhập hàng') }}</h3>
                </div>
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="box-body">
                    <div class="form-group">
                        <label>Ngày nhập</label>
                        <input type="date" class="form-control" name="import_date" value="{{ $model->import_date }}">
                    </div>
                    <div class="form-group">
                        <label for="">{{ trans('home.Nhập kho') }}</label>
                        <select class="select2 form-control" name="warehouse_id">
                            <option value="{{ $model->warehouse_id }}">{{ $model->warehouses->name }}</option>
                            @foreach($warehouses->whereNotIn('id', [$model->warehouse_id]) as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">{{ trans('home.Nhà cung cấp') }}</label>
                        <select class="form-control select2" name="supplier_id">
                            <option value="{{ $model->supplier_id }}">{{ $model->suppliers->name }}</option>
                            @foreach($suppliers->whereNotIn('id', [$model->supplier_id]) as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">{{ trans('home.Mã phiếu nhập hàng') }}</label>
                        <input type="text" name="import_code" class="form-control" value="{{ $model->import_code }}">
                    </div>
                    <div class="form-group">
                        <label for="">{{ trans('home.Mã nhập kho') }}</label>
                        <input type="text" name="warehouse_import_code" class="form-control" value="{{ $model->warehouse_import_code }}">
                    </div>
                    <div class="form-group">
                        <label>Ghi chú </label>
                        <textarea class="form-control" name="note" rows="6">{{ $model->note }}</textarea>
                    </div>
                </div>
            </div>

            <div class="box box-table">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        {{ trans('home.Danh sách sản phẩm') }}
                    </h2>
                </div>
                <div class="box-body">
                    @if($model->status == 'MOI_TAO')
                        <div class="form-group">
                            <select class="search-code form-control"></select>
                        </div>
                    @endif
                    <table id="products-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th width="1%" class="text-nowrap">STT</th>
                                <th class="text-left">{{ trans('home.Sản phẩm') }}</th>
                                <th width="10%" class="text-nowrap">{{ trans('home.Số lượng') }}</th>
                                <th width="10%" class="text-nowrap">{{ trans('home.Chiết khấu') }}</th>
                                <th width="10%" class="text-nowrap">{{ trans('home.Đơn giá') }}</th>
                                <th width="15%" class="text-nowrap">{{ trans('home.Thành tiền') }}</th>
                                <th width="10%">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody id="products-table-content">
                            @foreach($model->products as $import_product)
                                <tr id="{{ $import_product->pivot->product_id }}" class="content-table">
                                    <td class="text-center">{{ $import_product->pivot->product_id }}</td>
                                    <input type="text" hidden="true" name="products[{{ $import_product->pivot->product_id }}][id]" value="{{ $import_product->pivot->product_id }}">
                                    <td>
                                        <b>{{ $import_product->name }}</b>
                                        <input type="text" hidden="true" name="products[{{ $import_product->pivot->product_id }}][name]" value="{{ $import_product->name }}">
                                    </td>
                                    <td class="quantity text-center">
                                        <input type="number" {{ ($model->status == 'MOI_TAO' || Auth::user()->roles()->first()->name == 'owner') ? '' : 'readonly="true"'}} min="0" class="form-control" name="products[{{ $import_product->pivot->product_id }}][quantity]" value="{{ $import_product->pivot->quantity }}">
                                    </td>
                                    <td class="discount text-center">
                                        <div id="discount" class="disc">
                                            <input type="number" {{ ($model->status == 'MOI_TAO' || Auth::user()->roles()->first()->name == 'owner') ? '' : 'readonly="true"'}} min="0" max="100" class="form-control" name="products[{{ $import_product->pivot->product_id }}][discount]" value="{{ $import_product->pivot->discount }}">
                                        </div>
                                    </td>
                                    <td class="cover_price text-center">{{ number_format($import_product->pivot->price) }} VNĐ
                                    <input type="text" hidden="true" name="products[{{ $import_product->pivot->product_id }}][cover_price]" value="{{ $import_product->pivot->price }}">
                                    </td>
                                    <td class="total text-center">
                                        <div class="val-total">{{ number_format($import_product->pivot->total) }} VNĐ</div> 
                                        <input class="input-total" type="text" hidden="true" name="products[{{ $import_product->pivot->product_id }}][total]" value="{{ $import_product->pivot->total }}">
                                    </td>
                                    <td class="text-center">
                                        <button type="button" {{ ($model->status == 'MOI_TAO' || Auth::user()->roles()->first()->name == 'owner') ? '' : 'disabled="true"'}} class="btn-delete" title="Xóa" data-pid="{{ $import_product->pivot->product_id }}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                   </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"></td>
                                <td class="text-nowrap" id="sum_quantity">
                                </td>
                                <input type="text" hidden="true" id="sum_quant" name="sum_quant">
                                <td colspan="4">
                                    <div class="row">
                                        <div class="col-lg-6"><b>{{ trans('home.Tổng tiền chiết khấu') }}:</b></div>
                                        <div class="col-lg-6" id="sum_discount">0 VNĐ</div>
                                        <input type="text" hidden="true" id="sumdis" name="sumdis">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6"><b>{{ trans('home.Tổng tiền') }}: </b></div>
                                        <div class="col-lg-6" id="sum_price">0 VNĐ</div>
                                        <input type="text" hidden="true" id="sub_total" name="sub_total">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6"><b>{{ trans('home.Tổng thành tiền') }}: </b></div>
                                        <div class="col-lg-6" id="sum_total">0 VNĐ</div>
                                        <input type="text" hidden="true" id="total" name="total">
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary box-control">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Chức năng') }}</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label>{{ trans('home.Trạng thái') }}</label>
                        <select class="form-control" name="status">
                            @if($model->status == 'MOI_TAO')
                                <option value="MOI_TAO">{{ trans('home.Đang chỉnh sửa') }}</option>
                                <option value="DE_XUAT_DUYET">{{ trans('home.Đề xuất duyệt') }}</option>
                                <option value="HUY">{{ trans('home.Hủy đơn hàng') }}</option>
                            @elseif($model->status == 'DE_XUAT_DUYET')
                                <option value="DE_XUAT_DUYET">{{ trans('home.Đề xuất duyệt') }}</option>
                                @if(Auth()->user()->roles()->get()->first()->name == "admin" || Auth()->user()->roles()->get()->first()->name == "owner")
                                    <option value="DUYET">Duyệt</option>
                                    <option value="KHONG_DUYET">Không duyệt</option>
                                @endif
                            @elseif($model->status == 'DA_DUYET')
                                <option value="DA_DUYET">{{ trans('home.Đã duyệt') }}</option>
                                <option value="XAC_NHAN">{{ trans('home.Xác nhận') }}</option>
                            @elseif($model->status == 'XAC_NHAN')
                                <option value="XAC_NHAN">{{ trans('home.Xác nhận') }}</option>
                                <option value="NHAP_HANG">{{ trans('home.Nhập hàng') }}</option>
                                <option value="HUY">{{ trans('home.Hủy đơn hàng') }}</option>
                            @elseif($model->status == 'NHAP_HANG')
                                <option value="NHAP_HANG">{{ trans('home.Nhập hàng') }}</option>
                                @if(Auth()->user()->roles()->get()->last()->name == "account" || Auth()->user()->roles()->get()->first()->name == "admin" )
                                    <option value="THANH_TOAN">{{ trans('home.Đã thanh toán') }}</option>
                                @endif
                            @endif
                        </select>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary btn-save" tabindex="7">
                            <img src="{{ asset('img/icon-save.png') }}" alt="">
                            <span><b>{{ trans('home.Lưu') }}</b></span>
                        </button>
                        <a href="{{ route('warehouses-imports-index') }}" class="btn btn-default btn-cancel" tabindex="8">
                            <img src="{{ asset('img/icon-cancel.png') }}" alt="">
                            <span><b>Thoát</b></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-quantity" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('home.Thêm sản phẩm') }}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>{{ trans('home.Tên sản phẩm') }}</label>
                    <input type="text" id="modal-product-name" class="form-control" readonly="readonly">
                </div>
                <div class="form-group">
                    <label>{{ trans('home.Đơn giá nhập') }}</label>
                    <input type="text" id="modal-product-price" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ trans('home.Số lượng') }}</label>
                    <input type="number" min="1" id="modal-product-quantity" class="form-control" value="1">
                </div>
                <div class="form-group">
                    <label>{{ trans('home.Chiết khấu') }}</label>
                    <input type="number" min="0" id="modal-product-discount" class="form-control" value="0">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('home.Hủy') }}</button>
                <button type="button" class="btn btn-primary" id="modal-product-add-btn">{{ trans('home.Thêm sản phẩm') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@include('product-manage.import.partials.script')
@endsection
