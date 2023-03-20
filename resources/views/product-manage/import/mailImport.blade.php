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
		.importer{
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
	    		<h1 style="text-align: center; color: #283b91">THÔNG BÁO NHẬP HÀNG</h1>

	    		<div>
	    			<p>
	    				Kính gửi: Bà Phạm Thị Ngọc Châu – Giám đốc Công ty TNHH R Books.
	    			</p>
	    			<div style="text-align: justify;">
	    				Hệ thống quản lý đơn hàng RBooks trân trọng thông báo đơn hàng #603 đã được nhập thành công vào kho <b>RBooks Vinhomes</b> vào lúc 23:28:17 – 03/09/2019.
	    			</div>
	    		</div>

	    		<h3 style="border-bottom: 2px solid #ddd; color: #283b91">THÔNG TIN NHẬP HÀNG</h3>

	    		<div>
	    			<div class="info importer">
	    				<h3>Thông tin người nhập</h3>
	    				<div>
							<div><b>Tên nhân viên: </b> Trần Đình Phúc</div>
							<div><b>Chức vụ: </b> Nhân viên Sales</div>
							<div><b>Email: </b> sale1@lamians.com</div>
						</div>
	    			</div>
	    			<div class="info address">
	    				<h3>Địa chỉ nhập hàng</h3>
	    				<div>
	    					<div>Kho RBooks Vinhomes </div>
	    					<div>208 Nguyễn Hữu Cảnh, Quận Bình Thạnh, Hồ Chí Minh, Việt Nam.</div>
	    					<div>Thời gian: 23:28:17 – 03/09/2019</div>
	    				</div>
	    			</div>
	    		</div>
	    	</article>
	    	
	    	<article>

	    		<h3 style="border-bottom: 2px solid #ddd; color: #283b91">CHI TIẾT ĐƠN HÀNG</h3>

	    		<div>
					<div>Mã nhập kho: NRB.603.KhoVH.SLK.ThaiHa/03.09.2019</div>
					<div>Tổng số lượng: 1,200 cuốn</div>
					<div>Tổng giá trị đơn hàng: 88.000.000 đồng</div>
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
	    				<tr>
	    					<td style="text-align: center;">01</td>
	    					<td>Lối sống tối giản của người Nhật</td>
	    					<td style="text-align: center;">Cuốn</td>
	    					<td style="text-align: right;">200</td>
	    					<td style="text-align: right;">95,000 ₫</td>
	    				</tr>
	    			</tbody>
	    		</table>

	    	</article>
	    </section>

	    <footer>
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

