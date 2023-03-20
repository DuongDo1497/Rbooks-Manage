@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <form role="form" action="{{ route('cpt_qldn-store') }}?continue=true" method="post" id="cpt_qldn-form" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Thông tin chung') }}</h3>
                </div>
                <div class="box-body">

                	<div class="row">
                		<div class="col-md-4">
                    		<div class="form-group">
                                <label>{{ trans('home.Ngày chi') }}</label>
                                <input type="date" class="form-control" placeholder="{{ trans('home.Nhập ngày lập phiếu chi') }}" name="date_create">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                    	</div>
                    	<div class="col-md-4">
                    		<div class="form-group">
		                        <label>{{ trans('home.Loại chi') }}</label>
                                <select class="form-control select2" name="type_cost">
		                            <option value="">{{ trans('home.Chọn') }}</option>
		                            <option value="1">{{ trans('home.Chi phí thực tế') }}</option>
		                            <option value="2">{{ trans('home.Công nợ phải trả') }}</option>
		                        </select>
		                    </div>
                    	</div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('home.Mục chi') }}</label>
                                <select class="form-control select2" name="itemcost_id">
                                    <option value="">{{ trans('home.Chọn') }}</option>
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
                                <input type="date" class="form-control" placeholder="{{ trans('home.Nhập ngày bắt đầu') }}" name="startday_cost">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Ngày kết thúc') }}</label>
                                <input type="date" class="form-control" placeholder="{{ trans('home.Nhập ngày kết thúc') }}" name="endday_cost">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Hình thức chi') }}</label>
                                <select class="form-control select2" name="method_cost">
                                    <option value="">{{ trans('home.Chọn') }}</option>
                                    <option value="1">{{ trans('home.Tiền mặt') }}</option>
                                    <option value="2">{{ trans('home.Chuyển khoản') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Trạng thái') }}</label>
                                <select class="form-control select2" name="status">
                                    <option value="">{{ trans('home.Chọn') }}</option>
                                    <option value="1">{{ trans('home.Đã chi') }}</option>
                                    <option value="2">{{ trans('home.Chưa chi') }}</option>
                                    <option value="3">{{ trans('home.Nợ trả từng phần') }}</option>
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
                                <input type="text" class="form-control" placeholder="{{ trans('home.Nhập mã nhà cung cấp/người bán') }}" name="supplier_code">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tên nhà cung cấp/Người bán') }}</label>
                                <input type="text" class="form-control" placeholder="{{ trans('home.Nhập tên nhà cung cấp/người bán') }}" name="supplier_name">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Điện thoại') }}</label>
                                <input type="number" class="form-control" placeholder="{{ trans('home.Nhập số điện thoại') }}" name="supplier_phone">
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Địa chỉ') }}</label>
                                <input type="text" class="form-control" placeholder="{{ trans('home.Nhập địa chỉ') }}" name="supplier_address">
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
                                <div class="input-group">
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
                                <label>{{ trans('home.Tổng tiền phải trả (không VAT)') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control total-vat" placeholder="{{ trans('home.Nhập số tiền') }}" name="novat_cost">
                                    <span class="input-group-addon">VND</span>
                                </div>
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tổng tiền phải trả (có VAT)') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control total-vat" placeholder="{{ trans('home.Nhập số tiền') }}" name="vat_cost">
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
                                    <input type="text" class="form-control total-vat" placeholder="{{ trans('home.Nhập số tiền') }}" name="paided_cost_novat">
                                    <span class="input-group-addon">VND</span>
                                </div>
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tổng tiền đã trả (có VAT)') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control total-vat" placeholder="{{ trans('home.Nhập số tiền') }}" name="paided_cost_vat">
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
                                    <input type="text" class="form-control total-vat" placeholder="{{ trans('home.Nhập số tiền') }}" name="remaining_cost_novat">
                                    <span class="input-group-addon">VND</span>
                                </div>
                                @if($errors->has(''))<span class="help-block">{{ $errors->first('') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Tổng tiền dư nợ (có VAT)') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control total-vat" placeholder="{{ trans('home.Nhập số tiền') }}" name="remaining_cost_vat">
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
                                <textarea class="form-control" placeholder="{{ trans('home.Nhập hồ sơ chi') }}" rows="4" name="file_cost"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('home.Nội dung chi') }}</label>
                                <textarea class="form-control" placeholder="{{ trans('home.Nhập nội dung chi') }}" rows="4" name="content"></textarea>
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
                                <label>{{ trans('home.Người lập phiếu chi') }}</label>
                                <select class="form-control select2" name="creator_cost">
                                    <option value="">{{ trans('home.Chọn') }}</option>
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
                                    <option value="">{{ trans('home.Chọn') }}</option>
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
                    <a href="{{ route('cpt_qldn-index') }}" class="btn btn-default btn-cancel" tabindex="10">{{ trans('home.Trở về') }}</a>
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
@include('financial-manage.cpt_enterprises.partials.script')

<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#cpt_qldn-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#cpt_qldn-form').attr('action', '');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#cpt_qldn-form').attr('action', '');
        });

        
    });
</script>
@endsection
