@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <form role="form" action="{{ route('cptt_dn-store') }}?continue=true" method="post" id="cptt_dn-form" enctype="multipart/form-data">
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
                                <label>Ngày lập phiếu chi</label>
                                <input type="date" class="form-control" placeholder="Nhập ngày lập phiếu chi" name="date_created">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>Mục chi</label>
		                         <select class="form-control select2" name="itemcost">
		                            <option value="">Chọn</option>
		                            <option value="Chi phí Nhân sự">Chi phí Nhân sự</option>
		                            <option value="Chi phí thuê văn phòng">Chi phí thuê văn phòng</option>
		                            <option value="Chi phí văn phòng phẩm">Chi phí văn phòng phẩm</option>
		                        </select>
		                    </div>
                    	</div>
                	</div>

                	<div class="row">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>Hình thức phiếu chi</label>
		                         <select class="form-control select2" name="methodcost">
		                            <option value="">Chọn</option>
		                            <option value="Tiền mặt">Tiền mặt</option>
		                            <option value="Chuyển khoản">Chuyển khoản</option>
		                        </select>
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>Loại phiếu chi</label>
		                         <select class="form-control select2" name="type_cost">
		                            <option value="">Chọn</option>
		                            <option value="Phiếu chi thanh toán">Phiếu chi thanh toán</option>
		                            <option value="Phiếu chi công nợ">Phiếu chi công nợ</option>
		                            <option value="Khác">Khác</option>
		                        </select>
		                    </div>
                    	</div>
                    </div>

                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin phiếu chi</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>Mã nhà cung cấp/Người bán</label>
		                        <input type="text" class="form-control" placeholder="Nhập mã nhà cung cấp/Người bán" name="supplier_code">
		                        @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
		                    </div>
                    	</div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tên nhà cung cấp/Người bán</label>
                                <input type="text" class="form-control" placeholder="Nhập tên nhà cung cấp/Người bán" name="supplier_name">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Điện thoại</label>
                                <input type="number" class="form-control" placeholder="Nhập số điện thoại" name="supplier_phone">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <input type="text" class="form-control" placeholder="Nhập địa chỉ" name="supplier_address">
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
		                        <label>Tổng số tiền (Không VAT)</label>
		                        <div class="input-group">
		                            <input type="number" class="form-control" placeholder="Nhập số tiền" name="notvatcost">
		                            <div class="input-group-addon">VNĐ</div>
		                        </div>
		                    </div>
		                </div>

		                <div class="col-md-2">
		                    <div class="form-group">
		                        <label>Thuế VAT</label>
		                        <div class="input-group">
		                            <input type="number" class="form-control" placeholder="Nhập" name="vat">
		                            <div class="input-group-addon">%</div>
		                        </div>
		                    </div>
		                </div>

	                    <div class="col-md-5">
		                    <div class="form-group">
		                        <label>Tổng số tiền (VAT)</label>
		                        <div class="input-group">
		                            <input type="number" class="form-control" placeholder="Nhập số tiền" name="vatcost">
		                            <div class="input-group-addon">VNĐ</div>
		                        </div>
		                    </div>
		                </div>
	                </div>

	                <div class="row">

                    	<div class="col-md-6">
		                    <div class="form-group">
		                        <label>Số lượng (nếu có)</label>
		                        <input type="number" class="form-control" placeholder="Nhập số lượng" name="quantity">
                        		@if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
		                    </div>
		                </div>

	                    <div class="col-md-6">
		                    <div class="form-group">
		                        <label>Đơn vị</label>
		                        <input type="text" class="form-control" placeholder="Nhập đơn vị tính" name="unit">
                        		@if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
		                    </div>
		                </div>
	                </div>

                    <!-- <div class="form-group">
                        <label>Mã chứng từ</label>
                        <input type="text" class="form-control" placeholder="Nhập mã chứng từ" name="">
                        @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                    </div> -->

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Hồ sơ chi</label>
                                <textarea class="form-control" placeholder="Nhập hồ sơ chi" rows="4" name="file_cost"></textarea>
                            </div>
                        </div>
                    	<div class="col-md-4">
                    		<div class="form-group">
		                        <label>Nội dung phiếu chi</label>
		                        <textarea class="form-control" placeholder="Nhập nội dung phiếu chi" rows="4" name="content"></textarea>
		                    </div>
                    	</div>
                    	<div class="col-md-4">
                    		<div class="form-group">
		                        <label>Ghi chú</label>
		                        <textarea class="form-control" placeholder="Nhập ghi chú" rows="4" name="note"></textarea>
		                    </div>
                    	</div>
                    </div>

                    <div class="row">

                    	<div class="col-md-6">
	                        <div class="form-group">
		                        <label>Người lập phiếu chi</label>
		                        <select class="form-control select2" name="creator_cost">
		                            <option value="">Chọn</option>
                                    @foreach($accounting_employee as $accounting)
		                            <option value="{{ $accounting->id }}">{{ $accounting->fullname }}</option>
                                    @endforeach
		                        </select>
		                    </div>
		                </div>

	                    <div class="col-md-6">
	                        <div class="form-group">
		                        <label>Người phụ trách</label>
		                        <select class="form-control select2" name="person_in">
		                            <option value="">Chọn</option>
		                            @foreach($accounting_employee as $accounting)
                                    <option value="{{ $accounting->id }}">{{ $accounting->fullname }}</option>
                                    @endforeach
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
                    <a href="{{ route('cptt_dn-index') }}" class="btn btn-default btn-cancel" tabindex="10">Trở về</a>
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
            $('#cptt_dn-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#cptt_dn-form').attr('action', '');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#cptt_dn-form').attr('action', '');
        });
    });
</script>
@endsection
