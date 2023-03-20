@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
@include('product-manage.order.partials.addproduct')
<form role="form" method="post" action="{{ route('orders-store') }}" id="orders-form">
    {{ csrf_field() }}
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
                                <input type="text" class="form-control" placeholder="{{ trans('home.Họ và Tên') }}" name="name" id="name">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('home.Phương thức thanh toán') }}<small class="text-danger text"> (*)</small></label>
                                <select class="form-control" name="payment_method">
                                    <option value="1">{{ trans('home.Thanh toán khi nhận hàng (COD)') }}</option>
                                    <option value="2">{{ trans('home.Chuyển khoản ngân hàng') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Kho bán hàng') }}<small class="text-danger text"> (*)</small></label>
                                <select class="form-control" name="warehouse_id" id="warehouse_id">
                                    @foreach($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('home.Phương thức vận chuyển') }}<small class="text-danger text"> (*)</small></label>
                                <select class="form-control" name="shipping_method">
                                    <option value="20000" class="Checked">{{ trans('home.Giao hàng tiêu chuẩn') }}(20,000 đ)</option>
                                    <option value="25000" class="unChecked">{{ trans('home.Giao hàng nhanh') }}(25,000 đ)</option>
                                    <option value="10000" class="ten">10,000 đ</option>
                                    <option value="30000" class="three">30,000 đ</option>
                                    <option value="45000" class="forty-five">45,000 đ</option>
                                    <option value="0" class="free-ship">{{ trans('home.Miễn phí giao hàng') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nhập loại đơn hàng <small class="text-danger text"> (Lưu ý): Nhập đúng đối tượng tương ứng trong ô</small></label>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" class="form-control typeorderI" placeholder="Đại lý" name="typeI">
                                            <input type="hidden" name="typehiddenI" id="slugI">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control typeorderII" placeholder="Khách lẻ" name="typeII">
                                            <input type="hidden" name="typehiddenII" id="slugII">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control typeorderIII" placeholder="Sách mẫu, sách tặng" name="typeIII">
                                            <input type="hidden" name="typehiddenIII" id="slugIII">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control typeorderIV" placeholder="Nội bộ" name="typeIV">
                                            <input type="hidden" name="typehiddenIV" id="slugIV">
                                        </div>
                                    </div>
                                </div>
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
                                <div id="delivery_address">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Họ và Tên') }}<small class="text-danger text"> (*)</small></label>
                                                <input type="text" class="form-control" name="name_delivery" id="name_delivery">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Điện thoại') }}<small class="text-danger text"> (*)</small></label>
                                                <input type="text" class="form-control" name="phone_delivery" value="" id="phone_delivery">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Email<small class="text-danger text"> (*)</small></label>
                                                <input type="email" class="form-control" name="email_delivery" value="" id="email_delivery">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Thành phố') }}<small class="text-danger text"> (*)</small></label>
                                                <input type="text" class="form-control" name="city_delivery" value="" id="city_delivery">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Quận') }}<small class="text-danger text"> (*)</small></label>
                                                <input type="text" class="form-control" name="district_delivery" id="district_delivery">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Phường') }}<small class="text-danger text"> (*)</small></label>
                                                <input type="text" class="form-control" name="ward_delivery" id="ward_delivery">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Địa chỉ') }}<small class="text-danger text"> (*)</small></label>
                                                <input type="text" class="form-control" name="address_delivery" value="" id="address_delivery">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{ trans('home.Mã bưu điện') }}</label>
                                                <input type="text" class="form-control" name="zipcode_delivery">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Ghi chú vận chuyển</label>
                                                <textarea id="note" name="note_delivery" rows="6" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box-header with-border">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3 class="box-title">{{ trans('home.Thông tin thanh toán') }}</h3>
                                    </div>
                                    <div class="col-md-4 text-right">
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
                                                <input type="text" class="form-control" name="name_billing" id="name_billing">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Điện thoại') }}</label>
                                                <input type="text" class="form-control" name="phone_billing" value="" id="phone_billing">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email_billing" value="" id="email_billing">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Thành phố') }}</label>
                                                <input type="text" class="form-control" name="city_billing" id="city_billing" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Quận') }}</label>
                                                <input type="text" class="form-control" name="district_billing" id="district_billing">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Phường') }}</label>
                                                <input type="text" class="form-control" name="ward_billing" id="ward_billing" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('home.Địa chỉ') }}</label>
                                                <input type="text" class="form-control" name="address_billing" id="address_billing" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{ trans('home.Mã bưu điện') }}</label>
                                                <input type="text" class="form-control" name="zipcode_billing">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Ghi chú vận chuyển</label>
                                                <textarea id="note" name="note_billing" rows="6" class="form-control"></textarea>
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
                        <div class="form-group">
                            <select hidden="true" class="search-code select2 form-control" id="input-search-product"></select>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" width="1%">STT</th>
                                    <th class="text-nowrap text-left">{{ trans('home.Thông tin sách') }}</th>
                                    <th class="text-nowrap" width="10%">{{ trans('home.Số lượng') }}</th>
                                    <th class="text-nowrap" width="10%">{{ trans('home.Chiết khấu') }}</th>
                                    <th class="text-nowrap" width="10%">{{ trans('home.Giá') }}</th>
                                    <th class="text-nowrap" width="10%">{{ trans('home.Thành tiền') }}</th>
                                    <th class="text-nowrap" width="10%">
                                        Chức năng
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="products-table-content">
                                {{-- nội dung --}}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-nowrap" colspan="2"></td>
                                    <td class="text-nowrap text-center" id="sum_quantity"></td>
                                    <input type="text" hidden="true" id="sum_quant" name="sum_quant">
                                    <td colspan="4">
                                        <div class="row">
                                            <div class="col-lg-6"><b>{{ trans('home.Tổng tiền') }}: </b></div>
                                            <div class="col-lg-6" id="sum_price">0 VNĐ</div>
                                            <input type="text" hidden="true" id="sub_cover_price" name="sub_cover_price">
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6"><b>{{ trans('home.Tổng tiền chiết khấu') }}:</b></div>
                                            <div class="col-lg-6" id="sum_discount">0 VNĐ</div>
                                            <input type="text" hidden="true" id="sumdis" name="sumdis">
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6"><b>{{ trans('home.Thành tiền') }}: </b></div>
                                            <div class="col-lg-6" id="sum_total">0 VNĐ</div>
                                            <input type="text" hidden="true" id="sumtotal" name="sumtotal">
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6"><b>{{ trans('home.Tổng thành tiền') }}: </b></div>
                                            <div class="col-lg-6" id="to_tal">0 VNĐ</div>
                                            <input type="text" hidden="true" id="total" name="total">
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6"><b>{{ trans('home.Phí vận chuyển') }} </b></div>
                                            <div class="col-lg-6" id="shipping_method">0 VNĐ</div>
                                            <input type="text" hidden="true" id="feeship" name="feeship">
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
                            <select class="form-control" name="status">
                                <option value="1">{{ trans('home.Đang chỉnh sửa') }}</option>
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
                        <a href="{{ route('orders-index') }}" class="btn btn-default btn-cancel" tabindex="8">
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
                        <textarea id="note" name="note" rows="5" class="form-control"></textarea>
                    </div>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin xuất hóa đơn VAT</h3>
                    <p><small class="text-danger text">
                        Nhập đầy đủ thông tin dưới đây để lưu hóa đơn VAT.<br/>
                        Nếu không nhập hoặc nhập không đầy đủ thông tin thì hóa đơn VAT sẽ không được tạo.
                    </small><p>
                </div>
                <div class="box-body">
                    <div class="form-group mb-4">
                        <div><b>Tên công ty </b>:</div>
                        <div>
                            <input type="text" placeholder="Ít nhất 2 từ" name="name_company" id="name_company" class="form-control" value="" minlength="2" maxlength="300" novalidate >
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <div><b>Mã số thuế </b>:</div>
                        <div>
                            <input type="number" placeholder="Mã số thuế" name="code_vat" id="code_vat" class="form-control" value="" minlength="10" novalidate >
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <div><b>Địa chỉ</b>:</div>
                        <div>
                            <textarea type="text" name="vat_address" placeholder="Nhập địa chỉ công ty(bao gồm Phường/Xã, Quận/Huyện, Tỉnh/Thành phố nếu có)" id="address_vat" class="form-control" maxlength="500"></textarea>
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
@endsection
