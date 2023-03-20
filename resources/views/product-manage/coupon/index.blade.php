@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('product-manage.coupon.partials.search-form')
<div class="box box-table coupon">
    <div class="box-content">
        <div class="box-header">
            <h2 class="box-title">
                {{ trans('home.Danh sách mã giảm giá') }}
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
                        <a href="{{ route('coupons-add') }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</a>
                        <a href="#" class="btn btn-default"><i class="fas fa-download" aria-hidden="true"></i> {{ trans('home.Xuất tất cả') }}</a>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> {{ trans('home.Hiển thị') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('coupons-index', filter_data($filter, 'limit', 10)) }}">10 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('coupons-index', filter_data($filter, 'limit', 25)) }}">25 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('coupons-index', filter_data($filter, 'limit', 50)) }}">50 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('coupons-index', filter_data($filter, 'limit', 100)) }}">100 {{ trans('home.dòng / trang') }}</a></li>
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-sort" aria-hidden="true"></i> {{ trans('home.Sắp xếp') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('coupons-index', filter_data($filter, 'orderBy', 'id')) }}">{{ trans('home.Mã khách hàng') }}</a></li>
                                <li><a href="{{ route('coupons-index', filter_data($filter, 'orderBy', 'fullname')) }}">{{ trans('home.Tên khách hàng') }}</a></li>
                                <li><a href="{{ route('coupons-index', filter_data($filter, 'orderBy', 'gender')) }}">{{ trans('home.Giới tính') }}</a></li>
                                <li><a href="{{ route('coupons-index', filter_data($filter, 'orderBy', 'email')) }}">{{ trans('home.Email') }}</a></li>
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
                                <li><a href="{{ route('coupons-index', filter_data($filter, 'sortedBy', 'desc')) }}"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}</a></li>
                                <li><a href="{{ route('coupons-index', filter_data($filter, 'sortedBy', 'asc')) }}"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-nowrap">STT</th>
                        <th class="text-nowrap" width="20%">{{ trans('home.Mã giảm giá') }}</th>
                        <th class="text-nowrap">{{ trans('home.% giảm giá') }}</th>
                        <th class="text-nowrap">{{ trans('home.Số lượng') }}</th>
                        <th class="text-nowrap">{{ trans('home.Đã sử dụng') }}</th>
                        <th class="text-nowrap text-left">{{ trans('home.Ghi chú') }}</th>
                        <th class="text-nowrap">{{ trans('home.Trạng thái') }}</th>
                        <th class="text-nowrap">{{ trans('home.Chức năng') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @if($collections->count() === 0)
                    <tr>
                        <td colspan="6"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                    </tr>
                    @endif
                    @foreach($collections as $coupon)
                    <tr>
                        <td class="text-nowrap text-center">{{ $coupon->id }}</td>
                        <td class="text-nowrap text-center">{{ $coupon->key }}</td>
                        <td class="text-nowrap text-center">{{ $coupon->percent }}</td>
                        <td class="text-nowrap text-center">{{ $coupon->quantity }}</td>
                        <td class="text-nowrap text-center">{{ $coupon->quantitied }}</td>
                        <td class="text-nowrap">{{ $coupon->description }}</td>
                        <td class="text-nowrap text-center">
                            @if($coupon->status == 1)
                                <span class="alert alert-success">{{ trans('home.Đang hiệu lực') }}</span>
                            @elseif($coupon->status == 2)
                                <span class="alert alert-danger">{{ trans('home.Hết hạn') }}</span>
                            @else
                                <span class="alert alert-info">{{ trans('home.Chưa hoạt động') }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('coupons-edit',['id'=> $coupon->id]) }}" title="Chỉnh sửa"><i class="fas fa-pencil-alt"></i></a>

                            <a href="javascript:void(0)" data-id="{{ $coupon->id }}" class="btn-delete" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <form name="form-delete-{{ $coupon->id }}" method="post" action="{{ route('coupons-delete', ['id'=> $coupon->id]) }}">
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
