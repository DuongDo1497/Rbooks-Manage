@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <form role="form" action="" method="post" id="receivables_debts-form" enctype="multipart/form-data">
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
                                <label>Mã công nợ</label>
                                <input type="text" class="form-control" placeholder="Nhập mã công nợ phải thu" name="">
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
                                <label>Ngày bắt đầu</label>
                                <input type="date" class="form-control" placeholder="Nhập ngày bắt đầu" name="">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ngày hết hạn</label>
                                <input type="date" class="form-control" placeholder="Nhập ngày hết hạn" name="">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
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
		                        <label>Mã khách hàng (nếu có)</label>
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
                                <label>Tổng số lượng (nếu có)</label>
                                <input type="number" class="form-control" placeholder="Nhập số lượng" name="">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Đơn vị tính</label>
                                <input type="text" class="form-control" placeholder="Nhập đơn vị tính" name="">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Thuế VAT</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" placeholder="Nhập" name="" min="1" max="3">
                                    <div class="input-group-addon">%</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
		                    <div class="form-group">
		                        <label>Tổng số tiền phải thu (Không VAT)</label>
		                        <div class="input-group">
		                            <input type="number" class="form-control" placeholder="Nhập số tiền" name="">
		                            <div class="input-group-addon">VNĐ</div>
		                        </div>
		                    </div>
		                </div>

	                    <div class="col-md-6">
		                    <div class="form-group">
		                        <label>Tổng số tiền phải thu (VAT)</label>
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
                                <label>Tổng số tiền đã trả (Không VAT)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" placeholder="Nhập số tiền" name="">
                                    <div class="input-group-addon">VNĐ</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tổng số tiền đã trả (VAT)</label>
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
                                <label>Tổng dư nợ (Không VAT)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" placeholder="Nhập số tiền" name="">
                                    <div class="input-group-addon">VNĐ</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tổng dư nợ (VAT)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" placeholder="Nhập số tiền" name="">
                                    <div class="input-group-addon">VNĐ</div>
                                </div>
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
		                        <label>Người quản lý công nợ (nếu có)</label>
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
                    <h3 class="box-title">Trạng thái</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <select class="form-control select2" name="">
                            <option value="">Chọn</option>
                            <option value="">Chưa thu</option>
                            <option value="">Thu từng phần</option>
                            <option value="">Đã thu</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Chức năng</h3>
                </div>
                <div class="box-body">
                    <button type="submit" class="btn btn-primary btn-save" tabindex="9">Lưu</button>
                    <a href="{{ route('receivables_debts-index') }}" class="btn btn-default btn-cancel" tabindex="10">Trở về</a>
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
            $('#receivables_debts-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#receivables_debts-form').attr('action', '');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#receivables_debts-form').attr('action', '');
        });
    });
</script>
@endsection
