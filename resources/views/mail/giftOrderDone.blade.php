<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
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
	        font-family: Arial,Helvetica,sans-serif;
    		font-size: 12px;
		}
		table {
			width: 100%;
		}

		.img-logo {
			width: 170px;
			height: 80x;
		}
		.logo {
			width: 445px;
		}
		.app {
			width: 171px;
		}
		.google {
			width: 150px;
		}
		.head{
			float: left;
		}

		.info{
			float: left;
		}
		.payment{
			width: 50%;
		}
		.address{
			width: 50%;
		}
    </style>
</head>
<body>
	<div class="content">
  		<header>
  			<div>
  				<div class="head logo">
  					<a href="rbooks.vn"><img class="img-logo" src="https://d15k2d11r6t6rl.cloudfront.net/public/users/Integrators/BeeProAgency/238386_215831/logo%20%281%29.png" alt=""></a>
  				</div>
  				<div class="head app">
					<img  class="img-fluid" src="https://d15k2d11r6t6rl.cloudfront.net/public/users/Integrators/BeeProAgency/218246_195341/app.jpg" alt="">
				</div>
				<div class="head google">
					<img class="img-fluid" src="https://d15k2d11r6t6rl.cloudfront.net/public/users/Integrators/BeeProAgency/218246_195341/google.jpg" alt="">
				</div>
  			</div>
  			<hr>
    	</header>
	    <section>
	    	<br>
	    	<article>
	    		<div>
	    			<h3 class="font-weight-bold pt-3">
	    				Đơn hàng đã hoàn thành !
	    			</h3>
	    			<div>
	    				RBooks.vn rất vui thông báo đơn hàng <b>#{{ $order->gift->gift_number }}</b> đã được vận chuyển đến địa chỉ nhận hàng của quý khách. Trong quá trình sử dụng có thắc mắc hoặc vấn đề xảy ra mong quý khách liên hệ cho bộ phận hỗ trợ khách hàng của RBooks. 
	    				<h3>RBooks.vn rất cảm ơn quý khách khi mua hàng tại RBooks.</h3>
	    			</div>
	    		</div>
	    	</article>
	    	<article class="pt-3">
	    		<h3 style="border-bottom: 2px solid #ddd; color: #189eff">CHI TIẾT ĐƠN HÀNG</h3>
	    		<table class="table table-hover">
	    			<thead>
	    				<tr style="background-color: #189eff">
	    					<th>Sản phẩm</th>
	    					<th>Đơn giá</th>
	    					<th>Số lượng</th>
	    					<th>Tổng tạm</th>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				{{-- vòng lặp --}}
	    				@foreach($order->products as $product)
	    				<tr>
	    					<td>{{ $product->name }}</td>
	    					<td align="center">{{ number_format($product->pivot->price) }}</td>
	    					<td align="center">{{ $product->pivot->quantity }}</td>
	    					<td align="center">{{ number_format($product->pivot->price * $product->pivot->quantity) }}</td>
	    				</tr>
	    				@endforeach
	    				{{-- hết  vòng lặp --}}
	    			</tbody>
	    			<tfoot>
	    				<td></td>
                            <td></td>
                            <td>
                                <ul style="list-style: none;">
                                    <li>
                                        <b>Tổng tạm tính: </b>
                                    </li>
                                    <li>
                                        <b>Phí vận chuyển: </b>
                                    </li>
                                    @if($order->gift_fee == 20000)
                                    <li>
                                        <b>Phí gói quà: </b>
                                    </li>
                                    @endif
                                    <li>
                                        <b>Tổng cộng: </b>
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul style="list-style: none;">
                                    <li>
                                        {{ number_format($order->sub_total) }} ₫
                                    </li>
                                    <li>
                                        {{ number_format($order->ship_total) }} ₫
                                    </li>
                                    @if($order->gift_fee == 20000)
                                    <li>
                                        {{ number_format($order->gift_fee) }} ₫
                                    </li>
                                    @endif
                                    <li class="h4 text-danger">
                                        {{ number_format($order->total) }} ₫
                                    </li>
                                </ul>
                            </td>
	    			</tfoot>
	    		</table>
	    	</article>
	    	<div style="padding-left: 5px">
	    		<div></div>
				<div>
					Mọi thắc mắc, quý khách vui lòng liên hệ info@rbooks.vn, hoặc gọi số điện thoại 08 4966 4005 (8h-21h cả T7,CN) để tư vấn tốt nhất từ nhân viên chăm sóc khách hàng.
				</div>
				<div>RBooks.vn cảm ơn quý khách!</div>
	    	</div>
	    </section>
	</div>
</body>
</html>