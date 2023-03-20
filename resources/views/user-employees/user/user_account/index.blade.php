@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
@if(session()->has('errors'))
    @include('layouts.partials.messages.errors')
@endif

@include('user-employees.user.user_account.partials.search-form')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    Danh sách
                    <small>(Hiển thị {{ $filter['limit'] }} dòng / trang) </small>
                </h3>
                <div class="box-tools">
                    <div class="btn-group btn-group-sm">
                        <a class="btn btn-default clearfix" href="{{ route('users-add') }}"><i class="fa fa-plus" aria-hidden="true"></i> Tạo mới</a>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> Hiển thị
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('users-index', filter_data($filter, 'limit', 10)) }}">10 dòng / trang</a></li>
                                <li><a href="{{ route('users-index', filter_data($filter, 'limit', 25)) }}">25 dòng / trang</a></li>
                                <li><a href="{{ route('users-index', filter_data($filter, 'limit', 50)) }}">50 dòng / trang</a></li>
                                <li><a href="{{ route('users-index', filter_data($filter, 'limit', 100)) }}">100 dòng / trang</a></li>
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
                                    <input type="checkbox" class="minimal checkbox-all">
                                </label>
                            </th>
                            <th>#</th>
                            <th class="text-nowrap">Tên</th>
                            <th class="text-nowrap">Email</th>
                            <th class="text-nowrap">Quyền truy cập</th>
                            <th class="text-nowrap">Ngày khởi tạo</th>
                            <th class="text-nowrap">Ngày chỉnh sửa</th>
                            <th class="text-nowrap">
                                <span class="lbl-action">Chức năng</span>
                                <button class="btn btn-danger btn-xs btn-block hide btn-delete-selected">Xóa <span class="lbl-selected-rows-count">0</span> đã chọn</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($collections->count() === 0)
                        <tr>
                            <td colspan="8"><b>Không có dữ liệu!!!</b></td>
                        </tr>
                        @endif
                        @php
                            $i = 1
                        @endphp
                        @foreach($collections as $user)
                            <tr>
                                <td>
                                    <label>
                                        <input type="checkbox" class="minimal checkbox-item">
                                    </label>
                                </td>
                                <td>{{ $i }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->created_at == null ? "" : ConvertSQLDate($user->created_at, 1) }}</td>
                                <td>{{ $user->updated_at == null ? "" : ConvertSQLDate($user->updated_at, 1) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Thao tác <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="{{ route('users-edit', ['id' => $user->id]) }}"><i class="fas fa-pencil-alt"></i> Chỉnh sửa</a></li>
                                            <li>
                                                <a href="javascript:void(0)" data-id="{{ $user->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
                                                <form name="form-delete-{{ $user->id }}" method="post" action="{{ route('users-delete', ['id'=> $user->id]) }}">
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
                {{ $collections->appends(array('searchField'=>$searchField,'searchValue'=>$searchValue))->links() }}
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
            if(confirm('Bạn có muốn xóa không?')){
                document.forms['form-delete-'+ id].submit();
            }
        });

        @if(!empty($filter['searchFields']))
        $('#searchFields').val('{{ $filter['searchFields'] }}').trigger('change');
        @endif
    });
</script>
@endsection
