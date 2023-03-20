@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@section('content')
@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<i class="fa fa-plane"></i>
				<h3 class="box-title">THEO DÕI ĐI CÔNG TÁC</h3>
			</div>
			<div class="box-body">
				<div class="status">
					<div class="registration" style="margin-left: -10px;">
		                <a href="#" data-toggle="modal" data-target="#getFormAddBusiness" class="btn btn-primary btn-registration">Đăng ký công tác</a>
		            </div>
				</div>
			</div>
			<div class="box-footer" style="max-height: 610px; overflow-y: auto;">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Ngày/Lý do</th>
							<th width="45%">Thông tin chi tiết</th>
							<th width="15%">Công việc cụ thể</th>
							<th>Người duyệt (Chờ)</th>
						</tr>
					</thead>
					<tbody>
					@if($checkbusiness_user->employee()->first()->checkbusiness()->count() === 0)
                        <tr>
                            <td colspan="8"><b>Chưa công tác ngày nào!!!</b></td>
                        </tr>
                    @endif
					@foreach($checkbusiness_user->employee()->first()->checkbusiness()->get() as $checkbusiness)
						<tr>
							<td style="text-align: center;">
								<p>{{  $checkbusiness->checktype()->first() == NULL ? "" : $checkbusiness->checktype()->first()->discription }}</p>
								<p>{{ date("d/m/Y", strtotime($checkbusiness->created_at)) }}</p>
							</td>
							<td>
								<p>
									Từ ngày: <span>{{ date("d/m/Y", strtotime($checkbusiness->fromdate)) }}</span> - Tới ngày: <span>{{ date("d/m/Y", strtotime($checkbusiness->todate)) }}</span>
								</p>
								<p>Nơi công tác: {{ $checkbusiness->place }}</p>
								<p>Phương tiện: {{ $checkbusiness->transportation }}</p>
								@if($checkbusiness->status == 1)
									<p><b class="alert-success">Đã duyệt</b></p>
								@elseif($checkbusiness->status == 2)
									<p><b class="alert-danger">Không duyệt</b></p>
								@else
									<p><b class="alert-warning">Chưa duyệt</b></p>
								@endif
							</td>
							<td>{{ $checkbusiness->description }}</td>
							<td style="text-align: center;">{{  $checkbusiness->users()->first() == NULL ? "" : $checkbusiness->users()->first()->name }}</td>
						</tr>
					@endforeach()
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@include('company-manage.checkbusiness.add')
@endsection

@section('scripts')
<script>
    $(function() {

    });
</script>
@endsection
