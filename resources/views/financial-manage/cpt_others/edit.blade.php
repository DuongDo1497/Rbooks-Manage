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
    <form role="form" action="{{ route('cpt_khac-update', ['id' => $cpt_khac->id]) }}?continue=true" method="post" id="cpt_khac-form" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Thông tin chung') }}</h3>
                </div>
                <div class="box-body">

                	<div class="row">
                		<div class="col-md-6">
                    		<div class="form-group">
                                <label>{{ trans('home.Ngày chi') }}</label>
                                <input type="date" class="form-control" placeholder="{{ trans('home.Nhập ngày lập phiếu chi') }}" name="date_create" value="{{ $cpt_khac->date_create }}">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Loại chi') }}</label>
                                <select class="form-control select2" name="type_cost">
		                            @if($cpt_khac->type_cost == 1)
                                       <option value="1">{{ trans('home.Chi phí thực tế') }}</option>
                                       <option value="2">{{ trans('home.Công nợ phải trả') }}</option>
                                    @else
                                        <option value="2">{{ trans('home.Công nợ phải trả') }}</option>
                                        <option value="1">{{ trans('home.Chi phí thực tế') }}</option>
                                    @endif
		                        </select>
		                    </div>
                    	</div>
                	</div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Ngày bắt đầu') }}</label>
                                <input type="date" class="form-control" placeholder="{{ trans('home.Nhập ngày bắt đầu') }}" name="startday_cost" value="{{ $cpt_khac->startday_cost }}">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Ngày kết thúc') }}</label>
                                <input type="date" class="form-control" placeholder="{{ trans('home.Nhập ngày kết thúc') }}" name="endday_cost" value="{{ $cpt_khac->endday_cost }}">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                    </div>

                	<div class="row">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Hình thức chi') }}</label>
		                        <select class="form-control select2" name="method_cost">
		                            @if($cpt_khac->method_cost == 1)
                                        <option value="1">{{ trans('home.Tiền mặt') }}</option>
                                        <option value="2">{{ trans('home.Chuyển khoản') }}</option>
                                    @else
                                        <option value="2">{{ trans('home.Chuyển khoản') }}</option>
                                        <option value="1">{{ trans('home.Tiền mặt') }}</option>
                                    @endif
		                        </select>
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Trạng thái') }}</label>
		                        <select class="form-control select2" name="status">
		                            @if($cpt_khac->status == 1)
                                        <option value="1">{{ trans('home.Đã chi') }}</option>
                                        <option value="2">{{ trans('home.Chưa chi') }}</option>
                                        <option value="3">{{ trans('home.Nợ trả từng phần') }}</option>
                                    @elseif($cpt_khac->status == 2)
                                        <option value="2">{{ trans('home.Chưa chi') }}</option>
                                        <option value="1">{{ trans('home.Đã chi') }}</option>
                                        <option value="3">{{ trans('home.Nợ trả từng phần') }}</option>
                                    @else
                                        <option value="3">{{ trans('home.Nợ trả từng phần') }}</option>
                                        <option value="1">{{ trans('home.Đã chi') }}</option>
                                        <option value="2">{{ trans('home.Chưa chi') }}</option>
                                    @endif
		                        </select>
		                    </div>
                    	</div>
                    </div>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Thông tin nhà cung cấp/Người bán') }}</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Mã nhà cung cấp/Người bán') }}</label>
		                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập mã nhà cung cấp/người bán') }}" name="supplier_code" value="{{ $cpt_khac->supplier_code }}">
		                        @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
		                    </div>
                    	</div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tên nhà cung cấp/Người bán') }}</label>
                                <input type="text" class="form-control" placeholder="{{ trans('home.Nhập tên nhà cung cấp/người bán') }}" name="supplier_name" value="{{ $cpt_khac->supplier_name }}">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Điện thoại') }}</label>
                                <input type="number" class="form-control" placeholder="{{ trans('home.Nhập số điện thoại') }}" name="supplier_phone" value="{{ $cpt_khac->supplier_phone }}">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Địa chỉ') }}</label>
                                <input type="text" class="form-control" placeholder="{{ trans('home.Nhập địa chỉ') }}" name="supplier_address" value="{{ $cpt_khac->supplier_address }}">
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
		                        <input type="number" class="form-control" placeholder="{{ trans('home.Nhập số lượng') }}" name="quantity" value="{{ $cpt_khac->quantity }}">
                        		@if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
		                    </div>
		                </div>

	                    <div class="col-md-4">
		                    <div class="form-group">
		                        <label>{{ trans('home.Đơn vị') }}</label>
		                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập đơn vị tính') }}" name="unit" value="{{ $cpt_khac->unit }}">
                        		@if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
		                    </div>
		                </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('home.Thuế VAT') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ trans('home.Nhập số phần trăm') }}" name="vat" value="{{ $cpt_khac->vat }}">
                                    <span class="input-group-addon">%</span>
                                </div>
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
	                </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tổng tiền phải trả (không VAT)') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ trans('home.Nhập số tiền') }}" name="novat_cost" value="{{ $cpt_khac->novat_cost }}">
                                    <span class="input-group-addon">VND</span>
                                </div>
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tổng tiền phải trả (có VAT)') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ trans('home.Nhập số tiền') }}" name="vat_cost" value="{{ $cpt_khac->vat_cost }}">
                                    <span class="input-group-addon">VND</span>
                                </div>
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tổng tiền đã trả (không VAT)') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ trans('home.Nhập số tiền') }}" name="paided_cost_novat" value="{{ $cpt_khac->paided_cost_novat }}">
                                    <span class="input-group-addon">VND</span>
                                </div>
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tổng tiền đã trả (có VAT)') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ trans('home.Nhập số tiền') }}" name="paided_cost_vat" value="{{ $cpt_khac->paided_cost_vat }}">
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
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ trans('home.Nhập số tiền') }}" name="remaining_cost_novat" value="{{ $cpt_khac->remaining_cost_novat }}">
                                    <span class="input-group-addon">VND</span>
                                </div>
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tổng tiền dư nợ (có VAT)') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ trans('home.Nhập số tiền') }}" name="remaining_cost_vat" value="{{ $cpt_khac->remaining_cost_vat }}">
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
                                <label>{{ trans('home.Hồ sơ chi') }}</label>
                                <textarea class="form-control" placeholder="{{ trans('home.Nhập hồ sơ chi') }}" rows="4" name="file_cost">{{ $cpt_khac->file_cost }}</textarea>
                            </div>
                        </div>
                    	<div class="col-md-4">
                    		<div class="form-group">
		                        <label>{{ trans('home.Nội dung chi') }}</label>
		                        <textarea class="form-control" placeholder="{{ trans('home.Nhập nội dung chi') }}" rows="4" name="content">{{ $cpt_khac->content }}</textarea>
		                    </div>
                    	</div>
                    	<div class="col-md-4">
                    		<div class="form-group">
		                        <label>{{ trans('home.Ghi chú') }}</label>
		                        <textarea class="form-control" placeholder="{{ trans('home.Nhập ghi chú') }}" rows="4" name="note">{{ $cpt_khac->note }}</textarea>
		                    </div>
                    	</div>
                    </div>

                    <div class="row">

                    	<div class="col-md-6">
	                        <div class="form-group">
		                        <label>{{ trans('home.Người lập phiếu chi') }}</label>
		                        <select class="form-control select2" name="creator_cost">
		                            <option value="{{ $cpt_khac->creator_cost }}">{{ $cpt_khac->employee()->first() == NULL ? "" : $cpt_khac->employee()->first()->fullname }}</option>
                                    @foreach($accounting_employee as $accounting)
                                        <option value="{{ $accounting->id }}">{{ $accounting->fullname }}</option>
                                    @endforeach
		                        </select>
		                    </div>
		                </div>

	                    <div class="col-md-6">
	                        <div class="form-group">
		                        <label>{{ trans('home.Người phụ trách') }}</label>
		                        <select class="form-control select2" name="personin_cost">
		                            <option value="{{ $cpt_khac->personin_cost }}">{{ $cpt_khac->personinEmployee()->first() == NULL ? "" : $cpt_khac->personinEmployee()->first()->fullname }}</option>
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
                    <h3 class="box-title">{{ trans('home.Chức năng') }}</h3>
                </div>
                <div class="box-body">
                    <button type="submit" class="btn btn-primary btn-save" tabindex="9">{{ trans('home.Lưu') }}</button>
                    <a href="{{ route('cpt_khac-index') }}" class="btn btn-default btn-cancel" tabindex="10">{{ trans('home.Trở về') }}</a>
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
@include('financial-manage.cpt_others.partials.script')

<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#cpt_khac-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#cpt_khac-form').attr('action', '');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#cpt_khac-form').attr('action', '');
        });
    });
</script>
@endsection
