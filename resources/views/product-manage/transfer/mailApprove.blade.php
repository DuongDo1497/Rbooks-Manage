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
		.transferer{
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
			color: #fff !transferant;
			display: inline-block;
			width: 45%;
			margin-top: 15px;
			text-decoration: none;
			text-align: center;
		}

		.button-box .button-email:hover{
			background-color: #fff;
    		color: #3d5c5c !transferant;
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
	    		<h1 style="text-align: center; color: #283b91">THÔNG BÁO ĐỀ XUẤT NHẬP HÀNG</h1>

	    		<div>
	    			<p>
	    				Kính gửi: Bà Phạm Thị Ngọc Châu – Giám đốc Công ty TNHH R Books.
	    			</p>
	    			<div style="text-align: justify;">
	    				Hệ thống quản lý chuyển kho RBooks trân trọng thông báo chuyển kho #{{ $transfer->code_transfer }} chuyển từ kho <b>{{ $transfer->warehousefrom->name }} </b> đến <b> {{ $transfer->warehouseto->name }} </b> vào lúc {{ date("d/m/Y - H:i:s", strtotime($transfer->date_transfer)) }}.
	    			</div>
	    		</div>

	    		<h3 style="border-bottom: 2px solid #ddd; color: #283b91">THÔNG TIN CHUYỂN KHO</h3>

	    		<div>
	    			<div class="info transferer">
	    				<h3>Thông tin người chuyển</h3>
	    				<div>
							<div><b>Tên nhân viên: </b> {{ $transfer->users()->first()->employee()->first()->fullname }}</div>
							<div><b>Chức vụ: </b> {{ $transfer->users()->first()->employee()->first()->position()->first()->name }} </br>
								Phòng/ban: {{ $transfer->users()->first()->employee()->first()->department()->first()->name }}</div>
							<div><b>Email: </b> {{ $transfer->users()->first()->email }}</div>
						</div>
	    			</div>
	    			<div class="info address">
	    				<h3>Kho nhập vào</h3>
	    				<div>
	    					<div>{{ $transfer->warehouseto->name }} </div>
	    					<div>Địa chỉ: {{ $transfer->warehouseto->address }}</div>
	    					<div>Thời gian: {{ date("d/m/Y - H:i:s", strtotime($transfer->date_transfer)) }}</div>
	    				</div>
	    			</div>
	    		</div>
	    	</article>
	    	
	    	<article>

	    		<h3 style="border-bottom: 2px solid #ddd; color: #283b91">CHI TIẾT ĐƠN HÀNG</h3>

	    		<div>
					<div>Mã chuyển kho: {{ $transfer->code_transfer }}</div>
					<div>Tổng số lượng: {{ $transfer->quantity }} cuốn</div>
					<div>Tổng giá trị đơn hàng: {{ number_format($transfer->total) }} đồng</div>
				</div>

	    		<table class="table table-hover detail-order" style="font-size: 13px; width: 100%;">
	    			<thead>
	    				<tr style="background-color: #283b91; color: #fff;">
	    					<th>STT</th>
	    					<th style="width: 45%;">Tựa sách</th>
	    					<th style="width: 15%;">ĐVT</th>
	    					<th style="width: 15%;">Số lượng</th>
	    					<th style="width: 20%;">Giá bìa</th>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				@php
	    					$i = 1
	    				@endphp
	    				@foreach($transfer->products as $product)
	    				<tr>
	    					<td style="text-align: center;">{{ $i }}</td>
	    					<td>{{ $product->name }}</td>
	    					<td style="text-align: center;">{{ $product->quantitative }}</td>
	    					<td style="text-align: right;">{{  $product->pivot->quantity }}</td>
	    					<td style="text-align: right;">{{  number_format($product->pivot->total) }} ₫</td>
	    				</tr>
	    				@php
	    					$i++
	    				@endphp
	    				@endforeach
	    			</tbody>
	    		</table>

	    	</article>
	    </section>

	    <footer>
	    	<div class="button-box">
	    		<a class="button-email" href="{{ route('transfers-accept', ['id' => $transfer->id]) }}">Đồng ý duyệt</a>
	    		<a class="button-email" href="{{ route('transfers-cancel', ['id' => $transfer->id]) }}">Không duyệt</a>
	    	</div>
	    	<div style="width: 30%; float: right; padding-top: 60px;">
	    		<img src="https://rbooks.vn/imgs/logo_blue.png" alt="" style="width: 100%;">
	    	</div>
	    </footer>

	</div>
</body>
@if(Session::has('jsAlert'))

<script type="text/javascript" >
    alert({{ session()->get('jsAlert') }});
</script>

@endif
</html>

