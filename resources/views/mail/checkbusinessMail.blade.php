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
  					<img src="https://rbooks.vn/public/imgs/banners/RB-header-email.png" alt="" width="100%">
  				</div>
	    	</header>
		    <section>
		    	<article>
		    		<div style="text-align: center;">
		    			<h1 style="font-size: 30px; color: #283b91;">
		    				<b>ĐĂNG KÝ CÔNG TÁC ONLINE</b>
		    			</h1>
		    		</div>
		    	</article>
		    	<article class="pt-3">
		    		<h3 style="border-bottom: 2px solid #ddd; color: #283b91; font-size: 17px;">THÔNG TIN NHÂN SỰ</h3>
		    		<table class="table table-hover">
		    			<tbody>
		    				<tr>
		    					<td width="50%"><b>Nhân viên</b></td>
		    					<td><b>{{ $checkbusiness->employee->fullname }}</b></td>
		    				</tr>
		    				<tr>
		    					<td width="50%"><b>Mã nhân viên</b></td>
		    					<td><b>{{ $checkbusiness->employee->id_staff }}</b></td>
		    				</tr>
		    				<tr>
		    					<td width="50%"><b>Phòng ban</b></td>
		    					<td>{{ $checkbusiness->department->name }}</td>
		    				</tr>
		    				<tr>
		    					<td width="50%"><b>Chức vụ</b></td>
		    					<td>{{ $checkbusiness->employee->position->name }}</td>
		    				</tr>
		    			</tbody>
		    		</table>
		    		<h3 style="border-bottom: 2px solid #ddd; color: #283b91; font-size: 17px;">THÔNG TIN CÔNG TÁC</h3>
		    		<table class="table table-hover">
		    			<tbody>
		    				<tr>
		    					<td width="50%"><b>Công việc cụ thể</b></td>
		    					<td>{{ $checkbusiness->description }}</td>
		    				</tr>
		    				<tr>
		    					<td width="50%"><b>Công tác từ ngày</b></td>
		    					<td>{{ date("d-m-yy", strtotime($checkbusiness->fromdate)) }} {{ $checkbusiness->fromtime }}</td>
		    				</tr>
		    				<tr>
		    					<td width="50%"><b>Công tác tới ngày</b></td>
		    					<td>{{ date("d-m-yy", strtotime($checkbusiness->todate)) }} {{ $checkbusiness->totime }}</td>
		    				</tr>
		    				<tr>
		    					<td width="50%"><b>Nơi công tác</b></td>
		    					<td>{{ $checkbusiness->place }}</td>
		    				</tr>
		    				<tr>
		    					<td width="50%"><b>Phương tiện công tác</b></td>
		    					<td>{{ $checkbusiness->transportation }}</td>
		    				</tr>
		    			</tbody>
		    		</table>
		    		<table class="table table-hover" style="margin-left: 0;">
		    			<tbody>
		    				<tr style="text-align: center;">
		    					<td>
		    						<ul style="list-style-type: none; margin: 0; padding: 0;">
		    							<li style="margin-left: 0;">
		    								<a style="border-radius: 5px;background: #00a65a; border: none;padding: 10px 10px; color: #fff;display: block; width: 300px;margin: 0 auto; margin-top: 15px;text-decoration: none;" href="{{ route('checkbusiness-index') }}">Nhấp vào đây để xét duyệt trên hệ thống</a>
		    							</li>
		    						</ul>
		    					</td>
		    				</tr>
		    			</tbody>
		    		</table>
		    	</article>
		    </section>
		    <footer style="margin-top: 40px;">
  				<div class="logo-footer">
  					<img src="https://rbooks.vn/public/imgs/banners/RB-footer-email.png" alt="" width="768px">
  				</div>
	    	</footer>
		</div>
</body>
<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#checkbusiness-form').submit();
        });
    });
</script>

</html>