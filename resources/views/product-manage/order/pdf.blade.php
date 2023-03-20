
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Rbooks</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            #page {
            margin-left: auto;
            margin-right: auto;
            text-align: left;
            font-size: 0.875em;
            }

            .content {
            padding-left: 10%;
            padding-right: 10%;
            padding-top: 5%;
            padding-bottom: 5%;
            font-size: 15px;
            }

            .content + .content {
            page-break-before: always;
            }

            h1,
            h2 {
            font-size: 1.572em;
            }

            .order-items {
            page-break-before: auto;
            page-break-after: auto;
            }

            .order-addresses:after {
            content: ".";
            display: block;
            height: 0;
            clear: both;
            visibility: hidden;
            }

            .billing-address {
            width: 50%;
            float: left;
            }
            .billing-address h3,.shipping-address h3{
            font-size: 30px;
            }

            .shipping-address {
            width: 50%;
            float: left;
            }

            .order-addresses.no-shipping-address .shipping-address {
            display: none;
            }

            /* Switch the addresses for invoices */

            /* Order Info */
            .order-info ul {
            border-top: 0.24em solid black;
            }

            .order-info li {
            border-bottom: 0.12em solid #bbb;
            margin-bottom: 5px;
            }

            .order-info li strong {
            min-width: 18%;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
            margin-bottom: 0;
            padding-right: 0.35em;
            }

            /* Order Items */
            .order-items {
            margin-bottom: 0.5em;
            }

            .order-items .head-name,
            .order-items .product-name,
            .order-items .total-name {
            width: 50%;
            }

            .order-items .head-quantity,
            .order-items .product-quantity,
            .order-items .total-quantity,
            .order-items .head-item-price,
            .order-items .product-item-price,
            .order-items .total-item-price {
            width: 15%;
            }

            .order-items .head-price,
            .order-items .product-price,
            .order-items .total-price {
            width: 20%;
            }

            .order-items p {
            display: inline;
            }

            .order-items small,
            .order-items dt,
            .order-items dd {
            font-size: 0.785em;
            font-weight: normal;
            line-height: 150%;
            padding: 0;
            margin: 0;
            }

            .order-items dt,
            .order-items dd {
            display: block;
            float: left;
            }

            .order-items dt {
            clear: left;
            padding-right: 0.2em;
            }

            .order-items .product-name .attachment {
            display: block;
            float: left; 
            margin-right: 0.5em;
            width: 36px;
            }

            .order-items .product-name .attachment img {
            max-width: 100%;
            height: auto;
            }

            .order-items .product-name .name,
            .order-items .product-name .extras {
            overflow: hidden;
            }

            .order-items tfoot tr:first-child,
            .order-items tfoot tr:last-child {
            font-weight: bold;
            }

            .order-items tfoot tr:last-child .total-price .amount:first-child {
            font-weight: bold;
            }

            .order-items tfoot tr:last-child {
            border-bottom: 0.24em solid black;
            }

            /* Order Notes */
            .order-notes {
            margin-top: 3em;
            margin-bottom: 6em;
            }

            .order-notes h4 {
            margin-bottom: 0;
            }

            /* Order Thanks */
            .order-thanks {
            margin-left: 50%;
            }

            /* Order Colophon */
            .order-colophon {
            font-size: 0.785em;
            line-height: 150%;
            margin-bottom: 0;
            }

            .colophon-policies {
            margin-bottom: 1.25em;
            }

            .company-address p{
            line-height: 1.5em;
            }

            .company-name{
            font-size: 30px;
            font-weight: 700;
            }

            @media print {
            body {
            font-size: 8pt;
            }

            .content {
            padding-bottom: 0;
            }

            .main-footer{
            display: none;
            }
            }
        </style>

</head>
<body>
<div class="row">
  
                            <div class="row">
                                <div class="col-xs-4"><img src="{{ asset("image/logo.jpg") }}" alt=""></div>
                                <div class="col-xs-8"><h1 class="company-name">CÔNG TY TNHH RBOOKS</h1></div>
                            </div>
                            <div class="company-address"><p>Địa chỉ : P.1508, Tầng 15, Vincom Center, P. Bến Nghé, Quận 1, Tp HCM<br>
                            Điện thoại : 028.363.60440 / 0918.43.5005</p>
                        </div>
                    </div>
                </div><!-- .order-branding -->
                <div class="order-addresses">
                    <div class="billing-address">
                        <h3>Địa chỉ thanh toán</h3>
                        <address>
                            Họ và Tên: {{ $data['fullname'] }}<br>
                            Địa chỉ: {{ $data['address_payment'] }} - {{ $data['district_payment'] }} - {{ $data['city_payment'] }}
                        </address>
                    </div>
                    <div class="shipping-address">
                        <h3>Địa chỉ nhận hàng</h3>
                        <address>
                            Họ và Tên: {{ $data['fullname'] }}<br>
                            Địa chỉ: {{ $data['address_ship'] }} - {{ $data['district_ship'] }} - {{ $data['city_ship'] }}
                        </address>
                    </div>
                </div><!-- .order-addresses -->
                <div class="order-info">
                    <h2>Thông tin đơn hàng</h2>
                    <ul class="info-list list-unstyled">
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-6">
                                <li>
                                    <strong>Mã đơn hàng:</strong>
                                    <span>{{ $data['id'] }}</span>
                                </li>
                                <li>
                                    <strong>Ngày đặt hàng:</strong>
                                    <span>{{ $data['created_at'] }}</span>
                                </li>
                            </div>
                            <div class="col-md-6">
                                <li>
                                    <strong>Phương thức thanh toán: </strong>
                                    <span>{{ $data['payment_method'] == 1 ? "Thanh toán khi nhận hàng (COD)." : "Chuyển khoản ngân hàng." }}</span>
                                </li>
                                <li>
                                    <strong>Số điện thoại: </strong>
                                    <span>{{ $data['phone'] }}</span>
                                </li>
                            </div>
                        </div>
                    </ul>
                </div><!-- .order-info -->
                <div class="order-items">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="head-name"><span>Danh sách sản phẩm</span></th>
                                <th class="head-item-price"><span>Giá bán</span></th>
                                <th class="head-item-price"><span>Giá KM</span></th>
                                <th class="head-quantity"><span>Số lượng</span></th>
                                <th class="head-price"><span>Tạm tính</span></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($data['products'] as $product)

                            <tr>
                                <td class="product-name">
                                    <span class="name">{{ $product['name'] }}</span>
                                </td>
                                <td class="product-item-price">
                                    <span>{{ ($product['cover_price']) }} VNĐ</span>
                                </td>
                                <td class="product-item-price">
                                    <span>{{ ($product['price']) }} VNĐ</span>
                                </td>
                                
                                
                                <td class="product-quantity">
                                    <span>{{ $product['quantity'] }}</span>
                                </td>
                                <td class="product-price">
                                    <span>{{ $product['total'] }} VNĐ</span>
                                </td>

                            </tr>
                        </tbody>
                        @endforeach
                        <tfoot>

                            <tr>
                                <td class="total-name"><span>Tổng tiền</span></td>
                                <td></td>
                                <td></td>
                                <td class="total-price"><span>{{ number_format($data['sub_cover_price']) }} VNĐ</span></td>
                            </tr>
                            <tr>
                                <td class="total-name"><span>Tiết kiệm</span></td>
                                <td></td>
                                <td></td>
                                <td class="total-price"><span>
                                
                                ({{
                                    $data['sale']
                                }} đ) VNĐ</span></td>
                            </tr>
                            <tr>
                                <td class="total-name"><span>Thành tiền</span></td>
                                <td></td>
                                <td></td>
                                <td class="total-price"><span>{{ number_format($data['total']) }} VNĐ</span></td>
                            </tr>
                            <tr>
                                <td class="total-name"><span>Phí giao nhận hàng</span></td>
                                <td></td>
                                <td></td>
                                <td class="total-price"><span>{{ number_format($data['ship']) }} VNĐ</span></td>
                            </tr>
                           
                            <tr>
                                <td class="total-name"><span>Tổng thành tiền</span></td>
                                <td></td>
                                <td></td>
                                <td class="total-price"><span>{{ number_format($data['total'] + $data['ship']) }} VNĐ</span></td>
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- .order-items -->


 

</body>
</html>
