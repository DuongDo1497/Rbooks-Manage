@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(isset($infor))
    @include('layouts.partials.messages.infor')
@endif

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <form role="form" action="{{ route('warehouses-transfers-update', ['id' => $model->id]) }}?continue=true" method="post" id="customer-form">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Chỉnh sửa Phiếu chuyển kho') }}</h3>
                </div>
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="box-body">
                    <div class="form-group">
                        <label>Ngày chuyển</label>
                        <input type="date" class="form-control" name="date_transfer" value="{{ $model->date_transfer }}">
                    </div>
                    <div class="form-group">
                        <label for="">{{ trans('home.Mã chuyển kho') }}</label>
                        <input type="text" name="code_transfer" class="form-control" value="{{ $model->code_transfer }}">
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="">{{ trans('home.Kho xuất ra') }}</label>
                                <select class="select2 form-control" id="warehousefrom_id" name="warehousefrom_id">
                                    <option value="{{ $model->warehousefrom_id }}">{{ $model->warehousefrom->name }}</option>
                                    @foreach($warehouses->where('id', '<>', $model->warehousefrom_id) as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="">{{ trans('home.Kho nhập vào') }}</label>
                                <select class="select2 form-control" id="warehouseto_id" name="warehouseto_id">
                                    <option value="{{ $model->warehouseto_id }}">{{ $model->warehouseto->name }}</option>
                                    @foreach($warehouses->where('id', '<>', $model->warehouseto_id) as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
      
                    <div class="form-group">
                        <label for="">{{ trans('home.Ghi chú') }}</label>
                        <textarea name="note" class="form-control">{{ $model->note }}</textarea>
                    </div>
                </div>
            </div>

            <div class="box box-table">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Danh sách sản phẩm') }}</h3>
                </div>
                {{ csrf_field() }}
                <div class="box-body">
                    @if($model->status == 'MOI_TAO' || Auth()->user()->roles()->get()->first()->name == "admin" || Auth()->user()->roles()->get()->first()->name == "owner")
                        <div class="form-group">
                            <select class="search-code form-control"></select>
                        </div>
                    @endif
                    <table id="products-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th width="10%" class="text-nowrap">Mã sản phẩm</th>
                                <th class="text-left">{{ trans('home.Sản phẩm') }}</th>
                                <th width="10%" class="text-nowrap">{{ trans('home.Số lượng') }}</th>
                                <th width="10%" class="text-nowrap">{{ trans('home.Chiết khấu') }}</th>
                                <th width="10%" class="text-nowrap">{{ trans('home.Đơn giá') }}</th>
                                <th width="10%" class="text-nowrap">{{ trans('home.Thành tiền') }}</th>
                                <th width="10%">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody id="products-table-content">
                            @foreach($model->products as $transfer_product)
                                <tr id="{{ $transfer_product->pivot->product_id }}" class="content-table">
                                    <td class="text-center">{{ $transfer_product->pivot->product_id }}</td>
                                    <input type="text" hidden="true" name="products[{{ $transfer_product->pivot->product_id }}][id]" value="{{ $transfer_product->pivot->product_id }}">
                                    <td>
                                        <b>{{ $transfer_product->name }}</b>
                                        <input type="text" hidden="true" name="products[{{ $transfer_product->pivot->product_id }}][name]" value="{{ $transfer_product->name }}">
                                    </td>
                                    <td class="quantity text-center">
                                        <input type="number" {{ ($model->status == 'MOI_TAO') ? '' : 'readonly="true"'}} min="0" class="form-control" name="products[{{ $transfer_product->pivot->product_id }}][quantity]" value="{{ $transfer_product->pivot->quantity }}">
                                    </td>
                                    <td class="discount text-center">
                                        <div id="discount" class="disc">
                                            <input type="number" {{ ($model->status == 'MOI_TAO' || Auth::user()->roles()->first()->name == 'owner') ? '' : 'readonly="true"'}} min="0" max="100" class="form-control" name="products[{{ $transfer_product->pivot->product_id }}][discount]" value="{{ $transfer_product->pivot->discount }}">
                                        </div>
                                    </td>
                                    <td class="cover_price text-center">{{ number_format($transfer_product->pivot->price) }} VNĐ
                                    <input type="text" hidden="true" name="products[{{ $transfer_product->pivot->product_id }}][cover_price]" value="{{ $transfer_product->pivot->price }}">
                                    </td>
                                    <td class="total text-center">
                                        <div class="val-total">{{ number_format($transfer_product->pivot->total) }} VNĐ</div> 
                                        <input class="input-total" type="text" hidden="true" name="products[{{ $transfer_product->pivot->product_id }}][total]" value="{{ $transfer_product->pivot->total }}">
                                    </td>
                                    <td class="text-center">
                                        <button {{ ($model->status == 'MOI_TAO') ? '' : 'disabled="true"'}} type="button" class="btn-delete" data-pid="{{ $transfer_product->pivot->product_id }}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                   </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-nowrap" colspan="2"></td>
                                <td class="text-nowrap text-center" id="sum_quantity">
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
                        <select class="form-control" name="status" {{$disabled_status}}>
                            @if($model->status == 'MOI_TAO' || $model->status == 'KHONG_DUYET')
                                <option value="{{ $model->status }}">{{ trans('home.Đang chỉnh sửa') }}</option>
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
                                <option value="HUY">{{ trans('home.Hủy') }}</option>
                            @elseif($model->status == 'XAC_NHAN')
                                <option value="{{ $model->status }}">{{ trans('home.Xác nhận') }}</option>
                                <option value="CHUYEN_KHO">{{ trans('home.Chuyển hàng') }}</option>
                                <option value="HUY">{{ trans('home.Hủy') }}</option>
                            @elseif($model->status == 'CHUYEN_KHO')
                                @if(Auth()->user()->roles()->get()->last()->name == "account" || Auth()->user()->roles()->get()->first()->name == "admin" || Auth()->user()->roles()->get()->first()->name == "owner")
                                    <option value="CHUYEN_KHO">Đã chuyển kho</option>
                                @endif
                            @endif
                        </select>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary btn-save" tabindex="7">
                            <img src="{{ asset('img/icon-save.png') }}" alt="">
                            <span><b>{{ trans('home.Lưu') }}</b></span>
                        </button>
                        <a href="{{ route('warehouses-transfers-index') }}" class="btn btn-default btn-cancel" tabindex="8">
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
                    <input type="text" id="modal-product-discount" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('home.Hủy') }}</button>
                <button type="button" class="btn btn-primary" id="modal-product-add-btn">{{ trans('home.Thêm sản phẩm') }}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal -->
@endsection

@section('scripts')
@include('product-manage.transfer.partials.script')
@endsection
