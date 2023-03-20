@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    @php
        $parameter =  $employee->id;
        $parameter= Crypt::encrypt($parameter);
    @endphp
    <form role="form" action="{{ route('employees-update', ['id' => $parameter]) }}?continue=true" method="post" id="employee-form" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <div class="col-md-10" style="padding-right: 5px;">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Chỉnh sửa nhân viên') }}</h3>
                </div>
                <div class="box-body">

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Tài khoản') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-control select2" name="user_id">
                                    <option value="{{ $employee->user_id == NULL ? "" : $employee->user_id }}">{{ $employee->user == NULL ? "" : $employee->user->name }}</option>
                                    <option>Chọn tài khoản</option>
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
                                <input type="text" class="form-control" placeholder="{{ $employee->fullname }}" name="fullname" value="{{ $employee->fullname }}">
                                @if($errors->has('fullname'))<span class="help-block">{{ $errors->first('fullname') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Mã số thuế') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('personaltaxcode')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ $employee->personaltaxcode }}" name="personaltaxcode" value="{{ $employee->personaltaxcode }}" style="width: 55%;">
                                @if($errors->has('personaltaxcode'))<span class="help-block">{{ $errors->first('personaltaxcode') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Giới tính') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group" style="width: 40%;">
                                <select class="form-control select2" name="gender">
                                    @if($employee->gender == 1)
                                        <option value="1">Nam</option>
                                        <option value="0">Nữ</option>
                                        <option value="2">Khác</option>
                                    @elseif($employee->gender == 0)
                                        <option value="0">Nữ</option>
                                        <option value="1">Nam</option>
                                        <option value="2">Khác</option>
                                    @else($employee->gender == 2)
                                        <option value="2">Khác</option>
                                        <option value="0">Nữ</option>
                                        <option value="1">Nam</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.CMND/CCCD') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('id_No')) ? ' has-error' : '' }}">
                                <input type="number" class="form-control" placeholder="{{ $employee->id_No }}" name="id_No" value="{{ $employee->id_No }}" style="width: 55%;">
                                @if($errors->has('id_No'))<span class="help-block">{{ $errors->first('id_No') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Ngày sinh') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('birthday')) ? ' has-error' : '' }}">
                                <input type="date" class="form-control" name="birthday" value="{{ $employee->birthday }}" style="width: 55%;">
                                @if($errors->has('birthday'))<span class="help-block">{{ $errors->first('birthday') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Ngày cấp') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('identycarddate')) ? ' has-error' : '' }}">
                                <input type="date" class="form-control" name="identycarddate" value="{{ $employee->identycarddate }}" style="width: 55%;">
                                @if($errors->has('identycarddate'))<span class="help-block">{{ $errors->first('identycarddate') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Quê quán') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group" style="width: 40%;">
                                <select class="form-control select2" name="hometown_id">
                                    <option value="{{ $employee->hometown_id }}">{{ $employee->hometown_id == NULL ? "" : $employee->cityprovince()->first()->name }}</option>
                                    @foreach($cityprovinces as $cityprovince)
                                        <option value="{{ $cityprovince->id }}">{{ $cityprovince->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Nơi cấp') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('identycardplace_issue')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ $employee->identycardplace_issue }}" name="identycardplace_issue" value="{{ $employee->identycardplace_issue }}" style="width: 55%;">
                                @if($errors->has('identycardplace_issue'))<span class="help-block">{{ $errors->first('identycardplace_issue') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Dân tộc') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('people')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ $employee->people }}" name="people" value="{{ $employee->people }}" style="width: 40%;">
                                @if($errors->has('people'))<span class="help-block">{{ $errors->first('people') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Ngày vào công ty') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('begin_workdate')) ? ' has-error' : '' }}">
                                <input type="date" class="form-control" name="begin_workdate" value="{{ $employee->begin_workday }}" style="width: 55%;">
                                @if($errors->has('begin_workdate'))<span class="help-block">{{ $errors->first('begin_workdate') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b style="letter-spacing: -.2px;">{{ trans('home.Địa chỉ thường trú') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('address')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ $employee->address }}" name="address" value="{{ $employee->address }}">
                                @if($errors->has('address'))<span class="help-block">{{ $errors->first('address') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b style="letter-spacing: -.9px;">{{ trans('home.Ngày làm chính thức') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('begin_official_workday')) ? ' has-error' : '' }}">
                                <input type="date" class="form-control" name="begin_official_workday" value="{{ $employee->begin_official_workday }}" style="width: 55%;">
                                @if($errors->has('begin_official_workday'))<span class="help-block">{{ $errors->first('begin_official_workday') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Địa chỉ tạm trú') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('temporaryaddress')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ $employee->temporaryaddress }}" name="temporaryaddress" value="{{ $employee->temporaryaddress }}">
                                @if($errors->has('temporaryaddress'))<span class="help-block">{{ $errors->first('temporaryaddress') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Phòng ban') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-control select2" name="department_id">
                                    <option value="{{ $employee->department_id }}">{{ $employee->department_id == NULL ? "" : $employee->department()->first()->name }} </option>
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
                                <input type="number" class="form-control" placeholder="{{ $employee->phone }}" name="phone" value="{{ $employee->phone }}" style="width: 55%;">
                                @if($errors->has('phone'))<span class="help-block">{{ $errors->first('phone') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Bộ phận') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-control select2" name="division_id">
                                    @if($employee->division_id != 0)
                                        <option value="{{ $employee->division_id }}">{{ $employee->division_id == NULL ? "" : $employee->division()->first()->name }}</option>
                                        @foreach($divisions as $division)
                                            <option value="{{ $division->id }}">{{ $division->name }}</option>
                                        @endforeach
                                    @else
                                    <option value="0">
                                        Không có
                                    </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Số cố định') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('phone_other')) ? ' has-error' : '' }}">
                                <input type="number" class="form-control" placeholder="{{ $employee->phone_other }}" name="phone_other" value="{{ $employee->phone_other }}" style="width: 55%;">
                                @if($errors->has('phone_other'))<span class="help-block">{{ $errors->first('phone_other') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Chức vụ') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-control select2" name="position_id">
                                    <option value="{{ $employee->position_id }}">{{ $employee->position_id == NULL ? "" : $employee->position()->first()->name }}</option>
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
                                <input type="text" class="form-control" placeholder="{{ $employee->email }}" name="email" value="{{ $employee->email }}">
                                @if($errors->has('email'))<span class="help-block">{{ $errors->first('email') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Hình thức') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group" style="width: 55%;">
                                <select class="form-control select2" name="status">
                                    @if($employee->status == 1)
                                        <option value="1">{{ trans('home.Chính thức') }}</option>
                                        <option value="2">{{ trans('home.Thử việc') }}</option>
                                        <option value="3">{{ trans('home.Thực tập') }}</option>
                                        <option value="4">Nghỉ việc</option>
                                    @elseif($employee->status == 2)
                                        <option value="2">{{ trans('home.Thử việc') }}</option>
                                        <option value="1">{{ trans('home.Chính thức') }}</option>
                                        <option value="3">{{ trans('home.Thực tập') }}</option>
                                        <option value="4">Nghỉ việc</option>
                                    @elseif($employee->status == 3)
                                        <option value="3">{{ trans('home.Thực tập') }}</option>
                                        <option value="1">{{ trans('home.Chính thức') }}</option>
                                        <option value="2">{{ trans('home.Thử việc') }}</option>
                                        <option value="4">Nghỉ việc</option>
                                    @else
                                        <option value="4">Nghỉ việc</option>
                                        <option value="1">{{ trans('home.Chính thức') }}</option>
                                        <option value="2">{{ trans('home.Thử việc') }}</option>
                                        <option value="3">{{ trans('home.Thực tập') }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Email nội bộ') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('localmail')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ $employee->localmail }}" name="localmail" value="{{ $employee->localmail }}">
                                @if($errors->has('localmail'))<span class="help-block">{{ $errors->first('localmail') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Số tài khoản') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('account_No')) ? ' has-error' : '' }}">
                                <input type="number" class="form-control" placeholder="{{ $employee->account_No }}" name="account_No" value="{{ $employee->account_No }}" style="width: 55%;">
                                @if($errors->has('account_No'))<span class="help-block">{{ $errors->first('account_No') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Hôn nhân') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('maritalstatus')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ $employee->maritalstatus }}" name="maritalstatus" value="{{ $employee->maritalstatus }}" style="width: 40%;">
                                @if($errors->has('maritalstatus'))<span class="help-block">{{ $errors->first('maritalstatus') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Tên ngân hàng') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('bankname')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ $employee->bankname }}" name="bankname" value="{{ $employee->bankname }}">
                                @if($errors->has('bankname'))<span class="help-block">{{ $errors->first('bankname') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b>{{ trans('home.Trình độ') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group" style="width: 40%;">
                                <select class="form-control select2" name="level_id">
                                    <option value="{{ $employee->level_id }}">{{ $employee->level_id == NULL ? "" : $employee->level()->first()->name }}</option>
                                    @foreach($levels as $level)
                                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Ngày kí HĐLĐ') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('beginlabordate')) ? ' has-error' : '' }}">
                                <input type="date" class="form-control" name="beginlabordate" value="{{ $employee->beginlabordate }}" style="width: 55%;">
                                @if($errors->has('beginlabordate'))<span class="help-block">{{ $errors->first('beginlabordate') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b style="letter-spacing: -.9px;">{{ trans('home.Thời hạn nâng lương') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group" style="width: 40%;">
                                <select class="form-control select2" name="salaryyear">
                                    @if($employee->salaryyear == 1)
                                        <option value="1">1 năm</option>
                                        <option value="2">2 năm</option>
                                        <option value="3">3 năm</option>
                                    @elseif($employee->salaryyear == 2)
                                        <option value="2">2 năm</option>
                                        <option value="1">1 năm</option>
                                        <option value="3">3 năm</option>
                                    @else($employee->salaryyear == 3)
                                        <option value="3">3 năm</option>
                                        <option value="1">1 năm</option>
                                        <option value="2">2 năm</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2"><b style="letter-spacing: -.9px;">{{ trans('home.Ngày kết thúc HĐLĐ') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('finishworkdate')) ? ' has-error' : '' }}">
                                <input type="date" class="form-control" name="finishworkdate" value="{{ $employee->finishworkdate }}" style="width: 55%;">
                                @if($errors->has('finishworkdate'))<span class="help-block">{{ $errors->first('finishworkdate') }}</span>@endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2"><b style="letter-spacing: -.9px;">{{ trans('home.Trích thuế TNCN') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group{{ ($errors->has('salaryincome')) ? ' has-error' : '' }}">
                                <input type="text" class="form-control" placeholder="{{ $employee->salaryincome }} trích thuế TNCN" name="salaryincome" value="{{ $employee->salaryincome }}" style="width: 40%; display: inline-block;"> <span>(%)</span>
                                @if($errors->has('salaryincome'))<span class="help-block">{{ $errors->first('salaryincome') }}</span>@endif
                            </div>
                        </div>

                        <div class="col-lg-2"><b>{{ trans('home.Hiển thị') }}:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-control select2" name="print">
                                    @if($employee->print == 1)
                                        <option value="1">Bảng lương</option>
                                        <option value="2">Chấm công</option>
                                        <option value="3">Bảng lương - Chấm công</option>
                                    @elseif($employee->print == 2)
                                        <option value="2">Chấm công</option>
                                        <option value="1">Bảng lương</option>
                                        <option value="3">Bảng lương - Chấm công</option>
                                    @else($employee->print == 3)
                                        <option value="3">Bảng lương - Chấm công</option>
                                        <option value="1">Bảng lương</option>
                                        <option value="2">Chấm công</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <!-- <div class="col-lg-2"><b>Thanh lý HĐLĐ:</b></div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select class="form-control select2" name="finish">
                                    @if($employee->finish == 1)
                                        <option value="1">Có</option>
                                        <option value="0">Không</option>
                                    @else($employee->finish == 0)
                                        <option value="0">Không</option>
                                        <option value="1">Có</option>
                                    @endif
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
                	<div class="avatar-demo">
                		<img src="{{ asset(empty($employee->avatar) ? RBOOKS_NO_IMAGE_URL : $employee->avatar) }}" class="img-circle" width="100%" height="100%" type="file" name="be_image" value="{{ $employee->avatar }}">
                	</div>
                    <input type="file" name="fImages" style="width: 100%">
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
    });
</script>
@endsection
