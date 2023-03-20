@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('product-manage.customer.partials.search-form')
<div class="box box-table customer">
    <div class="box-content">
        <div class="box-header">
            <h2 class="box-title">
                Danh sách khách hàng
            </h2>
            <div class="pagination-group">
                {{ $collections->links() }}
            </div>
        </div>

        <div class="box-body">
            <div class="box-info">
                <p>{{ trans('home.Hiển thị') }} {{ $filter['limit'] }} {{ trans('home.dòng / trang') }}</p>
            
                <div class="box-tools">
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('customers-add') }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</a>
                        <a href="{{ route('customers-export') }}" class="btn btn-default"><i class="fas fa-download" aria-hidden="true"></i> {{ trans('home.Xuất tất cả') }}</a>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> {{ trans('home.Hiển thị') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('customers-index', filter_data($filter, 'limit', 10)) }}">10 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('customers-index', filter_data($filter, 'limit', 25)) }}">25 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('customers-index', filter_data($filter, 'limit', 50)) }}">50 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('customers-index', filter_data($filter, 'limit', 100)) }}">100 {{ trans('home.dòng / trang') }}</a></li>
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-sort" aria-hidden="true"></i> {{ trans('home.Sắp xếp') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('customers-index', filter_data($filter, 'orderBy', 'id')) }}">{{ trans('home.Mã khách hàng') }}</a></li>
                                <li><a href="{{ route('customers-index', filter_data($filter, 'orderBy', 'fullname')) }}">{{ trans('home.Tên khách hàng') }}</a></li>
                                <li><a href="{{ route('customers-index', filter_data($filter, 'orderBy', 'gender')) }}">{{ trans('home.Giới tính') }}</a></li>
                                <li><a href="{{ route('customers-index', filter_data($filter, 'orderBy', 'email')) }}">{{ trans('home.Email') }}</a></li>
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if($filter['sortedBy'] == 'asc' || empty($filter['sortedBy']))
                                    <i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}
                                @else
                                    <i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}
                                @endif
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('customers-index', filter_data($filter, 'sortedBy', 'desc')) }}"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}</a></li>
                                <li><a href="{{ route('customers-index', filter_data($filter, 'sortedBy', 'asc')) }}"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-nowrap" width="1%">STT</th>
                        <th class="text-nowrap text-left" width="20%">{{ trans('home.Tên khách hàng') }}</th>
                        <th class="text-nowrap">{{ trans('home.Sinh nhật') }}</th>
                        <th class="text-nowrap">{{ trans('home.Giới tính') }}</th>
                        <th class="text-nowrap">{{ trans('home.Số điện thoại') }}</th>
                        <th class="text-nowrap">{{ trans('home.Email') }}</th>
                        <th class="text-nowrap">Nhóm KH</th>
                        <th class="text-nowrap">{{ trans('home.Chức năng') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @if($collections->count() === 0)
                    <tr>
                        <td colspan="8"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                    </tr>
                    @endif
                    @foreach($collections as $customer)
                    <tr>
                        <td class="text-nowrap text-center">{{ $customer->id }}</td>
                        <td class="text-nowrap">{{ $customer->fullname }}</td>
                        <td class="text-nowrap text-center">{{ Carbon\Carbon::parse($customer->birthday)->format('d-m-Y') }}</td>
                        @if($customer->gender===1)
                            <td class="text-nowrap text-center">{{ trans('home.Nam') }}</td>
                        @else
                            <td class="text-nowrap text-center">{{ trans('home.Nữ') }}</td>
                        @endif
                        <td class="text-nowrap text-center">{{ $customer->phone }}</td>
                        <td class="text-nowrap text-center">{{ $customer->email }}</td>
                        <td class="text-nowrap text-center">
                            <ul style="list-style-type:none; margin: 0px; padding: 0px;">
                                @foreach($customer->groups as $group)
                                <li>
                                    {{ $group->name }}
                                </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="text-center">
                            <a href="#" title="Xem chi tiết"><i class="fa fa-eye" aria-hidden="true"></i></a>

                            <a href="{{ route('customers-edit',['id'=> $customer->id]) }}" title="Chỉnh sửa"><i class="fas fa-pencil-alt"></i></a>

                            <a href="javascript:void(0)" data-id="{{ $customer->id }}" class="btn-delete" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <form name="form-delete-{{ $customer->id }}" method="post" action="{{ route('customers-delete', ['id'=> $customer->id]) }}">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="box-footer text-right">
            {{ $collections->links() }}
        </div>
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
