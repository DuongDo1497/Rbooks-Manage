@extends('layouts.master')
@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/orders.css') }}">

<style type="text/css">
    .content .order-branding .company-logo img{
        width: 19%;
    }

    .content .order-branding .company-info .company-name{
        text-align: center;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <article class="content">
                    <div class="order-branding">
                        <div class="company-logo">
                            <img class="img-fluid" src="{{ asset('image/logo_blue.png') }}" alt="logo">
                        </div>
                        <div class="company-info">
                            <h1 class="company-name">CÔNG TY TNHH R BOOKS</h1>
                            <div class="company-address">
                                <p><b>Địa chỉ</b> : L4-42.OT05 (Officetel) , Tòa Landmark 4 Vinhomes Central Park, Số 720A Điện Biên Phủ, Phường 22, Quận Bình Thạnh, Tp Hồ Chí Minh<br>
                                <b>Điện thoại</b> : 028 3636 4405 / 08 4966 4005</p>
                            </div>
                        </div>
                    </div><!-- .order-branding -->
                    <div class="order-addresses">
                        <div class="billing-address">
                            <h3>Địa chỉ thanh toán</h3>
                            @if($orders->billingaddress->city == NULL && $orders->billingaddress->district == NULL)
                                <address>
                                    Họ và Tên: {{ $orders->billingaddress->fullname }}<br>
                                    Địa chỉ: {{ $orders->billingaddress->address }}
                                </address>
                            @else
                                <address>
                                    Họ và Tên: {{ $orders->billingaddress->fullname }}<br>
                                    Địa chỉ: {{ $orders->billingaddress->address }}, phường {{ $orders->deliveryaddress->ward }}, quận {{ $orders->billingaddress->district }}, {{ $orders->billingaddress->city }}
                                </address>
                            @endif
                        </div>
                        <div class="shipping-address">
                            <h3>Địa chỉ nhận hàng</h3>
                            @if($orders->gift_address_id != 0)
                            <address>
                                Họ và Tên: {{ $orders->gift->recipientName }}<br>
                                Địa chỉ: {{ $orders->gift->address }}
                            </address>
                            @else
                                @if($orders->billingaddress->city == NULL && $orders->billingaddress->district == NULL)
                                    <address>
                                        Họ và Tên: {{ $orders->billingaddress->fullname }}<br>
                                        Địa chỉ: {{ $orders->billingaddress->address }}
                                    </address>
                                @else
                                    <address>
                                        Họ và Tên: {{ $orders->billingaddress->fullname }}<br>
                                        Địa chỉ: {{ $orders->billingaddress->address }}, phường {{ $orders->deliveryaddress->ward }}, quận {{ $orders->billingaddress->district }}, {{ $orders->billingaddress->city }}
                                    </address>
                                @endif
                            @endif
                        </div>
                    </div><!-- .order-addresses -->
                    <div class="order-info">
                        <h2>Thông tin đơn hàng</h2>
                        <ul class="info-list list-unstyled">
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-6">
                                    <li>
                                        <strong>Mã đơn hàng:</strong>
                                        <span>{{ $orders->id }}</span>
                                    </li>
                                    <li>
                                        <strong>Ngày đặt hàng:</strong>
                                        <span>{{ date_format($orders->created_at, "d/m/Y") }}</span>
                                    </li>
                                    <li>
                                        <strong></strong>
                                        <span></span>
                                    </li>
                                </div>
                                <div class="col-md-6">
                                    <li>
                                        <strong>Phương thức thanh toán: </strong>
                                        <span>{{ $orders->payment_method == 1 ? "Thanh toán khi nhận hàng (COD)." : "Chuyển khoản ngân hàng." }}</span>
                                    </li>
                                    <li>
                                        <strong>Số điện thoại: </strong>
                                        <span>{{ $orders->billingaddress->phone }}</span>
                                    </li>
                                    @if(isset($orders->customers))
                                    <li>
                                        <strong>Email: </strong>
                                        <span>{{ $orders->customers->email }}</span>
                                    </li>
                                    @elseif(isset($orders->deliveryaddress->email))
                                    <li>
                                        <strong>Email: </strong>
                                        <span>{{ $orders->deliveryaddress->email }}</span>
                                    </li>
                                    @endif
                                </div>
                            </div>
                        </ul>
                    </div><!-- .order-info -->
                    <div class="order-items">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="head-name"><span>Danh sách sản phẩm</span></th>
                                    <th class="head-item-price"><span>Giá bìa</span></th>
                                    <th class="head-quantity"><span>Giá KM</span></th>
                                    <th class="head-quantity"><span>Số lượng</span></th>
                                    <th class="head-price"><span>Tạm tính</span></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($orders->products as $product)
                                <tr>
                                    <td class="product-name">
                                        <span class="name">{{ $product->name }}</span>
                                    </td>
                                    <td class="product-item-price">
                                        <span>{{ number_format($product->cover_price) }} VNĐ</span>
                                    </td>
                                    <td class="product-item-price">
                                        <span>{{ number_format($product->pivot->price - ($product->pivot->price * $product->pivot->discount)/100) }} VNĐ</span>
                                    </td>
                                    <td class="product-quantity">
                                        <span>{{ $product->pivot->quantity }}</span>
                                    </td>
                                    <td class="product-price">
                                        <span>{{ number_format($product->pivot->total) }} VNĐ</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="total-name"><span>Tổng tiền</span></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="total-price"><span>{{ number_format($orders->sub_cover_price) }} VNĐ</span></td>
                                </tr>
                                <tr>
                                    <td class="total-name"><span>Tiết kiệm</span></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="total-price"><span>
                                    {{
                                        round((1-(($orders->sub_total - $orders->tax_total) / $orders->sub_total)) * 100, 0)
                                    }}%
                                    ({{
                                        number_format($orders->tax_total)
                                    }} đ)</span></td>
                                </tr>
                                <tr>
                                    <td class="total-name"><span>Thành tiền</span></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="total-price"><span>{{ number_format($orders->sub_total - $orders->tax_total) }} VNĐ</span></td>
                                </tr>
                                <tr>
                                    <td class="total-name"><span>Phí giao nhận hàng</span></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="total-price"><span>{{ number_format($orders->ship_total) }} VNĐ</span></td>
                                </tr>
                                @if($orders->gift_fee == 20000)
                                <tr>
                                    <td class="total-name"><span>Phí gói quà</span></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="total-price"><span>{{ number_format($orders->gift_fee) }} VNĐ</span></td>
                                </tr>
                                @endif
                                <!-- <tr>
                                    <td class="total-name"><span>Chiết khấu/ Giảm giá</span></td>
                                    <td></td>
                                    <td></td>
                                    <td class="total-price"><span>{{ number_format($orders->tax_total) }} VNĐ</span></td>
                                </tr> -->
                                <tr>
                                    <td class="total-name"><span>Tổng thành tiền</span></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="total-price"><span>{{ number_format($orders->total) }} VNĐ</span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- .order-items -->
                    <!-- <div class="order-notes"><a class="btn btn-default" href="{{ route('orders-pdf', ['id' => $orders->id]) }}"><i class="fa fa-download"></i> Xuất PDF</a></div> --><!-- .order-notes -->
                    <div class="order-thanks"></div><!-- .order-thanks -->
                    <div class="order-colophon">
                        <div class="colophon-policies"></div>
                        <div class="colophon-imprint"></div>
                    </div><!-- .order-colophon -->
                </article>
            </div>
        </div>
    </div>
</div>
@endsection