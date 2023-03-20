@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <form role="form" action="" method="post" id="net_revenue-form" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin chung</h3>
                </div>
                <div class="box-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ngày thu</label>
                                <input type="date" class="form-control" placeholder="Nhập ngày thu" name="">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nguồn thu</label>
                                <select class="form-control select2" name="">
                                    <option value="">Chọn</option>
                                    <option value="">Sách</option>
                                    <option value="">Dịch vụ sách</option>
                                    <option value="">Dịch vụ in ấn</option>
                                    <option value="">Dịch vụ khác</option>
                                </select>
                            </div>
                        </div>
                    </div>

                	<div class="row">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>Hình thức thu</label>
		                         <select class="form-control select2" name="">
		                            <option value="">Chọn</option>
		                            <option value="">Tiền mặt</option>
		                            <option value="">Chuyển khoản</option>
		                        </select>
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>Loại thu</label>
		                         <select class="form-control select2" name="">
		                            <option value="">Chọn</option>
		                            <option value="">Thu thanh toán</option>
		                            <option value="">Thu công nợ</option>
		                            <option value="">Đặt cọc</option>
		                            <option value="">Khác</option>
		                        </select>
		                    </div>
                    	</div>
                    </div>

                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin thanh toán</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                    	<div class="col-md-4">
                    		<div class="form-group">
			                    <label>Bên thanh toán</label>
			                    <select class="form-control select2" name="">
			                        <option value="">Chọn</option>
			                        <option value="">Khách hàng</option>
			                        <option value="">Bên giao thầu</option>
			                        <option value="">Nhân viên</option>
			                        <option value="">Khác</option>
			                    </select>
			                </div>
                    	</div>
                    	<div class="col-md-4">
                    		<div class="form-group">
		                        <label>Mã khách hàng</label>
		                        <input type="text" class="form-control" placeholder="Nhập mã khách hàng" name="">
		                        @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
		                    </div>
                    	</div>
                    	<div class="col-md-4">
                    		<div class="form-group">
		                        <label>Tên người thanh toán</label>
		                        <input type="text" class="form-control" placeholder="Nhập tên người thanh toán" name="">
		                        @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
		                    </div>
                    	</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Điện thoại</label>
                                <input type="number" class="form-control" placeholder="Nhập số điện thoại" name="">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <input type="text" class="form-control" placeholder="Nhập địa chỉ" name="">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin khác</h3>
                </div>
                <div class="box-body"> 

                    <div class="row">

                    	<div class="col-md-5">
		                    <div class="form-group">
		                        <label>Tổng số tiền thu (Không VAT)</label>
		                        <div class="input-group">
		                            <input type="number" class="form-control" placeholder="Nhập số tiền" name="">
		                            <div class="input-group-addon">VNĐ</div>
		                        </div>
		                    </div>
		                </div>

		                <div class="col-md-2">
		                    <div class="form-group">
		                        <label>Thuế VAT</label>
		                        <div class="input-group">
		                            <input type="number" class="form-control" placeholder="Nhập" name="">
		                            <div class="input-group-addon">%</div>
		                        </div>
		                    </div>
		                </div>

	                    <div class="col-md-5">
		                    <div class="form-group">
		                        <label>Tổng số tiền thu (VAT)</label>
		                        <div class="input-group">
		                            <input type="number" class="form-control" placeholder="Nhập số tiền" name="">
		                            <div class="input-group-addon">VNĐ</div>
		                        </div>
		                    </div>
		                </div>
	                </div>

	                <div class="row">

                    	<div class="col-md-6">
		                    <div class="form-group">
		                        <label>Số lượng (nếu có)</label>
		                        <input type="number" class="form-control" placeholder="Nhập số lượng" name="">
                        		@if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
		                    </div>
		                </div>

	                    <div class="col-md-6">
		                    <div class="form-group">
		                        <label>Đơn vị</label>
		                        <input type="text" class="form-control" placeholder="Nhập đơn vị tính" name="">
                        		@if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
		                    </div>
		                </div>
	                </div>

                    <div class="form-group">
                        <label>Hồ sơ thu</label>
                        <input type="text" class="form-control" placeholder="Nhập hồ sơ thu" name="">
                        @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                    </div>

                    <div class="row">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>Nội dung thu</label>
		                        <textarea class="form-control" placeholder="Nhập nội dung thu" rows="3"></textarea>
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>Ghi chú</label>
		                        <textarea class="form-control" placeholder="Nhập ghi chú" rows="3"></textarea>
		                    </div>
                    	</div>
                    </div>

                    <div class="row">

                    	<div class="col-md-6">
	                        <div class="form-group">
		                        <label>Người thu</label>
		                        <select class="form-control select2" name="">
		                            <option value="">Chọn</option>
		                            <option value="">Phan Văn Công</option>
		                            <option value="">Trương Huỳnh Hoàng Trinh</option>
		                        </select>
		                    </div>
		                </div>

	                    <div class="col-md-6">
	                        <div class="form-group">
		                        <label>Người phụ trách</label>
		                        <select class="form-control select2" name="">
		                            <option value="">Chọn</option>
		                            <option value="">Phan Văn Công</option>
		                            <option value="">Trương Huỳnh Hoàng Trinh</option>
		                        </select>
		                    </div>
		                </div>
	                </div>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Chức năng</h3>
                </div>
                <div class="box-body">
                    <button type="submit" class="btn btn-primary btn-save" tabindex="9">Lưu</button>
                    <a href="{{ route('net_revenues-index') }}" class="btn btn-default btn-cancel" tabindex="10">Trở về</a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">File chứng từ/Hồ sơ đính kèm</h3>
                </div>
                <div class="box-body">
                    <input type="file" name="file">
                    <!-- <p class="text-danger" style="margin-top: 10px;">Lưu ý: Tải file .pdf</p> -->
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#net_revenue-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#net_revenue-form').attr('action', '');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#net_revenue-form').attr('action', '');
        });
    });
</script>
@endsection
