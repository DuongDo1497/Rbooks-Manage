@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <form role="form" action="{{ route('gross_revenues-store') }}?continue=true" method="post" id="gross_revenues-form" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="col-md-8" id="information">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Thông tin chung') }}</h3>
                </div>
                <div class="box-body">

                	<div class="row">
                		<div class="col-md-4">
                    		<div class="form-group">
                                <label>{{ trans('home.Ngày thu') }}</label>
                                <input type="date" class="form-control" placeholder="{{ trans('home.Nhập ngày lập phiếu thu') }}" name="date_create">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                    	</div>
                    	<div class="col-md-4">
                    		<div class="form-group">
		                        <label>{{ trans('home.Loại thu') }}</label>
                                <select class="form-control select2" name="type_revenue">
		                            <option value="">{{ trans('home.Chọn') }}</option>
		                            <option value="1">{{ trans('home.Doanh thu thực tế') }}</option>
		                            <option value="2">{{ trans('home.Công nợ phải thu') }}</option>
		                        </select>
		                    </div>
                    	</div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('home.Nguồn thu') }}</label>
                                <select class="form-control select2" name="itemcost_id">
                                    @foreach($mclists as $mclist)
                                        <option value="{{ $mclist->id }}">{{ $mclist->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                	</div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Ngày bắt đầu') }}</label>
                                <input type="date" class="form-control" placeholder="{{ trans('home.Nhập ngày bắt đầu') }}" name="start_date">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Ngày kết thúc') }}</label>
                                <input type="date" class="form-control" placeholder="{{ trans('home.Nhập ngày kết thúc') }}" name="end_date">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                    </div>

                	<div class="row">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Hình thức thu') }}</label>
		                        <select class="form-control select2" name="method_revenue">
		                            <option value="">{{ trans('home.Chọn') }}</option>
		                            <option value="Tiền mặt">{{ trans('home.Tiền mặt') }}</option>
		                            <option value="Chuyển khoản">{{ trans('home.Chuyển khoản') }}</option>
		                        </select>
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Trạng thái') }}</label>
		                        <select class="form-control select2" name="status">
		                            <option value="">{{ trans('home.Chọn') }}</option>
		                            <option value="1">{{ trans('home.Đã thu') }}</option>
		                            <option value="2">{{ trans('home.Chưa thu') }}</option>
                                    <option value="3">{{ trans('home.Thu từng phần') }}</option>
		                        </select>
		                    </div>
                    	</div>
                    </div>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Thông tin thanh toán') }}</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Mã khách hàng/nhà cung cấp') }}</label>
		                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập mã khách hàng/nhà cung cấp') }}" name="code_customer">
		                        @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
		                    </div>
                    	</div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tên khách hàng/nhà cung cấp') }}</label>
                                <input type="text" class="form-control" placeholder="{{ trans('home.Nhập tên khách hàng/nhà cung cấp') }}" name="name_customer">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Điện thoại') }}</label>
                                <input type="number" class="form-control" placeholder="{{ trans('home.Nhập số điện thoại') }}" name="phone">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Địa chỉ') }}</label>
                                <input type="text" class="form-control" placeholder="{{ trans('home.Nhập địa chỉ') }}" name="address">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                    </div>
            
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Thông tin khác') }}</h3>
                </div>
                <div class="box-body">

	                <div class="row">

                    	<div class="col-md-4">
		                    <div class="form-group">
		                        <label>{{ trans('home.Tổng số lượng (nếu có)') }}</label>
		                        <input type="number" class="form-control" placeholder="{{ trans('home.Nhập số lượng') }}" name="quantity">
                        		@if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
		                    </div>
		                </div>

	                    <div class="col-md-4">
		                    <div class="form-group">
		                        <label>{{ trans('home.Đơn vị') }}</label>
		                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập đơn vị tính') }}" name="unit">
                        		@if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
		                    </div>
		                </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('home.Thuế VAT') }}</label>
                                <div class="input-group addon-right">
                                    <input type="text" class="form-control" placeholder="{{ trans('home.Nhập số phần trăm') }}" name="vat">
                                    <span class="input-group-addon">%</span>
                                </div>
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
	                </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tổng tiền phải thu (không VAT)') }}</label>
                                <div class="input-group addon-right">
                                    <input type="text" class="form-control total-vat" placeholder="{{ trans('home.Nhập số tiền') }}" name="notvat_revenue">
                                    <span class="input-group-addon">VND</span>
                                </div>
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tổng tiền phải thu (có VAT)') }}</label>
                                <div class="input-group addon-right">
                                    <input type="text" class="form-control total-vat" placeholder="{{ trans('home.Nhập số tiền') }}" name="vat_revenue">
                                    <span class="input-group-addon">VND</span>
                                </div>
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tổng tiền đã thu (không VAT)') }}</label>
                                <div class="input-group addon-right">
                                    <input type="text" class="form-control total-vat" placeholder="{{ trans('home.Nhập số tiền') }}" name="dathu_notvat">
                                    <span class="input-group-addon">VND</span>
                                </div>
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tổng tiền đã thu (có VAT)') }}</label>
                                <div class="input-group addon-right">
                                    <input type="text" class="form-control total-vat" placeholder="{{ trans('home.Nhập số tiền') }}" name="dathu_vat">
                                    <span class="input-group-addon">VND</span>
                                </div>
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tổng tiền dư nợ (không VAT)') }}</label>
                                <div class="input-group addon-right">
                                    <input type="text" class="form-control total-vat" placeholder="{{ trans('home.Nhập số tiền') }}" name="conlai_notvat">
                                    <span class="input-group-addon">VND</span>
                                </div>
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tổng tiền dư nợ (có VAT)') }}</label>
                                <div class="input-group addon-right">
                                    <input type="text" class="form-control total-vat" placeholder="{{ trans('home.Nhập số tiền') }}" name="conlai_vat">
                                    <span class="input-group-addon">VND</span>
                                </div>
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
                                <label>{{ trans('home.Hồ sơ thu') }}</label>
                                <textarea class="form-control" placeholder="{{ trans('home.Nhập hồ sơ thu') }}" rows="4" name="file_revenue"></textarea>
                            </div>
                        </div>
                    	<div class="col-md-4">
                    		<div class="form-group">
		                        <label>{{ trans('home.Nội dung thu') }}</label>
		                        <textarea class="form-control" placeholder="{{ trans('home.Nhập nội dung thu') }}" rows="4" name="content"></textarea>
		                    </div>
                    	</div>
                    	<div class="col-md-4">
                    		<div class="form-group">
		                        <label>{{ trans('home.Ghi chú') }}</label>
		                        <textarea class="form-control" placeholder="{{ trans('home.Nhập ghi chú') }}" rows="4" name="note"></textarea>
		                    </div>
                    	</div>
                    </div>

                    <div class="row">

                    	<div class="col-md-6">
	                        <div class="form-group">
		                        <label>{{ trans('home.Người lập phiếu thu') }}</label>
		                        <select class="form-control select2" name="creator_revenue">
                                    @foreach($accounting_employees as $accounting)
                                    <option value="{{ $accounting->id }}">{{ $accounting->fullname }}</option>
                                    @endforeach
		                        </select>
		                    </div>
		                </div>

	                    <div class="col-md-6">
	                        <div class="form-group">
		                        <label>{{ trans('home.Người phụ trách') }}</label>
		                        <select class="form-control select2" name="personin_revenue">
		                            <option value="">{{ trans('home.Chọn') }}</option>
		                            @foreach($accounting_employees as $accounting)
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
            <div class="box box-primary box-control">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Chức năng') }}</h3>
                </div>
                <div class="box-body">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary btn-save" tabindex="7">
                            <img src="{{ asset('img/icon-save.png') }}" alt="">
                            <span><b>{{ trans('home.Lưu') }}</b></span>
                        </button>
                        <a href="{{ route('gross_revenues-index') }}" class="btn btn-default btn-cancel" tabindex="8">
                            <img src="{{ asset('img/icon-cancel.png') }}" alt="">
                            <span><b>Thoát</b></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.File chứng từ/Hồ sơ đính kèm') }}</h3>
                </div>
                <div class="box-body">
                    <input class="file_record_add" type="file" name="file_record" id="file_record" data-file_types="pdf|doc|docx|xlsx">
                    <label for="file_record" class="clearfix fileName">
                        <span></span>
                        <strong><i class="fa fa-upload"></i> Choose a file&hellip;</strong>
                    </label>
                    <p class="text-danger" style="margin-top: 10px;">{{ trans('home.Lưu ý: Tải file .pdf, .xlsx, .docx và .doc; Dung lượng file < 1.5 MB') }}</p>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('scripts')
@include('financial-manage.gross_revenue.partials.script')

<script>
    $(function() {

        $('.btn-save').click(function() {
            $('#gross_revenues-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#gross_revenues-form').attr('action', '');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#gross_revenues-form').attr('action', '');
        });

    });
</script>
@endsection
