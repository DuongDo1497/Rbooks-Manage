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
    <form role="form" action="{{ route('gross_revenues-update', ['id' => $revenue->id]) }}?continue=true" method="post" id="gross_revenues-form">
        {{ csrf_field() }}
        {{ method_field('put') }}
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
                                <input type="date" class="form-control" placeholder="{{ trans('home.Nhập ngày lập phiếu thu') }}" name="date_create" value="{{ $revenue->date_create }}">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                    	</div>
                    	<div class="col-md-4">
                    		<div class="form-group">
		                        <label>{{ trans('home.Loại thu') }}</label>
                                <select class="form-control select2" name="type_revenue">
                                    @if($revenue->type_revenue == 1)
                                        <option value="1">{{ trans('home.Doanh thu thực tế') }}</option>
                                        <option value="2">{{ trans('home.Công nợ phải thu') }}</option>
                                    @else
                                        <option value="2">{{ trans('home.Công nợ phải thu') }}</option>
                                        <option value="1">{{ trans('home.Doanh thu thực tế') }}</option>
                                    @endif
                                    @if($errors->has('type_revenue'))<span class="text-danger">{{ $errors->first('type_revenue') }}</span>@endif
		                        </select>
		                    </div>
                    	</div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('home.Nguồn thu') }}</label>
                                <select class="form-control select2" name="itemcost_id">
                                    @foreach($mclists as $mclist)
                                        @if($revenue->itemcost_id == $mclist->id)
                                            <option value="{{ $mclist->id }}" selected>{{ $mclist->name }}</option>
                                        @else
                                            <option value="{{ $mclist->id }}">{{ $mclist->name }}</option>
                                        @endif
                                    @endforeach
                                    @if($errors->has('itemcost_id'))<span class="text-danger">{{ $errors->first('itemcost_id') }}</span>@endif
                                </select>
                            </div>
                        </div>
                	</div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Ngày bắt đầu') }}</label>
                                <input type="date" class="form-control" placeholder="{{ trans('home.Nhập ngày bắt đầu') }}" name="start_date" value="{{ $revenue->start_date }}">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Ngày kết thúc') }}</label>
                                <input type="date" class="form-control" placeholder="{{ trans('home.Nhập ngày kết thúc') }}" name="end_date" value="{{ $revenue->end_date }}">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                    </div>

                	<div class="row">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Hình thức thu') }}</label>
		                        <select class="form-control select2" name="method_revenue">
		                            @if($revenue->method_revenue == 'Tiền mặt')
		                            <option value="Tiền mặt" selected>{{ trans('home.Tiền mặt') }}</option>
                                    <option value="Chuyển khoản">{{ trans('home.Chuyển khoản') }}</option>
                                    @else
		                            <option value="Chuyển khoản" selected>{{ trans('home.Chuyển khoản') }}</option>
                                    <option value="Tiền mặt">{{ trans('home.Tiền mặt') }}</option>
                                    @endif
		                        </select>
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Trạng thái') }}</label>
		                        <select class="form-control select2" name="status">
		                            @if($revenue->status == 1)
                                    <option value="1" selected>{{ trans('home.Đã thu') }}</option>
                                    <option value="2">{{ trans('home.Chưa thu') }}</option>
                                    <option value="3">{{ trans('home.Thu từng phần') }}</option>
                                    @elseif($revenue->status == 2)
                                    <option value="2" selected>{{ trans('home.Chưa thu') }}</option>
                                    <option value="1">{{ trans('home.Đã thu') }}</option>
                                    <option value="3">{{ trans('home.Thu từng phần') }}</option>
                                    @else
                                    <option value="3" selected>{{ trans('home.Thu từng phần') }}</option>
                                    <option value="1">{{ trans('home.Đã thu') }}</option>
                                    <option value="2">{{ trans('home.Chưa thu') }}</option>
                                    @endif
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
		                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập mã khách hàng/nhà cung cấp') }}" name="code_customer" value="{{ $revenue->code_customer }}">
		                        @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
		                    </div>
                    	</div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tên khách hàng/nhà cung cấp') }}</label>
                                <input type="text" class="form-control" placeholder="{{ trans('home.Nhập tên khách hàng/nhà cung cấp') }}" name="name_customer" value="{{ $revenue->name_customer }}">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Điện thoại') }}</label>
                                <input type="number" class="form-control" placeholder="{{ trans('home.Nhập số điện thoại') }}" name="phone" value="{{ $revenue->phone }}">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Địa chỉ') }}</label>
                                <input type="text" class="form-control" placeholder="{{ trans('home.Nhập địa chỉ') }}" name="address" value="{{ $revenue->address }}">
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
		                        <input type="number" class="form-control" placeholder="{{ trans('home.Nhập số lượng') }}" name="quantity" value="{{ $revenue->quantity }}">
                        		@if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
		                    </div>
		                </div>

	                    <div class="col-md-4">
		                    <div class="form-group">
		                        <label>{{ trans('home.Đơn vị') }}</label>
		                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập đơn vị tính') }}" name="unit" value="{{ $revenue->unit }}">
                        		@if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
		                    </div>
		                </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('home.Thuế VAT') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ trans('home.Nhập số phần trăm') }}" name="vat" value="{{ $revenue->vat }}">
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
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ trans('home.Nhập số tiền') }}" name="notvat_revenue" value="{{ formatNumber($revenue['notvat_revenue'], 1, 0, 0) }}">
                                    <span class="input-group-addon">VND</span>
                                </div>
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tổng tiền phải thu (có VAT)') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ trans('home.Nhập số tiền') }}" name="vat_revenue" value="{{ formatNumber($revenue['vat_revenue'], 1, 0, 0) }}">
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
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ trans('home.Nhập số tiền') }}" name="dathu_notvat" value="{{ $revenue->dathu_notvat == 0 ? "0" : formatNumber($revenue['dathu_notvat'], 1, 0, 0) }}">
                                    <span class="input-group-addon">VND</span>
                                </div>
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tổng tiền đã thu (có VAT)') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ trans('home.Nhập số tiền') }}" name="dathu_vat" value="{{ $revenue->dathu_vat == 0 ? "0" : formatNumber($revenue['dathu_vat'], 1, 0, 0) }}">
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
                                    <input type="text" class="form-control" placeholder="{{ trans('home.Nhập số tiền') }}" name="conlai_notvat" value="{{ $revenue->conlai_notvat == 0 ? "0" : formatNumber($revenue['conlai_notvat'], 1, 0, 0) }}">
                                    <span class="input-group-addon">VND</span>
                                </div>
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tổng tiền dư nợ (có VAT)') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="{{ trans('home.Nhập số tiền') }}" name="conlai_vat" value="{{ $revenue->conlai_vat == 0 ? "0" : formatNumber($revenue['conlai_vat'], 1, 0, 0) }}">
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
                                <textarea class="form-control" placeholder="{{ trans('home.Nhập hồ sơ thu') }}" rows="4" name="file_revenue">{{ $revenue->file_revenue }}</textarea>
                            </div>
                        </div>
                    	<div class="col-md-4">
                    		<div class="form-group">
		                        <label>{{ trans('home.Nội dung thu') }}</label>
		                        <textarea class="form-control" placeholder="{{ trans('home.Nhập nội dung thu') }}" rows="4" name="content">{{ $revenue->content }}</textarea>
		                    </div>
                    	</div>
                    	<div class="col-md-4">
                    		<div class="form-group">
		                        <label>{{ trans('home.Ghi chú') }}</label>
		                        <textarea class="form-control" placeholder="{{ trans('home.Nhập ghi chú') }}" rows="4" name="note">{{ $revenue->note }}</textarea>
		                    </div>
                    	</div>
                    </div>

                    <div class="row">
                    	<div class="col-md-6">
	                        <div class="form-group">
		                        <label>{{ trans('home.Người lập phiếu thu') }}</label>
		                        <select class="form-control select2" name="creator_revenue">
                                    @foreach($accounting_employees as $accounting_employee)
                                        @if($revenue->creator_revenue == $accounting_employee->id)
    		                              <option value="{{ $revenue->creator_revenue }}" selected>{{ $revenue->creatorEmployee()->first()->fullname }}</option>
                                        @else
                                            <option value="{{ $accounting_employee->id }}">{{ $accounting_employee->fullname }}</option>
                                        @endif
                                    @endforeach
		                        </select>
		                    </div>
		                </div>
	                    <div class="col-md-6">
	                        <div class="form-group">
		                        <label>{{ trans('home.Người phụ trách') }}</label>
		                        <select class="form-control select2" name="personin_revenue">
		                            @foreach($accounting_employees as $accounting_employee)
                                        @if($revenue->personin_revenue == $accounting_employee->id)
                                            <option value="{{ $revenue->personin_revenue }}" selected>{{ $revenue->personinEmployee()->first()->fullname }}</option>
                                        @else
                                            <option value="{{ $accounting_employee->id }}">{{ $accounting_employee->fullname }}</option>
                                        @endif
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
                    <a href="{{ route('gross_revenues-index') }}" class="btn btn-default btn-cancel" tabindex="10">{{ trans('home.Trở về') }}</a>
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
