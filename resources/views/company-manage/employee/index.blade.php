@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('company-manage.employee.partials.search-form')

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ trans('home.Danh sách nhân viên') }}</h3>
                <div class="box-tools">
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('employees-add') }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</a>
                        <a class="btn btn-default" href="#"><i class="fa fa-download"></i> {{ trans('home.Xuất tất cả') }}</a>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> {{ trans('home.Hiển thị') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('employees-index', filter_data($filter, 'limit', 10)) }}">10 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('employees-index', filter_data($filter, 'limit', 25)) }}">25 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('employees-index', filter_data($filter, 'limit', 50)) }}">50 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('employees-index', filter_data($filter, 'limit', 100)) }}">100 {{ trans('home.dòng / trang') }}</a></li>
                            </ul>
                        </div>

                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-sort" aria-hidden="true"></i> {{ trans('home.Sắp xếp') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="">{{ trans('home.Mã nhân viên') }}</a></li>
                                <li><a href="">{{ trans('home.Tên nhân viên') }}</a></li>
                                <li><a href="">{{ trans('home.Phòng ban') }}</a></li>
                                <li><a href="">{{ trans('home.Bộ phận') }}</a></li>
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <!-- @if($filter['sortedBy'] == 'asc' || empty($filter['sortedBy'])) -->
                                <i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}
                                <!-- @else -->
                                <i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}
                                <!-- @endif -->
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('employees-index', filter_data($filter, 'sortedBy', 'asc')) }}"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}</a></li>
                                <li><a href="{{ route('employees-index', filter_data($filter, 'sortedBy', 'desc')) }}"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="1%">
                                <label>
                                    <input type="checkbox" class="minimal checkbox-all" value="1">
                                </label>
                            </th>
                            <th class="text-nowrap" width="1%">{{ trans('home.STT') }}</th>
                            <th class="text-nowrap" width="5%">{{ trans('home.Mã NV') }}</th>
                            <th class="text-nowrap" width="16%">{{ trans('home.Tên nhân viên') }}</th>
                            <th class="text-nowrap">{{ trans('home.Phòng ban') }}</th>
                            <th class="text-nowrap">{{ trans('home.Bộ phận') }}</th>
                            <th class="text-nowrap">{{ trans('home.Chức vụ') }}</th>
                            <th class="text-nowrap" width="8%">{{ trans('home.Giới tính') }}</th>
                            <th class="text-nowrap" width="8%">{{ trans('home.Ngày sinh') }}</th>
                            <th class="text-nowrap">{{ trans('home.Ngày chính thức') }}</th>
                            <th class="text-nowrap">{{ trans('home.Hình thức') }}</th>
                            <th width="8%">
                                <span class="lbl-action">{{ trans('home.Chức năng') }}</span>
                                <button class="btn btn-danger btn-xs btn-block hide btn-delete-selected">{{ trans('home.Xóa') }} <span class="lbl-selected-rows-count">0</span> {{ trans('home.nhân viên') }}</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($collections->count() === 0)
                            <tr>
                                <td colspan="8"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                            </tr>
                        @endif

                        @php
                        $i = 1
                        @endphp
                        @foreach($collections as $employee)
                        <tr>
                            <td>
                                <label>
                                    <input type="checkbox" class="check_employee minimal checkbox-item" value="{{ $employee->id }}">
                                </label>
                            </td>
                            <td>{{ $i }}</td>
                            <td>{{ $employee->id_staff }}</td>
                            <td>{{ $employee->fullname }}</td>
                            <td>{{ $employee->department_id == NULL ? "" : $employee->department()->first()->name }}</td>
                            <td>{{ $employee->division_id == NULL ? "" : $employee->division()->first()->name }}</td>
                            <td>{{ $employee->position_id == NULL ? "" : $employee->position()->first()->name }}</td>
                            <td>
                                @if($employee->gender == 0)
                                    Nữ
                                @elseif($employee->gender == 1)
                                    Nam
                                @else($employee->gender == 2)
                                    Khác
                                @endif
                            </td>
                            <td>{{ date("d/m/Y", strtotime($employee->birthday)) }}</td>
                            <td>{{ date("d/m/Y", strtotime($employee->begin_official_workday)) }}</td>
                            <td>
                                @if ($employee->status == 1)
                                    <span class="alert-success">Chính thức</span>
                                @elseif ($employee->status == 2)
                                    <span class="alert-info"></span>Thử việc
                                @elseif ($employee->status == 3)
                                    <span class="alert-warning">Thực tập</span>
                                @else
                                    <span class="alert-danger">Nghỉ việc</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                    @php
                                        $parameter =  $employee->id;
                                        $parameter= Crypt::encrypt($parameter);
                                    @endphp
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{ route('employees-detail', ['id' => $parameter]) }}"><i class="fa fa-info-circle" aria-hidden="true"></i> {{ trans('home.Chi tiết') }}</a></li>
                                        <li><a href="{{ route('employees-edit', ['id' => $parameter]) }}"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> {{ trans('home.Chỉnh sửa nội dung') }}</a></li>
                                        <li><a href="#" data-toggle="modal" data-target="#employeepermissiondays"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> {{ trans('home.Đăng ký ngày nghỉ') }}</a></li>
                                        <li>
                                            <a href="javascript:void(0)" data-id="{{ $employee->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> {{ trans('home.Xóa') }}</a>
                                            <form name="form-delete-{{ $employee->id }}" method="post" action="{{ route('employees-delete', ['id' => $employee->id ]) }}">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @php
                        $i++
                        @endphp

                        @include('company-manage.employee.partials.employee_permission_days')

                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix text-right">
                {{ $collections->links() }}
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection

@section('scripts')
@include('company-manage.employee.partials.script')
@endsection
