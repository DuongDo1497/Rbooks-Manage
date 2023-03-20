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
    <form role="form" action="{{ route('warehouses-transfers-store') }}?continue=true" method="post" id="warehousetransfers-form">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Tạo mới Phiếu nhập hàng') }}</h3>
                </div>
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label>Ngày chuyển</label>
                        <input type="date" class="form-control" name="date_transfer">
                    </div>
                    <div class="form-group">
                        <label for="">{{ trans('home.Mã chuyển kho') }}</label>
                        <input type="text" name="code_transfer" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="">{{ trans('home.Kho xuất ra') }}</label>
                                <select class="select2 form-control" id="warehousefrom_id" name="warehousefrom_id">
                                    @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="">{{ trans('home.Kho nhập vào') }}</label>
                                <select class="select2 form-control" id="warehouseto_id" name="warehouseto_id">
                                    @foreach($warehouses->where('id','<>', '1') as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
      
                    <div class="form-group">
                        <label for="">{{ trans('home.Ghi chú') }}</label>
                        <textarea name="note" class="form-control"></textarea>
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
                        <select class="search-code form-control"></select>
                    </div>
                    <table id="products-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th width="10%" class="text-nowrap">Mã sản phẩm</th>
                                <th class="text-left">{{ trans('home.Sản phẩm') }}</th>
                                <th width="10%" class="text-nowrap">{{ trans('home.Số lượng') }}</th>
                                <th width="10%" class="text-nowrap">Chiết khấu</th>
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
                        <select class="form-control" name="status">
                            <option value="MOI_TAO">{{ trans('home.Đang chỉnh sửa') }}</option>
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
                    <input type="number" min="0" id="modal-product-quantity" class="form-control" value="0">
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
