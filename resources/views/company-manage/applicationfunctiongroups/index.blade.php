@extends('layouts.master')

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <font size='4'><b>APPLICATION MODULE:</b> {{ $applicationmodules->applicationmodulename }}</font>
            </div>

            <div class="box-header">
                <h3 class="box-title">APPLICATION FUNCTION GROUPS</h3>
                <div class="box-tools">
                    <a href="{{ route('applicationfunctiongroups-add', ['applicationmoduleid' => $applicationmoduleid]) }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> Tạo mới</a>
                </div>
            </div>

            <div class="box-footer">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align: center;">STT</th>
                            <th width="35%" style="text-align: center;">Nhóm menu</th>
                            <th width="10%" style="text-align: center;">Thứ tự</th>
                            <th width="15%" style="text-align: center;">Image</th>
                            <th width="25%" style="text-align: center;">File name</th>
                            <th width="20%" style="text-align: center;">Chức năng</th>
                            <th style="text-align: center;">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if($collections->count() === 0)
                            <tr>
                                <td colspan="8"><b>Không có dữ liệu</b></td>
                            </tr>
                        @endif
                        @php
                            $i = 1
                        @endphp
                        @foreach($collections as $model)
                            <tr>
                                <td style="text-align: center;">{{ $i++ }}</td>
                                <td style="text-align: left;">{{ $model->name }}</td>
                                <td style="text-align: center;">{{ $model->displayorder }}</td>
                                <td style="text-align: center;">{{ $model->image }}</td>
                                <td style="text-align: left;">{{ $model->applicationresources()->first() == null ? '' : $model->applicationresources()->first()->filename }}</td>
                                <td style="text-align: center;"><a href="{{ route('functionassignment-index', ['applicationmoduleid'=> $applicationmoduleid, 'applicationfunctiongroupid'=> $model->id]) }}">Chức năng</a></td>
                                <td style="text-align: center;">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Thao tác <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="{{ route('applicationfunctiongroups-edit', ['applicationmoduleid' => $applicationmoduleid, 'id'=> $model->id]) }}"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> Chỉnh sửa</a></li>
                                            <li><a href="javascript:void(0)" data-id="{{ $model->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
                                                <form style="margin: 0;" name="form-delete-{{ $model->id }}" method="post" action="{{ route('applicationfunctiongroups-delete', ['applicationmoduleid' => $applicationmoduleid, 'id' => $model->id]) }}">
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
    <a href="{{  route('applicationmodules-index') }}" class="btn btn-default btn-cancel" style="width: 8%;"><i class="fa fa-arrow-left"></i> Quay lại</a>   
</div>
@endsection

@section('scripts')
@include('company-manage.applicationfunctiongroups.partials.script')
@endsection
