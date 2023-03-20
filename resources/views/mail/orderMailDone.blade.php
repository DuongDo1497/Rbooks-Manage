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
	    		<div>
	    			<p>
	    				Cảm ơn quý khách {{ $order->billingaddress->fullname }} đã tin tưởng đặt hàng tại <b>RBooks.vn</b>!
	    			</p>
	    			<div style="text-align: justify;">
						RBooks rất vui thông báo đơn hàng #{{ $order->id }} đã được đơn vị vận chuyển giao hàng thành công đến quý khách vào lúc {{ date("d/m/Y", strtotime($order->updated_at)) }}.
	    			</div>
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

	    		<table class="table table-hover" style="font-size: 13px; width: 100%;">
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
					<p>uý khách vui lòng kiểm tra chính xác thông tin đơn hàng. Mọi thắc mắc, quý khách vui lòng liên hệ info@rbooks.vn, hoặc gọi số điện thoại <b>08 4966 4005</b> (8h-21h cả T7,CN) để được hỗ trợ tốt nhất từ nhân viên chăm sóc khách hàng.</p>
					<p>RBooks rất vui nếu nhận được đánh giá của quý khách tại: https://www.facebook.com/rbooks.vn/</p>
				</div>

				<div style="margin-top: 10px; font-weight: bold;">RBooks trân trọng cảm ơn quý khách! Chúc quý khách có một trải nghiệm thú vị với cuốn sách này!</div>
	    	</div>
	    	<div style="width: 30%; float: right; padding-top: 60px;">
	    		<img src="https://rbooks.vn/imgs/logo_blue.png" alt="" style="width: 100%;">
	    	</div>
	    </footer>
	</div>
</body>
</html>