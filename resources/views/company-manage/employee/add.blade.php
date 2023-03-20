@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <form role="form" action="{{ route('employees-store') }}?continue=true" method="post" id="employee-form" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="col-md-10" style="padding-right: 5px;">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Tạo mới nhân viên') }}</h3>
                </div>
                <div class="box-body">

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Tài khoản') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-control select2" name="user_id">
                                    <option>{{ trans('home.Chọn') }}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Tên nhân viên') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('fullname')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ trans('home.Tên nhân viên') }}" name="fullname">
                                @if($errors->has('fullname'))<span class="help-block">{{ $errors->first('fullname') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Mã số thuế') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('personaltaxcode')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ trans('home.Mã số thuế cá nhân') }}" name="personaltaxcode" style="width: 55%;">
                                @if($errors->has('personaltaxcode'))<span class="help-block">{{ $errors->first('personaltaxcode') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Giới tính') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group" style="width: 40%;">
                                <select class="form-control select2" name="gender">
                                    <option>{{ trans('home.Chọn') }}</option>
                                    <option value="0">{{ trans('home.Nữ') }}</option>
                                    <option value="1">{{ trans('home.Nam') }}</option>
                                    <option value="2">{{ trans('home.Khác') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.CMND/CCCD') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('id_No')) ? ' has-error' : '' }}">
                                <input type="number" class="form-control" placeholder="{{ trans('home.Chứng minh nhân dân') }}" name="id_No" style="width: 55%;">
                                @if($errors->has('id_No'))<span class="help-block">{{ $errors->first('id_No') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Ngày sinh') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('birthday')) ? ' has-error' : '' }}">
                                <input type="date" class="form-control" name="birthday" style="width: 55%;">
                                @if($errors->has('birthday'))<span class="help-block">{{ $errors->first('birthday') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Ngày cấp') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('identycarddate')) ? ' has-error' : '' }}">
                                <input type="date" class="form-control" name="identycarddate" style="width: 55%;">
                                @if($errors->has('identycarddate'))<span class="help-block">{{ $errors->first('identycarddate') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Quê quán') }}:</b></div>
                        <div class="col-lg-4">
                            <select class="form-control select2" name="hometown_id" style="width: 40%;">
                                <option>{{ trans('home.Chọn') }}</option>
                                @foreach($cityprovinces as $cityprovince)
                                    <option value="{{ $cityprovince->id }}">{{ $cityprovince->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Nơi cấp') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('identycardplace_issue')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ trans('home.Nơi cấp') }}" name="identycardplace_issue" style="width: 55%;">
                                @if($errors->has('identycardplace_issue'))<span class="help-block">{{ $errors->first('identycardplace_issue') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Dân tộc') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('people')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ trans('home.Dân tộc') }}" name="people" style="width: 40%;">
                                @if($errors->has('people'))<span class="help-block">{{ $errors->first('people') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Ngày vào công ty') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('begin_workdate')) ? ' has-error' : '' }}">
                                <input type="date" class="form-control" name="begin_workdate" style="width: 55%;">
                                @if($errors->has('begin_workdate'))<span class="help-block">{{ $errors->first('begin_workdate') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b style="letter-spacing: -.2px;">{{ trans('home.Địa chỉ thường trú') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('address')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ trans('home.Địa chỉ thường trú') }}" name="address">
                                @if($errors->has('address'))<span class="help-block">{{ $errors->first('address') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b style="letter-spacing: -.9px;">{{ trans('home.Ngày làm chính thức') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('begin_official_workday')) ? ' has-error' : '' }}">
                                <input type="date" class="form-control" name="begin_official_workday" style="width: 55%;">
                                @if($errors->has('begin_official_workday'))<span class="help-block">{{ $errors->first('begin_official_workday') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Địa chỉ tạm trú') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('temporaryaddress')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ trans('home.Địa chỉ tạm trú') }}" name="temporaryaddress">
                                @if($errors->has('temporaryaddress'))<span class="help-block">{{ $errors->first('temporaryaddress') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Phòng ban') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-control select2" name="department_id">
                                    <option>{{ trans('home.Chọn') }}</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Số điện thoại') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('phone')) ? ' has-error' : '' }}">
                                <input type="number" class="form-control" placeholder="{{ trans('home.Số điện thoại') }}" name="phone"  style="width: 55%;">
                                @if($errors->has('phone'))<span class="help-block">{{ $errors->first('phone') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Bộ phận') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-control select2" name="division_id">
                                    <option>{{ trans('home.Chọn') }}</option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                                    @endforeach
                                    <option value="0">
                                        Không có
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Số cố định') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('phone_other')) ? ' has-error' : '' }}">
                                <input type="number" class="form-control" placeholder="{{ trans('home.Số cố định') }}" name="phone_other" style="width: 55%;">
                                @if($errors->has('phone_other'))<span class="help-block">{{ $errors->first('phone_other') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Chức vụ') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-control select2" name="position_id">
                                    <option>{{ trans('home.Chọn') }}</option>
                                    @foreach($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Email') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('email')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ trans('home.Email') }}" name="email">
                                @if($errors->has('email'))<span class="help-block">{{ $errors->first('email') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Hình thức') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group" style="width: 55%;">
                                <select class="form-control select2" name="status">
                                    <option>{{ trans('home.Chọn') }}</option>
                                    <option value="1">{{ trans('home.Chính thức') }}</option>
                                    <option value="2">{{ trans('home.Thử việc') }}</option>
                                    <option value="3">{{ trans('home.Thực tập') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Email nội bộ') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('localmail')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ trans('home.Email nội bộ') }}" name="localmail">
                                @if($errors->has('localmail'))<span class="help-block">{{ $errors->first('localmail') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Số tài khoản') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('account_No')) ? ' has-error' : '' }}">
                                <input type="number" class="form-control" placeholder="{{ trans('home.Số tài khoản ngân hàng') }}" name="account_No" style="width: 55%;">
                                @if($errors->has('account_No'))<span class="help-block">{{ $errors->first('account_No') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Hôn nhân') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('maritalstatus')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ trans('home.Tình trạng gia đình') }}" name="maritalstatus" style="width: 40%;">
                                @if($errors->has('maritalstatus'))<span class="help-block">{{ $errors->first('maritalstatus') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Tên ngân hàng') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('bankname')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ trans('home.Tên ngân hàng') }}" name="bankname">
                                @if($errors->has('bankname'))<span class="help-block">{{ $errors->first('bankname') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Trình độ') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group" style="width: 40%;">
                                <select class="form-control select2" name="level_id">
                                    <option>{{ trans('home.Chọn') }}</option>
                                    @foreach($levels as $level)
                                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Ngày kí HĐLĐ') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('beginlabordate')) ? ' has-error' : '' }}">
                                <input type="date" class="form-control" name="beginlabordate" style="width: 55%;">
                                @if($errors->has('beginlabordate'))<span class="help-block">{{ $errors->first('beginlabordate') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b style="letter-spacing: -.9px;">{{ trans('home.Thời hạn nâng lương') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group" style="width: 40%;">
                                <select class="form-control select2" name="salaryyear">
                                    <option>{{ trans('home.Chọn') }}</option>
                                    <option value="1">{{ trans('home.1 năm') }}</option>
                                    <option value="2">{{ trans('home.2 năm') }}</option>
                                    <option value="3">{{ trans('home.3 năm') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2"><b style="letter-spacing: -.9px;">{{ trans('home.Ngày kết thúc HĐLĐ') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('finishworkdate')) ? ' has-error' : '' }}">
                                <input type="date" class="form-control" name="finishworkdate" style="width: 55%;">
                                @if($errors->has('finishworkdate'))<span class="help-block">{{ $errors->first('finishworkdate') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b style="letter-spacing: -.9px;">{{ trans('home.Trích thuế TNCN') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('salaryincome')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" name="salaryincome" style="width: 40%; display: inline-block;"> <span>(%)</span>
                                @if($errors->has('salaryincome'))<span class="help-block">{{ $errors->first('salaryincome') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Hiển thị') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group" style="width: 55%;">
                                <select class="form-control select2" name="print">
                                    <option>{{ trans('home.Chọn') }}</option>
                                    <option value="1">{{ trans('home.Bảng lương') }}</option>
                                    <option value="2">{{ trans('home.Chấm công') }}</option>
                                    <option value="3">{{ trans('home.Tất cả') }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- <div class="col-lg-2"><b>Thanh lý HĐLĐ:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-control select2" name="finish">
                                    <option>Chọn</option>
                                    <option value="1">Có</option>
                                    <option value="0">Không</option>
                                </select>
                            </div>
                        </div> -->
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-2" style="padding-left: 5px;">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Chức năng') }}</h3>
                </div>
                <div class="box-body">
                    <button type="submit" class="btn btn-primary btn-save" tabindex="9" style="width: 49%;">{{ trans('home.Lưu') }}</button>
                    <a href="{{ route('employees-index') }}" class="btn btn-default btn-cancel" tabindex="10" style="width: 49%;">{{ trans('home.Trở về') }}</a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Hình ảnh avatar') }}</h3>
                </div>
                <div class="box-body">
                    <input type="file" class="file_image_add" name="fImages" data-file_types="jpg|JPG">
                    <p class="text-danger" style="margin-top: 10px;">{{ trans('home.Lưu ý: Tải hình ảnh có kích thước 500 x 500 (px) và dung lượng hình dưới 2MB') }}</p>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#employee-form').submit();
        });

        $('#birthday').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });

        $('#chk-continue').on('ifChecked', function() {
            $('#employee-form').attr('action', '{{ route('employees-store') }}?continue=true');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#employee-form').attr('action', '{{ route('employees-store') }}');
        });

        var _URL = window.URL || window.webkitURL;

        $('.file_image_add').change(function(e) {
            
            var numb = this.files[0].size/1024/1024;
            var resultid = $(this).val().split(".");
            var gettypeup  = resultid [resultid.length-1];
            var filetype = $(this).attr('data-file_types');
            var allowedfiles = filetype.replace(/\|/g,', ');
            var filesize = 2;
            var onlist = $(this).attr('data-file_types').indexOf(gettypeup) > -1;
            var checkinputfile = $(this).attr('type');
            var numb_fix = numb.toFixed(2);
            var fileName = $(this).val().split( "\\" ).pop();

            if(onlist && numb_fix <= filesize){
                
                confirm('Upload file successful');
                
            } else {
                if(numb_fix >= filesize && onlist){
                    $(this).val('');
                    confirm('Added file is too big \(' + numb_fix + ' MB\) - max file size '+ filesize +' MB');
                } else if(numb_fix < filesize && !onlist || !onlist) {
                    $(this).val('');
                    confirm('An not allowed file format has been added \('+ gettypeup +') - allowed formats: ' + allowedfiles);
                } 
            }
        });
    });
</script>
@endsection
