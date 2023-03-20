@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ trans('home.Danh sách hợp đồng lao động') }}</h3>
                <div class="box-tools">
                    <a href="{{ route('laborcontracts-add', ['employeeid' => $employeeid]) }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</a>
                </div>
            </div>

            <div class="box-body">
                <div class="about-employees">
                    <div class="about about-1 clearfix">
                        <div class="about-item">
                            <span>{{ trans('home.Nhân viên') }}:</span>
                            <span><b>[{{ $employee->id_staff }}] {{ $employee->fullname }}</b></span>
                        </div>
                        <div class="about-item">
                            <span>{{ trans('home.Ngày làm chính thức') }}:</span>
                            <span>
                                <b>
                                    {{ date("d/m/Y", strtotime($employee->begin_official_workday)) }}
                                </b>
                            </span>
                        </div>
                    </div>
                    <div class="about about-2">
                        <div class="about-item">
                            <span>{{ trans('home.Chức vụ') }}:</span>
                            <span><b>{{$employee->position()->first() == NULL ? "" : $employee->position()->first()->name }}</b></span>
                        </div>
                    </div>
                    <div class="about about-3">
                        <div class="about-item">
                            <span>{{ trans('home.Phòng ban') }}:</span>
                            <span><b>{{ $employee->department()->first() == Null ? "" : $employee->department()->first()->name }}</b></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align: center;">{{ trans('home.STT') }}</th>
                            <th width="18%" style="text-align: center;">{{ trans('home.Hợp đồng') }}</th>
                            <th width="18%" style="text-align: center;">{{ trans('home.Từ ngày') }}</th>
                            <th width="18%" style="text-align: center;">{{ trans('home.Đến ngày') }}</th>
                            <th width="20%" style="text-align: center;">{{ trans('home.Ghi chú') }}</th>
                            <th style="text-align: center;">{{ trans('home.Kích hoạt') }}</th>
                            <th width="10%" style="text-align: center;">{{ trans('home.Chức năng') }}</th>
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
                        @foreach($collections as $model)
                            <tr>
                                <td style="text-align: center;">{{ $i++ }}</td>
                                <td style="text-align: left;">{{ $labortype[$model->labortype] }}</td>
                                <td style="text-align: center;">{{ $model->fromdate == null ? "" : date("d/m/Y", strtotime($model->fromdate)) }}</td>
                                <td style="text-align: center;">{{ $model->todate == null ? "" : date("d/m/Y", strtotime($model->todate))  }}</td>
                                <td style="text-align: left;">{{ $model->description }}</td>
                                <td style="text-align: center;">
                                    @if($model->active == 1)
                                        <img src="{{ asset('image/check.gif') }}">        
                                    @endif                                
                                </td>
                                <td style="text-align: center;">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{ trans('home.Thao tác') }} <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="{{ route('laborcontracts-edit', ['employeeid' => $employeeid, 'id'=> $model->id]) }}"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> {{ trans('home.Chỉnh sửa') }}</a></li>
                                            <li><a href="javascript:void(0)" data-id="{{ $model->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> {{ trans('home.Xóa') }}</a>
                                                <form style="margin: 0;" name="form-delete-{{ $model->id }}" method="post" action="{{ route('laborcontracts-delete', ['employeeid' => $employeeid, 'id' => $model->id]) }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete') }}
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<div>
    <a href="{{  route('employees-detail', ['id' => $employeeid]) }}" class="btn btn-default btn-cancel" style="width: 8%;"><i class="fa fa-arrow-left"></i> {{ trans('home.Quay lại') }}</a>   
</div>
@endsection

@section('scripts')
@include('user-employees.laborcontract.partials.script')
@endsection
