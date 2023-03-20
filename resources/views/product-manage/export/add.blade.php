@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <form role="form" action="{{ route('warehouses-exports-store') }}?continue=true" method="post" id="customer-form">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Tạo mới Phiếu xuất hàng') }}</h3>
                </div>
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="">{{ trans('home.Kho xuất') }}</label>
                        <select class="select2 form-control" id="warehouse_id" name="warehouse_id">
                            @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">{{ trans('home.Đại lý') }}</label>
                        <select class="form-control select2" id="supplier_id" name="supplier_id">
                            <option>{{ trans('home.Vui lòng chọn đại lý') }}</option>
                            @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">{{ trans('home.Tên khách hàng') }}</label>
                        <input type="text" name="agencies" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">{{ trans('home.Số điện thoại') }}</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">{{ trans('home.Địa chỉ') }}</label>
                        <input type="text" name="address" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">{{ trans('home.Phí vận chuyển') }}</label>
                        <input type="number" name="transport_fee" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">{{ trans('home.Thể loại sách') }}</label>
                        <select class="form-control select2" name="category_books[]" multiple>
                            <option value="SLK">{{ trans('home.Sách liên kết') }}</option>
                            <option value="SBQ">{{ trans('home.Sách bản quyền') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="box box-table">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Danh sách sản phẩm') }}</h3>
                </div>
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <select class="form-control search-code"></select>
                    </div>
                    <table id="products-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th width="8%" class="text-nowrap">Mã sản phẩm</th>
                                <th class="text-left">{{ trans('home.Sản phẩm') }}</th>
                                <th width="10%" class="text-nowrap">{{ trans('home.Số lượng') }}</th>
                                <th width="10%" class="text-nowrap">{{ trans('home.Chiết khấu') }}</th>
                                <th width="10%" class="text-nowrap">{{ trans('home.Đơn giá') }}</th>
                                <th width="10%" class="text-nowrap">{{ trans('home.Thành tiền') }}</th>
                                <th width="10%">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody id="products-table-content">
                            <tr id="empty-row">
                                <td colspan="7">{{ trans('home.Thêm sản phẩm') }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-center" colspan="2"></td>
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
                        <select class="form-control" name="status">
                            <option value="MOI_TAO">{{ trans('home.Đang chỉnh sửa') }}</option>
                            <option value="XAC_NHAN">{{ trans('home.Xác nhận') }}</option>
                        </select>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary btn-save" tabindex="7">
                            <img src="{{ asset('img/icon-save.png') }}" alt="">
                            <span><b>{{ trans('home.Lưu') }}</b></span>
                        </button>
                        <a href="{{ route('warehouses-exports-index') }}" class="btn btn-default btn-cancel" tabindex="8">
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
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal -->
@endsection

@section('scripts')
@include('product-manage.export.partials.script')
@endsection
