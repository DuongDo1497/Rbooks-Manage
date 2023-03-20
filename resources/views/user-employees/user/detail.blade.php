@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('content')

<div class="row">

    <div class="col-md-3">
        <div class="employee-left">
            <div class="employee-avatar">
                <a href="#">
                    <img src="#" class="img-circle" width="100%" height="100%">
                </a>
            </div>
            <h3 class="employee-name"><b>{{ $detai_employee->fullname }}</b></h3>
            <p class="employee-status">{{ $detai_employee->position_name }}
            
            </p>
            <div class="registration">
                <span><a href="{{ route('checkemployee-empl', [ 'parameter' => $parameter ]) }}" class="btn btn-primary btn-registration">{{ trans('home.Đăng ký nghỉ phép') }}</a></span>
                <span><a href="{{ route('checkbusiness-empl', [ 'parameter' => $parameter ]) }}" class="btn btn-primary btn-registration">{{ trans('home.Công tác') }}</a></span>
            </div>
        </div>
        <div class="employee-notification">
            <div class="panel panel-default">
                <div class="panel-heading"><h5><b>{{ trans('home.THÔNG BÁO') }}</b></h5></div>
                <div class="panel-body">
                    <ul>
                        <li class="clearfix">
                            <span class="icon"><i class="fa fa-birthday-cake"></i></span>
                            <span class="text"><a href="#" data-toggle="modal" data-target="#getBirthday">{{ trans('home.Thông báo sinh nhật trong tháng') }}</a></span>
                            <span class="count">{{ $birthdayInMonth->count() }}</span>
                        </li>
                        <li class="clearfix">
                            <span class="icon"><i class="fa fa-check-circle"></i></span>
                            <span class="text"><a href="#" data-toggle="modal" data-target="#getCheckEmployee">{{ trans('home.Thông báo nhân sự xin nghỉ hôm nay và ngày mai') }}</a></span>
                            <span class="count">{{ $checkemplInDay->count() }}</span>
                        </li>
                        <li class="clearfix">
                            <span class="icon"><i class="fa fa-check-circle"></i></span>
                            <span class="text"><a href="#" data-toggle="modal" data-target="#getCheckBusiness">{{ trans('home.Thông báo nhân sự xin công tác hôm nay và ngày mai') }}</a></span>
                            <span class="count">{{ $checkbusiInDay->count() }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>        
    </div>

    <div class="col-md-4">
        <div class="employee-center">
            <div class="employee-personal">
                <div class="head-title">
                    <div class="row">
                        <div class="col-md-8"><h3 class="title"><b><i class="fa fa-address-card"></i> {{ trans('home.THÔNG TIN CÁ NHÂN') }}</b></h3></div>
                        <div class="col-md-4"></div>
                    </div>
                </div>

                <hr style="margin: 10px 0 10px 0;">

                <div class="content">
                    <div class="item">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Mã nhân viên') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->id_staff }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Họ tên') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->fullname }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Tuổi') }}:</b></td>
                                    <td width="60%">{{ (Carbon\Carbon::now()->year) - (substr($detai_employee->birthday, 0, 4)) }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Giới tính') }}:</b></td>
                                    @if($detai_employee->gender == 0)
                                        <td width="60%">Nữ</td>
                                    @elseif($detai_employee->gender == 1)
                                        <td width="60%">Nam</td>
                                    @else
                                        <td width="60%">Khác</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Ngày sinh') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->birthday }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.CMND/CCCD') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->id_No }} - {{ $detai_employee->identycarddate == NUll ? "" : date("d/m/Y", strtotime($detai_employee->identycarddate)) }} - {{ $detai_employee->identycardplace_issue }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Hôn nhân') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->maritalstatus }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="item">
                        <h5><b>{{ trans('home.Thông tin liên lạc') }}</b></h5>
                        <hr style="margin: 0 0 10px 0;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Điện thoại') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->phone }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Địa chỉ') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->address }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Địa chỉ thường trú') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->temporaryaddress }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Quê quán') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->cityprovince_name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="item">
                        <h5><b>{{ trans('home.Thông tin khác') }}</b></h5>
                        <hr style="margin: 0 0 10px 0;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Số tài khoản') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->account_No }} - {{ $detai_employee->bankname }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Mã số thuế') }}:</b></td>
                                    @if($detai_employee->personaltaxcode != NULL)
                                        <td width="60%">{{ $detai_employee->personaltaxcode }}</td>
                                    @else
                                        <td width="60%">-</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="employee-right">
            <div class="employee-company">
                <div class="head-title">
                    <div class="row">
                        <div class="col-md-7"><h3 class="title"><b><i class="fa fa-briefcase"></i> {{ trans('home.THÔNG TIN CÔNG VIỆC') }}</b></h3></div>
                        <div class="col-md-5">
                            <div class="dropdown menu-employee">
                              <button type="button" class="btn btn-primary dropdown-toggle clearfix" data-toggle="dropdown">
                                <span>{{ trans('home.Quá trình nhân sự') }}</span><i class="fa fa-sort-desc"></i>
                              </button>
                                @php
                                    $parameter =  $detai_employee->id;
                                    $parameter= Crypt::encrypt($parameter);
                                @endphp
                              <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('payrolls-index', [ 'parameter' => $parameter ]) }}" data-name="">{{ trans('home.Lương công việc') }}</a>
                                <a class="dropdown-item" href="{{ route('insurances-index', [ 'parameter' => $parameter ]) }}" data-name="">{{ trans('home.Bảo hiểm xã hội') }}</a>
                                <a class="dropdown-item" href="{{ route('laborcontracts-index', [ 'parameter' => $parameter ]) }}" data-name="">{{ trans('home.Hợp đồng lao động') }}</a>
                                <a class="dropdown-item" href="{{ route('familyrlships-index', [ 'parameter' => $parameter ]) }}" data-name="">{{ trans('home.Quan hệ nhân thân') }}</a>                                
                                <a class="dropdown-item" href="{{ route('experiences-index', [ 'parameter' => $parameter ]) }}" data-name="">{{ trans('home.Kinh nghiệm làm việc') }}</a>                                
                                <a class="dropdown-item" href="{{ route('educations-index', [ 'parameter' => $parameter ]) }}" data-name="">{{ trans('home.Các khóa đào tạo') }}</a>                                
                                <a class="dropdown-item" href="{{ route('historyworks-index', [ 'parameter' => $parameter ]) }}" data-name="">{{ trans('home.Quá trình công tác') }}</a>                                
                                <a class="dropdown-item" href="{{ route('disciplines-index', [ 'parameter' => $parameter ]) }}" data-name="">{{ trans('home.Khen thưởng/kỷ luật') }}</a>                                
                              </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr style="margin: 10px 0 10px 0;">

                <div class="content">
                    <div class="item">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Trạng thái') }}:</b></td>
                                    @if($detai_employee->status == 1)
                                        <td width="60%"><span class="alert alert-success"><b>{{ trans('home.Đang làm việc') }}</b></span></td>
                                    @elseif($detai_employee->status == 2)
                                        <td width="60%"><span class="alert alert-success"><b>{{ trans('home.Thử việc') }}</b></span></td>
                                    @elseif($detai_employee->status == 3)
                                        <td width="60%"><span class="alert alert-success"><b>{{ trans('home.Thực tập') }}</b></span></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Phòng ban') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->department_name }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Bộ phận') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->division_name }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Chức vụ') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->position_name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="item">
                        <h5><b>{{ trans('home.Thông tin hợp đồng') }}</b></h5>
                        <hr style="margin: 0 0 10px 0;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Ngày kí hợp đồng') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->laborcontractfromdate == NUll ? "" : date("d/m/Y", strtotime($detai_employee->laborcontractfromdate)) }} - {{ $detai_employee->laborcontracttodate == NUll ? " " : date("d/m/Y", strtotime($detai_employee->laborcontracttodate)) }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Loại hợp đồng') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->laborcontractlabortype }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Ngày vào làm') }}:</b></td>
                                    <td width="60%">{{ date("d/m/Y", strtotime($detai_employee->begin_workday)) }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Ngày làm chính thức') }}:</b></td>
                                    <td width="60%">{{ date("d/m/Y", strtotime($detai_employee->begin_official_workday)) }} - {{ (Carbon\Carbon::now()->year) - (substr($detai_employee->begin_official_workday, 0, 4)) }}/{{ (Carbon\Carbon::now()->month) - (substr($detai_employee->begin_official_workday, 5, 2)) }} (Năm/Tháng)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="item">
                        <h5><b>{{ trans('home.Thông tin nghỉ phép') }}</b></h5>
                        <hr style="margin: 0 0 10px 0;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Số phép theo quy định') }}:</b></td>
                                    <td width="60%">
                                    {{ formatNumber($detai_employee->permission_curryear, 1, 2, 1) }}
                                    <b> - {{ trans('home.Phép tồn') }}:</b> {{ formatNumber($detai_employee->permission_lastyear, 1, 2, 1) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Số phép đã nghỉ') }}:</b></td>
                                    <td width="60%">
                                    {{ formatNumber($detai_employee->permission_leave, 1, 2, 1) }}
                                    <b> - {{ trans('home.Còn lại') }}:</b> {{ formatNumber($detai_employee->permission_left, 1, 2, 1) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="item">
                        <h5><b>{{ trans('home.Thông tin trình độ') }}</b></h5>
                        <hr style="margin: 0 0 10px 0;">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Trường đào tạo') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->educationschoolname }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Hệ đào tạo') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->educationmajor }}</td>
                                </tr>
                                 <tr>
                                    <td width="40%"><b>{{ trans('home.Ngành học') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->educationdescription }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Trình độ') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->educationlevel }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 10px;">

    <div class="col-md-3"></div>

    <div class="col-md-4">
        <div class="employee-center">
            <div class="employee-personal">
                <div class="head-title">
                    <div class="row">
                        <div class="col-md-8"><h3 class="title"><b><i class="fa fa-address-card"></i> {{ trans('home.THÔNG TIN THÊM') }}</b></h3></div>
                        <div class="col-md-4"></div>
                    </div>
                </div>

                <hr style="margin: 10px 0 10px 0;">

                <div class="content">
                    <div class="item">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Email cá nhân') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->email }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Chiều cao') }}:</b></td>
                                    <td width="60%"></td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Cân nặng') }}:</b></td>
                                    <td width="60%"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="employee-right">
            <div class="employee-company">
                <div class="head-title">
                    <div class="row">
                        <div class="col-md-7"><h3 class="title"><b><i class="fa fa-briefcase"></i> {{ trans('home.CÁC QUÁ TRÌNH GẦN ĐÂY') }}</b></h3></div>
                    </div>
                </div>

                <hr style="margin: 10px 0 10px 0;">

                <div class="content">
                    <div class="item">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Thay đổi vị trí công việc') }}: </b></td>
                                    <td width="60%">{{ $detai_employee->historyworkfromdate == NUll ? "" : date("d/m/Y", strtotime($detai_employee->historyworkfromdate)) }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Số quyết định') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->historyworkdescription }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Chức vụ') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->historyworkposition_name }}</td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>{{ trans('home.Phòng ban') }}:</b></td>
                                    <td width="60%">{{ $detai_employee->historyworkdepartment_name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

@include('user-employees.user.noticeBirthday')
@include('user-employees.user.noticeCheckEmployee')
@include('user-employees.user.noticeCheckBusiness')

@endsection