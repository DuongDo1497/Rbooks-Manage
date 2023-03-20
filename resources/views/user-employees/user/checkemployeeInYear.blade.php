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
				<h3 class="box-title">THEO DÕI NGHỈ PHÉP</h3>
			</div>
			<div class="box-body">
				<div class="title-status">
					<h5>Trạng thái phép:</h5>
				</div>
				<div class="status">
					<div class="status-1 clearfix">
						<div class="status-item">
							<span>Phép năm:</span>
							<span>{{ $checkemployee_user->employee()->first()->emplperday()->first() == NULL ? "-" : $checkemployee_user->employee()->first()->emplperday()->first()->permission_curryear }}</span>
						</div>
						<div class="status-item">
							<span>Phép tồn năm trước:</span>
							<span>{{ $checkemployee_user->employee()->first()->emplperday()->first() == NULL ? "-" : $checkemployee_user->employee()->first()->emplperday()->first()->permission_lastyear }}</span>
						</div>
					</div>
					<div class="status-2 clearfix">
						<div class="status-item">
							<span>Phép đã nghỉ:</span>
							<span>{{ $checkemployee_user->employee()->first()->emplperday()->first() == NULL ? "-" : $checkemployee_user->employee()->first()->emplperday()->first()->permission_leave }}</span>
						</div>
						<div class="status-item">
							<span>Phép còn lại:</span>
							<span>{{ $checkemployee_user->employee()->first()->emplperday()->first() == NULL ? "-" : $checkemployee_user->employee()->first()->emplperday()->first()->permission_left }}</span>
						</div>
					</div>
					<div class="registration">
		                <a href="#" data-toggle="modal" data-target="#getFormAddEmployee" class="btn btn-primary btn-registration checkemployeeInYear">Đăng ký nghỉ phép</a>
		            </div>
				</div>
			</div>
			<div class="box-footer" style="max-height: 610px; overflow-y: auto;">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Ngày/Lý do</th>
							<th width="60%">Thông tin chi tiết</th>
							<th>Người duyệt (Chờ)</th>
						</tr>
					</thead>
					<tbody>
						@if($checkemployee_user->employee()->first()->checkemployee()->count() === 0)
							<tr>
                                <td colspan="8"><b>Chưa nghỉ ngày nào!!!</b></td>
                            </tr>
                        @endif

                        @foreach($checkemployee_user->employee()->first()->checkemployee()->get() as $checkemployee_user)
							<tr>
								<td style="text-align: center;">
									<p>Nghỉ phép</p>
									<p>{{ date("d/m/Y", strtotime($checkemployee_user->created_at)) }}</p>
								</td>
								<td>
									<p>
										Từ ngày: <span>{{ date("d/m/Y", strtotime($checkemployee_user->fromdate)) }} 08:00 AM</span> - Tới ngày: <span>{{ date("d/m/Y", strtotime($checkemployee_user->todate)) }} 05:00 PM</span>
									</p>
									<p>Số ngày nghỉ: {{ $checkemployee_user->numday }}</p>
									<p>Lý do nghỉ: {{ $checkemployee_user->description }}</p>
									@if($checkemployee_user->status == 0)
										<p><b class="alert-warning">Đang chờ</b></p>
									@elseif($checkemployee_user->status == 1)
										<p><b class="alert-success">Đã duyệt</b></p>
									@else
										<p><b class="alert-danger">Không duyệt</b></p>
									@endif
								</td>
								@if($checkemployee_user->users()->first() == NULL)
									<td style="text-align: center;"></td>
								@else
									<td style="text-align: center;">{{ $checkemployee_user->users()->first()->name }}</td>
								@endif
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@include('company-manage.checkemployee.add')
@endsection

@section('scripts')
<script>
    $(function() {

    });
</script>
@endsection
