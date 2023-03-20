<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
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
    		border-width: 6px;
		    border-style: double;
		    border-color: #000;
		}

		.content .im{
			color: #000;
		}

		.content section{
			margin: 0 45px;
		}

		table {
			width: 100%;
			margin-left: 30px;
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
  				<div class="logo-header">
  					<img src="https://rbooks.vn/public/imgs/banners/RB-header-email.png" alt="" width="768px">
  				</div>
	    	</header>
		    <section>
		    	<article>
		    		<!-- <div style="text-align: center;">
		    			<h1 style="font-size: 30px; color: #283b91;">
		    				<b>HỆ THỐNG GỬI MAIL TỰ ĐỘNG</b>
		    			</h1>
		    		</div> -->
		    	</article>
		    	<article class="pt-3">
		    		<!-- <h3 style="border-bottom: 2px solid #ddd; color: #283b91; font-size: 17px;">GIỚI THIỆU SÁCH</h3> -->
		    		<p>Chào {{ $fullname }}</p>
					<p>Cảm ơn bạn vì thời gian qua vẫn luôn theo dõi và ủng hộ sách RBooks.</p>
					<p>Nếu bạn quan tâm đến việc quản lý Tài Chính Cá Nhân , RBooks có một ưu đãi siêu HOT cho bạn đây.</p>
					<p>SALE UP TO  30% !!!</p>

		    		<p>{!! $content !!}</p>
		    		<!-- <h3 style="border-bottom: 2px solid #ddd; color: #283b91; font-size: 17px;">THÔNG TIN SÁCH</h3> -->
		    	</article>
		    </section>
		    <footer style="margin-top: 40px;">
  				<div class="logo-footer">
  					<img src="https://rbooks.vn/public/imgs/banners/RB-footer-email.png" alt="" width="768px">
  				</div>
	    	</footer>
		</div>
</body>

</html>