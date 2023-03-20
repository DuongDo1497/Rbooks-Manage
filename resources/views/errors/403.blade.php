<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

<style>
	.wrapper-403{
		height: 100%;
		position: relative;
	}

	.wrapper-403 .title {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		-webkit-transform: translate(-50%, -50%);
		-moz-transform: translate(-50%, -50%);
	}

	.wrapper-403 .title h1{
		font-size: 150px;
		text-align: center;
	}

	.wrapper-403 .title h3{
		padding-bottom: 40px;
		text-align: center;
	}

	.button > a{
		margin-right: 15px;
	}

	.button > a,
	.button > button{
		background-color: #3d5c5c;
    	border: 1px solid #3d5c5c;
	}

	.button > a:hover,
	.button > button:hover{
		background-color: transparent;
		color: #3d5c5c;
	}
</style>


<div class="wrapper-403">
	<div class="title">
		<h1>403</h1>
		<h3>Truy cập bị cấm</h3>
		<div class="button">
			<a href="{{route ('logout')}}" class="btn btn-primary btn-lg">Đăng xuất</a>
			<button onclick="goBack()" class="btn btn-primary btn-lg">Quay về trang trước</button>
		</div>
	</div>
</div>

<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script>
	function goBack() {
		window.history.back();
	}
</script>