@extends('layouts.master')

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">APPLICATION MODULES</h3>
                <div class="box-tools">
                    <a href="{{ route('applicationmodules-add') }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> Tạo mới</a>
                </div>
            </div>
            <div class="box-body" style="font-size:11pt;">
            - Các module sẽ hiển thị trên menu. Menu này sẽ được hiển thị bên trái người dìng.<br> 
            - Trong các module này sẽ bao gồm danh sách các Page (route) truy cập theo từng mức menu của hệ thống.
            </div>
            <div class="box-body no-padding">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align: center;">STT</th>
                            <th width="10%" style="text-align: center;">Mã module</th>
                            <th width="25%" style="text-align: center;">Tên module</th>
                            <th width="8%" style="text-align: center;">Hiển thị/Ẩn</th>
                            <th width="7%" style="text-align: center;">Thứ tự <br> hiển thị</th>
                            <th width="5%" style="text-align: center;">Image</th>
                            <th width="20%" style="text-align: center;">Nhóm menu chức năng</th>
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
                                <td style="text-align: left;">{{ $model->code }}</td>
                                <td style="text-align: left;">{{ $model->applicationmodulename }}</td>
                                <td style="text-align: center;">
                                    @if($model->hidden == 1)
                                        <img src="{{ asset('image/check.gif') }}">        
                                    @endif                                
                                </td>
                                <td style="text-align: center;">{{ $model->displayorder }}</td>
                                <td style="text-align: center;">{{ $model->image }}</td>
                                <td style="text-align: center;"><a href="{{ route('applicationfunctiongroups-index', ['id'=> $model->id]) }}">Nhóm menu</a></td>
                                <td style="text-align: center;">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Thao tác <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="{{ route('applicationmodules-edit', ['id'=> $model->id]) }}"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> Chỉnh sửa</a></li>
                                            <li><a href="javascript:void(0)" data-id="{{ $model->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
                                                <form style="margin: 0;" name="form-delete-{{ $model->id }}" method="post" action="{{ route('applicationmodules-delete', ['id' => $model->id]) }}">
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
@endsection

@section('scripts')
@include('company-manage.applicationmodules.partials.script')
@endsection
