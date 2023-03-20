@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <form role="form" action="{{ route('warehousetransfer-store') }}?continue=true" method="post" id="customer-form">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Tạo mới Phiếu nhập hàng</h3>
                </div>
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="">Mã phiếu chuyển kho</label>
                        <input type="text" name="code_transfer" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="">Kho xuất ra</label>
                                <select class="select2 form-control" name="warehouse_id">
                                    @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="">Kho nhập vào</label>
                                <select class="form-control select2" name="supplier_id">
                                    <option>Vui lòng chọn kho</option>
                                    @foreach($suppliers as $supplier)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
      
                    <div class="form-group">
                        <label for="">Ghi chú</label>
                        <textarea name="note" class="form-control"></textarea>
                    </div>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Danh sách sản phẩm</h3>
                </div>
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <select class="search-code form-control"></select>
                    </div>
                    <hr>
                    <table id="products-table" class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th width="1%" class="text-nowrap">#</th>
                                <th>Sản phẩm</th>
                                <th width="10%" class="text-nowrap">Số lượng</th>
                                <th width="10%" class="text-nowrap">Chiết khấu</th>
                                <th width="10%" class="text-nowrap">Đơn giá</th>
                                <th width="10%" class="text-nowrap">Thành tiến</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="products-table-content">
                            <tr id="empty-row">
                                <td colspan="7">Thêm sản phẩm</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                    <td class="text-center"></td>
                                    <td class="text-nowrap"></td>
                                    <td class="text-nowrap" id="sum_quantity">
                                    </td>
                                    <input type="text" hidden="true" id="sum_quant" name="sum_quant">
                                    <td colspan="4">
                                        <div class="row">
                                            <div class="col-lg-6"><b>Tổng tiền chiết khấu:</b></div>
                                            <div class="col-lg-6" id="sum_discount">0 VNĐ</div>
                                            <input type="text" hidden="true" id="sumdis" name="sumdis">
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6"><b>Tổng tiền: </b></div>
                                            <div class="col-lg-6" id="sum_price">0 VNĐ</div>
                                            <input type="text" hidden="true" id="sub_total" name="sub_total">
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6"><b>Tổng thành tiền: </b></div>
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
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Chức năng</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select class="form-control" name="status">
                            <option value="MOI_TAO">Đang chỉnh sửa</option>
                            <option value="XAC_NHAN">Xác nhận</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="cur-pointer"><input type="checkbox" class="flat-red" tabindex="8"{{ old('continue') === 1 ? ' checked="checked"' : '' }} name="continue" value="1" checked="checked" id="chk-continue"> Lưu và thêm mới</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-save" tabindex="9">Lưu</button>
                    <a href="{{ route('warehouses-imports-index') }}" class="btn btn-default btn-cancel" tabindex="10">Trở về</a>
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
                <h4 class="modal-title">Thêm sản phẩm</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Tên sản phẩm</label>
                    <input type="text" id="modal-product-name" class="form-control" readonly="readonly">
                </div>
                <div class="form-group">
                    <label>Đơn giá nhập</label>
                    <input type="text" id="modal-product-price" class="form-control">
                </div>
                <div class="form-group">
                    <label>Số lượng</label>
                    <input type="number" min="1" id="modal-product-quantity" class="form-control" value="1">
                </div>
                <div class="form-group">
                    <label>Chiết khấu</label>
                    <input type="number" min="0" id="modal-product-discount" class="form-control" value="0">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="modal-product-add-btn">Thêm sản phẩm</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal -->
@endsection

@section('scripts')
@include('product-manage.warehousetransfer.partials.script')
@endsection
