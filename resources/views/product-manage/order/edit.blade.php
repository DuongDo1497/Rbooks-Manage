@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">

<style type="text/css">
    #orders-form .row .col-md-8 .box:last-child table thead tr th:nth-child(4){
        width: 15%;
    }

    @media (min-width: 992px) and (max-width: 1200px){
        #orders-form .row .col-md-8 .box:last-child table thead tr th:nth-child(4){
            width: 20%;
        }
    }
</style>
@endsection

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
@include('product-manage.order.partials.addproduct')
<form role="form" method="post" action="{{ route('orders-update', ['id' => $model->id]) }}?continue=true" id="orders-form">
    {{ csrf_field() }}
    {{ method_field('put') }}
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Thông tin đơn hàng') }}<small class="text-danger text"> (*): {{ trans('home.Bắt buộc điền thông tin') }}</small></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tên khách hàng') }}<small class="text-danger text"> (*)</small></label>
                                <input type="text" class="form-control" placeholder="Họ và tên" style="{{$disabled}}" name="name" id="name" value="{{ $model->billingaddress->fullname }}">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('home.Phương thức thanh toán') }}<small class="text-danger text"> (*)</small></label>
                                <select class="form-control" name="payment_method" style="{{$disabled}}">
                                    <option @if($model->payment_method == 1){{"selected"}} @endif value="1">{{ trans('home.Thanh toán khi nhận hàng (COD)') }}</option>
                                    <option @if($model->payment_method == 2){{"selected"}} @endif value="2">{{ trans('home.Chuyển khoản ngân hàng') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Kho bán hàng') }}<small class="text-danger text"> (*)</small></label>
                                <select class="form-control" name="warehouse_id" id="warehouse_id" style="{{$disabled}}">
                                    <option value="{{ $model->warehouse_id }}">{{ $model->warehouses->name }}</option>
                                    @foreach($warehouses->where('id','!=', $model->warehouse_id) as $warehouse)
                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('home.Phương thức vận chuyển') }}<small class="text-danger text"> (*)</small></label>
                                <select class="form-control" name="shipping_method" style="{{$disabled}}">
                                    <option @if($model->ship_total == 10000){{"selected"}} @endif value="10000">10,000 đ</option>
                                    <option @if($model->ship_total == 30000){{"selected"}} @endif value="30000">30,000 đ</option>
                                    <option @if($model->ship_total == 45000){{"selected"}} @endif value="45000">45,000 đ</option>
                                    <option @if($model->ship_total == 20000){{"selected"}} @endif value="20000">{{ trans('home.Giao hàng tiêu chuẩn') }} (20,000 đ)</option>
                                    <option @if($model->ship_total == 25000){{"selected"}} @endif value="25000">{{ trans('home.Giao hàng nhanh') }} (25,000 đ)</option>
                                    <option @if($model->ship_total == 0) {{"selected"}} @endif value="0" >{{ trans('home.Miễn phí giao hàng') }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('home.Phí gói quà') }}<small class="text-danger text"> (*)</small></label>
                                <input type="text" style="{{$disabled}}" class="form-control" placeholder="Họ và tên" name="gift_fee" id="gift_fee" value="{{ $model->gift_fee }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Thông tin thanh toán & vận chuyển') }}<small class="text-danger text"> (*): {{ trans('home.Bắt buộc điền thông tin') }}</small></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ trans('home.Thông tin giao hàng') }}</h3>
                            </div>
                            <div class="box-body">
                                @if($model->gift_address_id != 0)
                                <div id="delivery_address">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Họ và Tên') }}<small class="text-danger text"> (*)</small></label>
                                                <input type="text" style="{{$disabled}}" class="form-control" name="recipientName" id="name_delivery" value="{{ $model->gift->recipientName }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Điện thoại') }}<small class="text-danger text"> (*)</small></label>
                                                <input type="text" style="{{$disabled}}" class="form-control" name="phone_gift" id="phone" value="{{ $model->gift->phone }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Email<small class="text-danger text"> (*)</small></label>
                                                <input type="email" style="{{$disabled}}" class="form-control" name="email_delivery" value="" id="email_delivery">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{ trans('home.Địa chỉ') }}</label>
                                                <input type="text" style="{{$disabled}}" class="form-control" name="address_gift" value="{{ $model->gift->address }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Ghi chú gói quà</label>
                                                <textarea id="note" style="{{$disabled}}" name="gift_message" rows="6" class="form-control">{{ $model->gift->message }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div id="delivery_address">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Họ và Tên') }}<small class="text-danger text"> (*)</small></label>
                                                <input type="text" style="{{$disabled}}" class="form-control" name="name_delivery" id="name_delivery" value="{{ $model->deliveryaddress->fullname }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Điện thoại') }}<small class="text-danger text"> (*)</small></label>
                                                <input type="text" style="{{$disabled}}" class="form-control" name="phone_delivery" id="phone_delivery" value="{{ $model->deliveryaddress->phone }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Email<small class="text-danger text"> (*)</small></label>
                                                <input type="email" style="{{$disabled}}" class="form-control" name="email_delivery" value="{{ $model->deliveryaddress->email }}" id="email_delivery">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Thành phố') }}<small class="text-danger text"> (*)</small></label>
                                                <input type="text" style="{{$disabled}}" class="form-control" name="city_delivery" id="city_delivery" value="{{ $model->deliveryaddress->city }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Quận') }}<small class="text-danger text"> (*)</small></label>
                                                <input type="text" style="{{$disabled}}" class="form-control" name="district_delivery" id="district_delivery" value="{{ $model->deliveryaddress->district }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Phường') }}<small class="text-danger text"> (*)</small></label>
                                                <input type="text" style="{{$disabled}}" class="form-control" name="ward_delivery" id="ward_delivery" value="{{ $model->deliveryaddress->ward }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Địa chỉ') }}<small class="text-danger text"> (*)</small></label>
                                                <input type="text" style="{{$disabled}}" class="form-control" name="address_delivery" id="address_delivery" value="{{ $model->deliveryaddress->address }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{ trans('home.Mã bưu điện') }}</label>
                                                <input type="text" style="{{$disabled}}" class="form-control" name="zipcode_delivery" value="{{ $model->deliveryaddress->zipcode }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Ghi chú vận chuyển</label>
                                                <textarea id="note" style="{{$disabled}}" name="note_delivery" rows="6" class="form-control">{{ $model->deliveryaddress->note }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box-header with-border">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3 class="box-title">{{ trans('home.Thông tin thanh toán') }}</h3>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <!-- <small style="{{$disabled}}"><input type="button" id="copy" value="copy"></small> -->

                                        <button type="button" id="copy" class="btn btn-xs btn-default" title="Copy"><i class="fa fa-files-o" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body">
                                <div id="billing_address">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Họ và Tên') }}</label>
                                                <input type="text" style="{{$disabled}}" class="form-control" name="name_billing" id="name_billing" value="{{ $model->billingaddress->fullname }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Điện thoại') }}</label>
                                                <input type="text" style="{{$disabled}}" class="form-control" name="phone_billing" value="{{ $model->billingaddress->phone }}" id="phone_billing">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" style="{{$disabled}}" class="form-control" name="email_billing" value="{{ $model->deliveryaddress->email }}" id="email_billing">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Thành phố') }}</label>
                                                <input type="text" style="{{$disabled}}" class="form-control" name="city_billing" id="city_billing" value="{{ $model->billingaddress->city }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Quận') }}</label>
                                                <input type="text" style="{{$disabled}}" class="form-control" name="district_billing" id="district_billing" value="{{ $model->billingaddress->district }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Phường') }}</label>
                                                <input type="text" style="{{$disabled}}" class="form-control" name="ward_billing" id="ward_billing" value="{{ $model->billingaddress->ward }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Địa chỉ') }}</label>
                                                <input type="text" style="{{$disabled}}" class="form-control" name="address_billing" id="address_billing" value="{{ $model->billingaddress->address }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{ trans('home.Mã bưu điện') }}</label>
                                                <input type="text" style="{{$disabled}}" class="form-control" name="zipcode_billing" value="{{ $model->billingaddress->zipcode }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Ghi chú vận chuyển</label>
                                                <textarea id="note" style="{{$disabled}}" name="note_billing" rows="6" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-table">
                <div class="box-header">
                    <h3 class="box-title">{{ trans('home.Danh sách sản phẩm') }}</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        @if($model->status == 1 || Auth()->user()->roles()->get()->first()->name == "admin" || Auth()->user()->roles()->get()->first()->name == "owner")
                        <div class="form-group col-md-12">
                            <select hidden="true" class="search-code select2 form-control" id="input-search-product"></select>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" width="1%">STT</th>
                                    <th class="text-nowrap text-left">{{ trans('home.Thông tin sách') }}</th>
                                    <th class="text-nowrap" width="10%">{{ trans('home.Số lượng') }}</th>
                                    <th class="text-nowrap">{{ trans('home.Chiết khấu') }}</th>
                                    <th class="text-nowrap" width="10%">{{ trans('home.Giá') }}</th>
                                    <th class="text-nowrap" width="10%">{{ trans('home.Thành tiền') }}</th>
                                    <th class="text-nowrap" width="10%">
                                        Chức năng
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="products-table-content">
                                @foreach($model->products as $order_product)
                                    <tr id="{{ $order_product->pivot->product_id }}" class="content-table">
                                        <td class="text-center">{{ $order_product->pivot->product_id }}</td>
                                        <input type="text" hidden="true" name="" value="{{ $order_product->pivot->product_id }}">
                                        <td>
                                            {{ trans('home.Tên sách') }}: <b>{{ $order_product->name }}</b>
                                            <input type="text" hidden="true" name="products[{{ $order_product->pivot->product_id }}][name]" value="{{ $order_product->name }}">
                                        </td>
                                        <td class="quantity text-center">
                                            <input type="number" style="{{$disabled}}" min="0" class="form-control" name="products[{{ $order_product->pivot->product_id }}][quantity]" value="{{ $order_product->pivot->quantity }}">
                                        </td>
                                        <td class="discount text-center">
                                            <div id="discount" class="disc">
                                                <input type="number" style="{{$disabled}}" min="0" max="100" class="form-control" name="products[{{ $order_product->pivot->product_id }}][discount]" value="{{ $order_product->pivot->discount }}">
                                            </div>
                                        </td>
                                        <td class="cover_price text-center">{{ number_format($order_product->cover_price) }} VNĐ
                                            <input type="text" hidden="true" name="products[{{ $order_product->pivot->product_id }}][cover_price]" value="{{ $order_product->cover_price }}">
                                        </td>
                                        <td class="total text-center">
                                            <div class="val-total">{{ number_format($order_product->pivot->total) }} VNĐ</div>
                                            <input class="input-total" type="text" style="{{$disabled}}" hidden="true" name="products[{{ $order_product->pivot->product_id }}][total]" value="{{ $order_product->pivot->total }}">
                                        </td>
                                        <td class="text-center">
                                            <button type="button" {{$disabledbutton}} class="btn-delete" data-pid="{{ $order_product->pivot->product_id }}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                       </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-nowrap" colspan="2"></td>
                                    <td class="text-nowrap text-center" id="sum_quantity"></td>
                                    <input type="text" hidden="true" id="sum_quant" name="sum_quant">
                                    <td colspan="4">
                                        <div class="row">
                                            <div class="col-lg-6"><b>{{ trans('home.Tổng tiền') }}: </b></div>
                                            <div class="col-lg-6" id="sum_price">{{ number_format($model->sub_cover_price) }} VNĐ</div>
                                            <input type="text" hidden="true" id="sub_cover_price" name="sub_cover_price">
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6"><b>{{ trans('home.Tổng tiền chiết khấu') }}:</b></div>
                                            <div class="col-lg-6" id="sum_discount">{{ number_format($model->tax_total) }} VNĐ</div>
                                            <input type="text" hidden="true" id="sumdis" name="sumdis">
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6"><b>{{ trans('home.Tổng thành tiền') }}: </b></div>
                                            <div class="col-lg-6" id="sum_total">{{ number_format($model->total) }} VNĐ</div>
                                            <input type="text" hidden="true" id="total" name="total">
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6"><b>{{ trans('home.Phí vận chuyển') }}:</b></div>
                                            <div class="col-lg-6" id="shipping_method">{{ number_format($model->ship_total) }} VNĐ</div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Trạng thái đơn hàng') }}<span class="text-danger text"> (*)</span></h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="select-container">
                            <select class="form-control" name="status" {{$disabled_status}}>
                                @if($model->status == 1) <!-- Đang chỉnh sửa -->
                                    <option value="1" selected="selected">{{ trans('home.Đang chỉnh sửa') }}</option>
                                    <option value="8">{{ trans('home.Đề xuất duyệt') }}</option>
                                    <option value="4">{{ trans('home.Hủy đơn hàng') }}</option>
                                @elseif($model->status == 8) <!-- Chờ duyệt -->
                                    <option value="8" selected="selected">{{ trans('home.Chờ duyệt') }}</option>
                                    @if(Auth()->user()->roles()->get()->last()->name == "owner" || Auth()->user()->roles()->get()->first()->name == "admin" )
                                        <option value="9" selected="selected">{{ trans('home.Duyệt') }}</option>
                                        <option value="10">{{ trans('home.Không duyệt') }}</option>
                                    @endif
                                @elseif($model->status == 9) <!-- Đã duyệt -->
                                    <option value="9" selected="selected">{{ trans('home.Đã duyệt') }}</option>
                                    <option value="5">{{ trans('home.Xuất kho') }}</option>
                                    <option value="4">{{ trans('home.Hủy đơn hàng') }}</option>
                                @elseif($model->status == 10) <!-- Không duyệt -->
                                    <option value="10">{{ trans('home.Không duyệt') }}</option>
                                    <option value="4">{{ trans('home.Hủy đơn hàng') }}</option>
                                @elseif($model->status == 5) <!-- Đã xuất kho -->
                                    <option value="5">{{ trans('home.Đã xuất kho') }}</option>
                                    <option value="2">{{ trans('home.Đang vận chuyển') }}</option>
                                    <option value="4">{{ trans('home.Hủy đơn hàng') }}</option>
                                @elseif($model->status == 2) <!-- Đang vận chuyển -->
                                    <option value="2" selected="selected">{{ trans('home.Đang vận chuyển') }}</option>
                                    <option value="6">{{ trans('home.Giao hàng thành công') }}</option>
                                    <option value="4">{{ trans('home.Hủy đơn hàng') }}</option>
                                @elseif($model->status == 6) <!-- Hoàn thành -->
                                    <option value="6">{{ trans('home.Giao hàng thành công') }}</option>
                                    <option value="3">{{ trans('home.Hoàn thành') }}</option>
                                    <option value="4">{{ trans('home.Hủy đơn hàng') }}</option>
                                @elseif($model->status == 3) <!-- Đã hoàn thành -->
                                    <option value="3">{{ trans('home.Hoàn thành') }}</option>
                                    @if(Auth()->user()->roles()->get()->first()->name == "account" || Auth()->user()->roles()->get()->first()->name == "admin" || Auth()->user()->roles()->get()->first()->name == "owner" )
                                        <option value="7">{{ trans('home.Đã thanh toán') }}</option>
                                        <option value="4">{{ trans('home.Hủy') }}</option>
                                    @endif
                                @elseif($model->status == 7) <!-- Đã thanh toán -->
                                    <option value="7">{{ trans('home.Đã thanh toán') }}</option>
                                    <option value="4">{{ trans('home.Hủy') }}</option>
                                @else
                                    <option value="4">{{ trans('home.Hủy') }}</option>
                                    <option value="7">{{ trans('home.Đã thanh toán') }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-primary box-control">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Chức năng') }}</h3>
                </div>
                <div class="box-body">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary btn-save" tabindex="7">
                            <img src="{{ asset('img/icon-save.png') }}" alt="">
                            <span><b>{{ trans('home.Lưu') }}</b></span>
                        </button>
                        <a href="{{ $uri }}" class="btn btn-default btn-cancel" tabindex="8">
                            <img src="{{ asset('img/icon-cancel.png') }}" alt="">
                            <span><b>Thoát</b></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Ghi chú đơn hàng</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <textarea id="note" style="{{$disabled}}" name="note" rows="5" class="form-control">{{ $model->note }}</textarea>
                    </div>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin xuất hóa đơn VAT</h3>
                    <p><small class="text-danger text">
                        Nhập đầy đủ thông tin dưới đây để lưu hóa đơn VAT.<br/>
                        Nếu không nhập hoặc nhập không đầy đủ thông tin thì hóa đơn VAT sẽ không được chỉnh sửa hoặc tạo mới.
                    </small><p>
                </div>
                <div class="box-body">
                    <div class="form-group mb-4">
                        <div><b>Tên công ty </b>:</div>
                        <div>
                            <input value="{{$model->vat ? $model->vat->name_company : ''}}" type="text" placeholder="Ít nhất 2 từ" name="name_company" id="name_company" class="form-control" value="" minlength="2" maxlength="300" novalidate >
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <div><b>Mã số thuế </b>:</div>
                        <div>
                            <input value="{{$model->vat ? $model->vat->code_vat : ''}}" type="number" placeholder="Mã số thuế" name="code_vat" id="code_vat" class="form-control" value="" minlength="10" novalidate >
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <div><b>Địa chỉ</b>:</div>
                        <div>
                            <textarea type="text" name="vat_address" placeholder="Nhập địa chỉ công ty(bao gồm Phường/Xã, Quận/Huyện, Tỉnh/Thành phố nếu có)" id="address_vat" class="form-control" maxlength="500">{{$model->vat ? $model->vat->address_company : ''}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
@include('product-manage.order.partials.script')

<!-- <script>

var select = $('.select-container option:selected').val();

if (select != 1) {

    $('input[type="text"]').css({'{{$disabled}}'});
    $('input[type="email"]').css({'{{$disabled}}'} );
    $('textarea').css({'{{$disabled}}'});
    $('select').css({'{{$disabled}}'});
    $('select[name="status"]').css({'pointer-events': 'inherit', 'background-color': '#fff'});
    $('.btn-delete').attr('disabled', true );
    $('input[type="number"]').css({'{{$disabled}}'} );

}else if(select == 4){
    $('.btn-save').attr('disabled', true );
}

</script> -->
@endsection