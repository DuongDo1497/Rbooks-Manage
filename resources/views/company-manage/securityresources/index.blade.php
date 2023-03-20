@extends('layouts.master')

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Danh sách phân quyền chức năng</h3>
                <div class="box-tools">
                    <a href="{{ route('securityresources-add', ['applicationresourceid'=>$applicationresourceid]) }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> Tạo mới</a>
                </div>
            </div>

            <div class="box-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align: center;">STT</th>
                            <th width="10%" style="text-align: center;">Nhóm truy cập</th>
                            <th width="12%" style="text-align: center;">Trang chức năng</th>
                            <th width="20%" style="text-align: center;">File name</th>
                            <th width="5%" style="text-align: center;">View</th>
                            <th width="5%" style="text-align: center;">Add</th>
                            <th width="5%" style="text-align: center;">Delete</th>
                            <th width="5%" style="text-align: center;">Update</th>
                            <th width="5%" style="text-align: center;">Approve</th>
                            <th width="15%" style="text-align: center;">User view</th>
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
                                <td style="text-align: center;">{{ $model->rolecode }}</td>
                                <td style="text-align: center;">{{ $model->resourcecode }}</td>
                                <td style="text-align: left;">{{ $model->filename }}</td>
                                <td style="text-align: center;">
                                    @if($model->cview == 1)
                                        <img src="{{ asset('image/check.gif') }}">        
                                    @endif                                
                                </td>
                                <td style="text-align: center;">
                                    @if($model->cadd == 1)
                                        <img src="{{ asset('image/check.gif') }}">        
                                    @endif                                
                                </td>
                                <td style="text-align: center;">
                                    @if($model->cdelete == 1)
                                        <img src="{{ asset('image/check.gif') }}">        
                                    @endif                                
                                </td>
                                <td style="text-align: center;">
                                    @if($model->cupdate == 1)
                                        <img src="{{ asset('image/check.gif') }}">        
                                    @endif                                
                                </td>
                                <td style="text-align: center;">
                                    @if($model->capprove == 1)
                                        <img src="{{ asset('image/check.gif') }}">        
                                    @endif                                
                                </td>
                                <td style="text-align: left;">
                                    {{ $model->cuserview }}
                                </td>
                                <td style="text-align: center;">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Thao tác <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="{{ route('securityresources-edit', ['applicationresourceid'=>$applicationresourceid, 'id'=> $model->id]) }}"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> Chỉnh sửa</a></li>
                                            <li><a href="javascript:void(0)" data-id="{{ $model->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
                                                <form style="margin: 0;" name="form-delete-{{ $model->id }}" method="post" action="{{ route('securityresources-delete', ['applicationresourceid'=>$applicationresourceid, 'id' => $model->id]) }}">
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
<a href="{{ route('applicationresources-index') }}" style="width: 16%;"><i class="fa fa-arrow-left"></i> Quay lại</a>
</div>
@endsection

@section('scripts')
@include('company-manage.securityresources.partials.script')
@endsection
