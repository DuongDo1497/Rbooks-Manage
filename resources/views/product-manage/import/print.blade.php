@extends('layouts.master')
@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/orders.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <article class="content">
                    <div class="order-branding">
                        <div class="company-logo">
                        </div>
                        <div class="company-info">
                            <div class="row">
                                <div class="col-xs-4"><img src="{{ asset('image/logo.jpg') }}" alt=""></div>
                                <div class="col-xs-8"><h1 class="company-name">{{ trans('home.CÔNG TY TNHH R BOOKS') }}</h1></div>
                            </div>
                            <div class="company-address"><p>{{ trans('home.Địa chỉ : L4-42.OT05 (Officetel) , Tòa Landmark 4 Vinhomes Central Park, Số 720A Điện Biên Phủ, Phường 22, Quận Bình Thạnh, Tp Hồ Chí Minh') }}<br>
                            {{ trans('home.Điện thoại') }} : 028 3636 4405 / 08 4966 4005</p>
                        </div>
                    </div>
                </div><!-- .order-branding -->
                <div class="text-center"><h2 class="font-weight-bold">{{ trans('home.PHIẾU NHẬP KHO') }}</h2></div>
                <div class="order-addresses">
                    <div class="billing-address">
                        <h3>{{ trans('home.Nhà cung cấp') }}</h3>
                        <address>
                            {{ trans('home.Tên nhà cung cấp') }}: {{ $imports->suppliers->name }}<br>
                            {{ trans('home.Địa chỉ') }}: {{ $imports->suppliers->address }}<br>
                            {{ trans('home.Số điện thoại') }}: {{ $imports->suppliers->phone }}
                        </address>
                    </div>
                    <div class="shipping-address">
                        <h3>{{ trans('home.Kho nhập') }}</h3>
                        <address>
                            {{ trans('home.Tên kho') }}: {{ $imports->warehouses->name }}<br>
                            {{ trans('home.Địa chỉ') }}: {{ $imports->warehouses->address }}<br>
                            {{ trans('home.Số điện thoại') }}: {{ $imports->warehouses->phone }}
                        </address>
                    </div>
                </div><!-- .order-addresses -->
                <div class="order-info">
                    <h2>{{ trans('home.Thông tin đơn hàng') }}</h2>
                    <ul class="info-list list-unstyled">
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-6">
                                <li>
                                    <strong>{{ trans('home.Mã nhập hàng') }}:</strong>
                                    <span>{{ $imports->import_code }}</span>
                                </li>
                                <li>
                                    <strong>{{ trans('home.Ngày đặt hàng') }}:</strong>
                                    <span>{{ date_format($imports->created_at, "d/m/Y") }}</span>
                                </li>
                            </div>
                            <div class="col-md-6">
                                <li>
                                    <strong>{{ trans('home.Mã nhập kho') }}: </strong>
                                    <span>{{ $imports->warehouse_import_code }}</span>
                                </li>
                            </div>
                        </div>
                    </ul>
                </div><!-- .order-info -->
                <div class="order-items" style="border-top: 2px solid black;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="head-name"><span>{{ trans('home.Danh sách sản phẩm') }}</span></th>
                                <th class="head-item-price"><span>{{ trans('home.Giá') }}</span></th>
                                <th class="head-quantity"><span>{{ trans('home.Số lượng') }}</span></th>
                                <th class="head-quantity"><span>{{ trans('home.Chiết khấu') }}</span></th>
                                <th class="head-price"><span>{{ trans('home.Tổng tiền') }}</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($imports->products as $product)
                            <tr>
                                <td class="product-name">
                                    <span class="name">{{ $product->name }}</span>
                                </td>
                                <td class="product-item-price">
                                    <span>{{ number_format($product->pivot->price) }} VNĐ</span>
                                </td>
                                <td class="product-quantity">
                                    <span>{{ $product->pivot->quantity }}</span>
                                </td>
                                <td class="product-quantity">
                                    <span>{{ $product->pivot->discount }}</span>
                                </td>
                                <td class="product-price">
                                    <span>{{ number_format($product->pivot->total) }} VNĐ</span>
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                        <tfoot>
                            <tr>
                                <td class="total-name" colspan="4"><span>{{ trans('home.Tổng cộng') }}</span></td>
                                <td class="total-price text-nowrap"><span>{{ number_format($imports->sub_total) }} VNĐ</span></td>
                            </tr>
                            <tr>
                                <td class="total-name" colspan="4"><span>{{ trans('home.Chiết khấu/ Giảm giá') }}</span></td>
                                <td class="total-price"><span>{{ number_format($imports->discount) }} VNĐ</span></td>
                            </tr>
                            <tr>
                                <td class="total-name" colspan="4"><span>{{ trans('home.Tổng cộng thanh toán') }}</span></td>
                                <td class="total-price"><span>{{ number_format($imports->total) }} VNĐ</span></td>
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- .order-items -->
                <div class="order-notes"></div><!-- .order-notes -->
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
</div>
@endsection