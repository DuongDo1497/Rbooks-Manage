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
		    		<div style="text-align: center;">
		    			<h1 style="font-size: 30px; color: #283b91;">
		    				<b>THÔNG BÁO</b>
		    			</h1>
		    		</div>
		    	</article>
		    	<article class="pt-3">
		    		<h3 style="border-bottom: 2px solid #ddd; color: #283b91; font-size: 17px;">NGƯỜI YÊU CẦU</h3>
		    		<table class="table table-hover">
		    			<tbody>
		    				<tr>
		    					<td width="50%"><b>Nhân viên</b></td>
		    					<td><b>{{ $checkbusiness->employee->id_staff }} - {{ $checkbusiness->employee->fullname }}</b></td>
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

		    		<h3 style="border-bottom: 2px solid #ddd; color: #283b91; font-size: 17px;">THÔNG TIN PHÊ DUYỆT</h3>
		    		<table class="table table-hover">
		    			<tbody>
		    				<tr>
		    					<td width="50%"><b>Ngày yêu cầu</b></td>
		    					<td>{{ date("d-m-Y", strtotime($checkbusiness->created_at)) }}</td>
		    				</tr>
		    				<tr>
		    					<td width="50%"><b>Ngày phê duyệt</b></td>
		    					<td>{{ date("d-m-Y", strtotime($checkbusiness->approved_at)) }}</td>
		    				</tr>
		    				<tr>
		    					<td width="50%"><b>Người phê duyệt</b></td>
		    					<td><b style="text-transform: capitalize;">{{ $checkbusiness->users()->first() == null ? '' : $checkbusiness->users()->first()->name }}</b></td>
		    				</tr>
		    				<tr>
		    					<td width="50%"><b>Trạng thái phê duyệt</b></td>
		    					<td>
		    						<b>
		    							@if($checkbusiness->status == 1)
					    					<span style="color: #3c763d;">ĐÃ DUYỆT</span>
					    				@else($checkbusiness->status == 2)
					    					<span style="color: red;">KHÔNG DUYỆT</span>
					    				@endif
		    						</b>
		    					</td>
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
		    					<td>{{ date("d-m-Y", strtotime($checkbusiness->fromdate)) }}</td>
		    				</tr>
		    				<tr>
		    					<td width="50%"><b>Công tác tới ngày</b></td>
		    					<td>{{ date("d-m-Y", strtotime($checkbusiness->todate)) }}</td>
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