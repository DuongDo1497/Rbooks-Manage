@extends('layouts.master')
@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/orders.css') }}">

<style type="text/css">

    .content-invoice{
        width: 100%;
    }

    .content .order-branding .company-logo{
        text-align: center;
        margin-bottom: 10px;
    }

    .content .order-branding .company-logo img{
        width: 80%;
    }

    .content .order-branding .company-address{
        font-size: 13px;
    }

    .content .order-branding .company-info .company-name{
        display: none;
    }

    .content .order-address .billing-address{
        display: none;
    }

    .content .order-address .shipping-address{
        width: 100%;
        float: none;
    }

    .content .order-address .shipping-address h3{
        font-size: 18px;
        margin-top: 10px;
        margin-bottom: 5px;
    }

    .content .order-address .shipping-address address{
        font-size: 13px;
        margin-bottom: 0;
    }

    .content .order-items table{
        font-size: 10px;
    } 

    .content .order-items table thead tr th,
    .content .order-items table tbody tr td{
        vertical-align: middle;
        text-align: center;
    }

    .content .order-items table thead tr th:first-child,
    .content .order-items table tbody tr td:first-child{
        text-align: left;
    }

    .content .order-items table thead tr th:last-child,
    .content .order-items table tbody tr td:last-child{
        text-align: right;
    }

    .content .order-items table thead tr th.head-name{
        width: 50%;
    }

    .content .order-items table thead tr th.head-quantity{
        width: 10%;
    }

    .content .order-items table thead tr th.head-price{
        width: 40%;
    }

    .content .order-items table tfoot tr td.total-price{
        text-align: right;
    }

</style>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <article class="content-invoice">
                    <div class="order-branding">
                        <div class="company-logo">
                            <img class="img-fluid" src="{{ asset('image/logo-notSub.png') }}" alt="logo">
                        </div>
                        <div class="company-info">
                            <h1 class="company-name">CÔNG TY TNHH R BOOKS</h1>
                            <div class="company-address">
                                <p style="margin-bottom: 0;"><b>Địa chỉ</b>: Hồ Chí Minh<br>
                                <b>Điện thoại</b> : 028 3636 4405 / 08 4966 4005</p>
                            </div>
                        </div>
                    </div><!-- .order-branding -->
                    <div class="order-address">
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
                            <h3>Địa chỉ</h3>
                            @if($orders->gift_address_id != 0)
                            <address>
                                <b>Họ và tên</b>: {{ $orders->gift->recipientName }}<br>
                                <b>Địa chỉ</b>: {{ $orders->gift->address }}
                            </address>
                            @else
                                @if($orders->billingaddress->city == NULL && $orders->billingaddress->district == NULL)
                                    <address>
                                        <b>Họ và tên</b>: {{ $orders->billingaddress->fullname }}<br>
                                        <b>Địa chỉ</b>: {{ $orders->billingaddress->address }}
                                    </address>
                                @else
                                    <address>
                                        <b>Họ và tên</b>: {{ $orders->billingaddress->fullname }}<br>
                                        <b>Địa chỉ</b>: {{ $orders->billingaddress->address }}, phường {{ $orders->deliveryaddress->ward }}, quận {{ $orders->billingaddress->district }}, {{ $orders->billingaddress->city }}
                                    </address>
                                @endif
                            @endif
                        </div>
                    </div><!-- .order-addresses -->
                    <div class="order-info">
                        <h2 style="margin-top: 10px; margin-bottom: 5px;">Thông tin đơn hàng</h2>
                        <ul class="info-list list-unstyled" style="font-size: 10px;">
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-12">
                                    <li>
                                        <strong>Mã đơn hàng:</strong>
                                        <span>{{ $orders->id }}</span>
                                    </li>
                                    <li>
                                        <strong>Ngày đặt hàng:</strong>
                                        <span>{{ date_format($orders->created_at, "d/m/Y") }}</span>
                                    </li>
                                    <li>
                                        <strong>Thanh toán: </strong>
                                        <span>{{ $orders->payment_method == 1 ? "Thanh toán khi nhận hàng (COD)." : "Chuyển khoản ngân hàng." }}</span>
                                    </li>
                                    <li>
                                        <strong>Điện thoại: </strong>
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
                        <table class="table table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th class="head-name"><span>Sản phẩm</span></th>
                                    <th class="head-quantity"><span>Giá bán</span></th>
                                    <th class="head-quantity"><span>SL</span></th>
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
                                        <div>{{ number_format($product->pivot->price - ($product->pivot->price * $product->pivot->discount)/100) }}</div>
                                        <div style="text-decoration: line-through;">{{ number_format($product->cover_price) }}</div>
                                    </td>
                                    <td class="product-quantity">
                                        <span>{{ $product->pivot->quantity }}</span>
                                    </td>
                                    <td class="product-price">
                                        <span>{{ number_format($product->pivot->total) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="display: none;">
                                    <td colspan="3" class="total-name"><span>Tổng tiền</span></td>
                                    <td colspan="2" class="total-price"><span>{{ number_format($orders->sub_cover_price) }}</span></td>
                                </tr>
                                <tr style="display: none;">
                                    <td colspan="3" class="total-name"><span>Tiết kiệm</span></td>
                                    <td colspan="2" class="total-price"><span>{{number_format($orders->tax_total)}}</span></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="total-name"><span>Thành tiền</span></td>
                                    <td colspan="2" class="total-price"><span>{{ number_format($orders->sub_total - $orders->tax_total) }}</span></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="total-name"><span>Phí vận chuyển</span></td>
                                    <td colspan="2" class="total-price"><span>{{ number_format($orders->ship_total) }}</span></td>
                                </tr>
                                @if($orders->gift_fee == 20000)
                                <tr>
                                    <td colspan="3" class="total-name"><span>Phí gói quà</span></td>
                                    <td colspan="2" class="total-price"><span>{{ number_format($orders->gift_fee) }}</span></td>
                                </tr>
                                @endif
                                <!-- <tr>
                                    <td class="total-name"><span>Chiết khấu/ Giảm giá</span></td>
                                    <td></td>
                                    <td></td>
                                    <td class="total-price"><span>{{ number_format($orders->tax_total) }} VNĐ</span></td>
                                </tr> -->
                                <tr>
                                    <td colspan="3" class="total-name"><span>Thanh toán</span></td>
                                    <td colspan="2" class="total-price"><span>{{ number_format($orders->total) }}</span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- .order-items -->
                </article>
            </div>
        </div>
    </div>
</div>
@endsection