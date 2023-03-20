@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">

<style type="text/css">
    .reset-date{
        display: inline-block;
        vertical-align: middle;
        position: relative;
    }

    .reset-date > input{
        float: left;
        width: 60%;
        margin-right: 2%;
        height: 30px;
    }

    .reset-date > a{
        width: 38%;
    }
</style>
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('company-manage.emplperday.partials.search-form')

@include('company-manage.emplperday.add')

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    {{ trans('home.Danh sách quản lý phép') }}
                    <small>({{ trans('home.Hiển thị') }} {{ $filter['limit'] }} {{ trans('home.dòng / trang') }}) </small>
                </h3>
                <div class="box-tools">
                    <!-- <div class="reset-date btn-group btn-group-sm clearfix">
                        <input type="date" class="form-control" name="resetdate">
                        <a href="#" class="btn btn-default">Tính lại tháng</a>
                    </div> -->
                    <div class="btn-group btn-group-sm">
                        <div class="btn-group btn-group-sm">
                            <a href="#"  data-toggle="modal" data-target="#getFormAdd" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</a>
                            <a class="btn btn-default" href="#"><i class="fa fa-download"></i> {{ trans('home.Xuất tất cả') }}</a>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-download" aria-hidden="true"></i> {{ trans('home.Xuất danh sách') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#"><i class="fa fa-file-text" aria-hidden="true"></i> {{ trans('home.Xuất tất cả') }}</a></li>
                                <li><a href="#"><i class="fa fa-file-text" aria-hidden="true"></i> {{ trans('home.Xuất tùy chọn') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> {{ trans('home.Hiển thị') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('emplperdays-index', filter_data($filter, 'limit', 10)) }}">10 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('emplperdays-index', filter_data($filter, 'limit', 25)) }}">25 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('emplperdays-index', filter_data($filter, 'limit', 50)) }}">50 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('emplperdays-index', filter_data($filter, 'limit', 100)) }}">100 {{ trans('home.dòng / trang') }}</a></li>
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
                                    <input type="checkbox" class="minimal checkbox-item">
                                </label>
                            </th>
                            <th width="2.5%">{{ trans('home.STT') }}</th>
                            <th class="text-nowrap">{{ trans('home.Mã nhân viên') }}</th>
                            <th class="text-nowrap" width="10%">{{ trans('home.Họ tên') }}</th>
                            <th class="text-nowrap">{{ trans('home.Ngày chính thức') }}</th>
                            <th class="text-nowrap">{{ trans('home.Năm') }}</th>
                            <th class="text-nowrap">{{ trans('home.Phép tồn năm trước') }}</th>
                            <th class="text-nowrap">{{ trans('home.Phép được hưởng') }}</th>
                            @for($i = 1; $i <= 12; $i++)
                                <th class="text-nowrap">{{ $i }}</th>
                            @endfor
                            <th class="text-nowrap">{{ trans('home.Phép đã nghỉ') }}</th>
                            <th class="text-nowrap">{{ trans('home.Phép còn lại') }}</th>
                            <th class="text-nowrap">
                                <span class="lbl-action">{{ trans('home.Chức năng') }}</span>
                                <button class="btn btn-danger btn-xs btn-block hide btn-delete-selected">{{ trans('home.Xóa') }} <span class="lbl-selected-rows-count">0</span> {{ trans('home.đã chọn') }}</button>
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
                            $i = 1;
                        @endphp
                        @foreach($collections as $emplperday)
                        	<tr>
                                <td>
                                    <label>
                                        <input type="checkbox" class="minimal checkbox-item">
                                    </label>
                                </td>
                                <td>{{ $i }}</td>
                                <td>{{ $emplperday->employee()->first()->id_staff }}</td>
                                <td>{{ $emplperday->employee()->first()->fullname }}</td>
                                <td>{{ date("d-m-Y", strtotime($emplperday->employee()->first()->begin_official_workday)) }}</td>
                                <td>{{ $emplperday->year }}</td>
                                <td>{{ $emplperday->permission_lastyear }}</td>
                                <td>{{ $emplperday->permission_curryear }}</td>
                                @foreach($emplperday->listcheckemplInYear as $key => $value)
                                <td>{{ $value }}</td>
                                @endforeach
                                <td>{{ $emplperday->permission_leave }}</td>
                                <td>{{ $emplperday->permission_left }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-cog"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="{{ route('emplperdays-edit', ['id' => $emplperday->id]) }}"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> {{ trans('home.Chỉnh sửa nội dung') }}</a></li>
                                            <li>
                                                <a href="javascript:void(0)" data-id="" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> {{ trans('home.Xóa') }}</a>
                                                <form name="form-delete" method="post" action="">
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
<script>
    $(function() {
        $('.btn-delete').click(function(){
            var id = $(this).data('id');
            swal({
                title: "{{ trans('home.Bạn có chắc không?') }}",
                text: "{{ trans('home.Nội dung xóa sẽ được đưa vào thùng rác') }}",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((value) => {
                console.log(value);
                if(value) {
                    document.forms['form-delete-'+id].submit();
                }
            });
        });

        @if(!empty($filter['searchFields']))
        $('#searchFields').val('{{ $filter['searchFields'] }}').trigger('change');
        @endif

    });
</script>
@endsection