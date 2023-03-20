<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <style type="text/css" media="screen">
        body {
			margin: 0;
			padding: 0;
			background: #555;
		}
		.content {
			max-width: 768px;
		    margin: auto;
		    background: white;
		    padding: 10px;
	        font-family: 'Roboto', sans-serif;
    		font-size: 15px;
		}
		table {
			width: 100%;
		}

		footer::after{
			display: block;
		    content: "";
		    clear: both;
		}

		.info{
			float: left;
			padding: 0 2% 15px 2%;
		}
		.payment{
			width: 46%;

		}
		.address{
			width: 46%;
		}

		.button-box{
			margin: 0 auto;
			width: 50%;
		}

		.button-box .button-email{
			border-radius: 5px;
			background: #3d5c5c;
			border: 1px solid #3d5c5c;
			padding: 2% 2%;
			color: #fff !important;
			display: inline-block;
			width: 45%;
			margin-top: 15px;
			text-decoration: none;
			text-align: center;
		}

		.button-box .button-email:hover{
			background-color: #fff;
    		color: #3d5c5c !important;
		}

		@media (max-width: 576px){

			.button-box{
				width: 100%;
			}
		}
    </style>
</head>
<body>
	<div class="content">
  		<header>
  			<div>
  				<div class="head logo">
  					<a href="rbooks.vn"><img src="https://rbooks.vn/public/imgs/banners/RB-header-order.jpg" alt="" style="width: 100%;"></a>
  				</div>
  			</div>
    	</header>

	    <section>

	    	<article>
	    		<h1 style="text-align: center; color: #283b91">ĐỀ XUẤT DUYỆT ĐƠN HÀNG</h1>

	    		<div>
	    			<p>
	    				Kính gửi: Bà Phạm Thị Ngọc Châu – Giám đốc Công ty TNHH R Books.
	    			</p>
	    			<div style="text-align: justify;">
	    				Hệ thống quản lý đơn hàng RBooks trân trọng thông báo đơn hàng <b>#{{ $order->id }}</b> của quý khách <b>Trần Đình Phúc</b> vừa được tạo thành công vào lúc {{ date("H:i:s - d/m/Y", strtotime($order->created_at)) }}.
	    			</div>
	    		</div>

	    		<h3 style="border-bottom: 2px solid #ddd; color: #283b91">THÔNG TIN NGƯỜI ĐỀ XUẤT</h3>

	    		<div>
					<div><b>Tên nhân viên: </b> {{ $order->users()->first()->name }}</div>
					<div><b>Chức vụ: </b></div>
					<div><b>Email: </b> {{ $order->users()->first()->email }}</div>
				</div>

	    		<h3 style="border-bottom: 2px solid #ddd; color: #283b91">THÔNG TIN ĐƠN HÀNG #{{ $order->id }}</h3>

	    		<div>
	    			<div class="info payment">
	    				<h3>Thông tin thanh toán</h3>
	    				<div>
	    					<div>{{ $order->billingaddress->fullname }}</div>
	    					<div>{{ $order->billingaddress->email }}</div>
	    					<div>{{ $order->billingaddress->phone }}</div>
	    				</div>
	    			</div>
	    			<div class="info address">
	    				<h3>Địa chỉ nhận hàng</h3>
	    				<div>
	    					<div>{{ $order->deliveryaddress->fullname }}</div>
	    					<div>{{ $order->deliveryaddress->email }}</div>
	    					<div>
	    						{{
                                    $order->deliveryaddress->address .', '.
                                    $order->deliveryaddress->district .', '.
                                    $order->deliveryaddress->city
                                }}
	    					</div>
	    					<div>{{ $order->deliveryaddress->phone }}</div>
	    				</div>
	    			</div>
	    		</div>

	    		<div>
	    			<div>
	    				<div style="padding-bottom: 10px;"><b>Phương thức thanh toán:</b> {{$order->payment_method == 1 ? "Thanh toán khi nhận hàng (COD)." : "Chuyển khoản ngân hàng."}} </div>

	    				@if ($order->payment_method == 2)
	    				<div style="padding-bottom: 10px;">
	    					<b>Thông tin tài khoản:</b>
	    					<ul style="margin: 0;">
	    						<li><b>Số tài khoản:</b> 0071001101266</li>
	    						<li><b>Tên tài khoản:</b> Công Ty TNHH R Books</li>
	    						<li><b>Tên ngân hàng:</b> Vietcombank</li>
	    						<li><b>Chi nhánh:</b> Hồ Chí Minh</li>
	    					</ul>
	    				</div>
	    				@endif

	    				<div style="padding-bottom: 10px;"><b>Thời gian giao hàng dự kiến:</b> dự kiến giao hàng {{ Carbon\Carbon::create()->addDays(4)->format('d/m/Y') }}
	    				</div>
						<div><b>Phí vận chuyển:</b> {{ number_format($order->ship_total) }} ₫ </div>
	    			</div>
	    		</div>
	    	</article>

	    	<article>

	    		<h3 style="border-bottom: 2px solid #ddd; color: #283b91">CHI TIẾT ĐƠN HÀNG</h3>

	    		<table class="table table-hover detail-order" style="font-size: 13px; width: 100%;">
	    			<thead>
	    				<tr style="background-color: #283b91; color: #fff;">
	    					<th style="width: 30%;">Sản phẩm</th>
	    					<th style="width: 12%;">Đơn giá</th>
	    					<th style="width: 5%;">SL</th>
	    					<th style="width: 12%;">Giá bán</th>
	    					<th style="width: 13%;">Khuyến mãi</th>
	    					<th style="width: 15%;">Tiết kiệm</th>
	    					<th>Tạm tính</th>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				{{-- vòng lặp --}}
	    				@foreach($order->products as $product)
	    				<tr style="font-size: 12px">
	    					<td style="text-align: left;"><b>{{ $product->name }}</b></td>
	    					<td style="text-align: right;">{{ number_format($product->pivot->price) }} ₫</td>
	    					<td style="text-align: center;">{{ $product->pivot->quantity }}</td>
							<td style="text-align: right;">{{ number_format($product->pivot->price * $product->pivot->quantity)}} ₫</td>
							<td style="text-align: right;">{{ number_format($product->pivot->total) }} ₫</td>
	    					<td style="text-align: center;">{{ number_format($product->pivot->discount) }}% ({{ number_format($product->pivot->discount_total) }} ₫)</td>
	    					<td style="text-align: right;">{{ number_format($product->pivot->total) }} ₫</td>
	    				</tr>
	    				@endforeach
	    				{{-- hết  vòng lặp --}}
	    			</tbody>
	    		</table>

	    		<table class="table table-hover" style="width: 100%; padding-top: 20px; font-size: 13px;">
	    			<tbody>
	    				<tr>

		    				<td width="20%"></td>
		    				<td width="20%"></td>
	                        <td width="30%">
	                            <ul style="list-style: none; padding-left: 0; margin: 0;">
	                            	<li>
	                                    <b>Tổng giá bán: </b>
	                                </li>
	                                <li>
	                                    <b>Tiết kiệm: </b>
	                                </li>
	                                <li>
	                                    <b>Thành tiền: </b>
	                                </li>
	                                <li>
	                                    <b>Phí vận chuyển: </b>
	                                </li>
	                                <li style="font-weight: bold; font-size: 15px;">
	                                    Tổng cộng:
	                                </li>
	                            </ul>
	                        </td>
	                        <td width="30%">
	                            <ul style="list-style: none; padding-left: 0; text-align: right; margin: 0;">
	                            	<li>
	                                    {{ number_format($order->sub_total) }} ₫
	                                </li>
	                                <li>
	                                    {{ round((1-(($order['sub_total'] - $order['tax_total']) / $order['sub_total'])) * 100, 0) }}%

	                                	({{ number_format($order->tax_total) }} ₫)
	                                </li>
	                                <li>
	                                    {{ number_format(($order->sub_total) - ($order->tax_total)) }} ₫
	                                </li>
	                                <li>
	                                    {{ number_format($order->ship_total) }} ₫
	                                </li>
	                                <li style="font-weight: bold;">
	                                    {{ number_format($order->total) }} ₫
	                                </li>
	                            </ul>
	                        </td>

	    				</tr>
	    			</tbody>
	    		</table>

	    	</article>
	    </section>

	    <footer>
	    	<div style="padding-top: 20px;">
				<div style="text-align: justify;">
					Hệ thống mong sớm nhận được đồng ý phê duyệt từ Giám đốc để đơn hàng được giao đến khách hàng trong thời gian sớm nhất.
				</div>

				<div style="margin-top: 10px; font-weight: bold;">Trân trọng cảm ơn!</div>
	    	</div>

	    	<div class="button-box">
	    		<a class="button-email" href="{{ route('orders-cancel', ['id' => $order->id]) }}">Không duyệt</a>

				<a class="button-email" href="{{ route('orders-accept', ['id' => $order->id]) }}">Đồng ý duyệt</a>
	    	</div>

	    	<div style="width: 30%; float: right; padding-top: 60px;">
	    		<img src="https://rbooks.vn/imgs/logo_blue.png" alt="" style="width: 100%;">
	    	</div>
	    </footer>

	</div>
</body>
</html>

