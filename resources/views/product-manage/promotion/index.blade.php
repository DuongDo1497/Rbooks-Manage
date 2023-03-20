@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('product-manage.promotion.partials.search-form')
<div class="box box-table promotion">
    <div class="box-content">
        <div class="box-header">
            <h2 class="box-title">
                {{ trans('home.Danh sách tặng sách Ebooks') }}
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
                        <a href="#" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</a>
                        <a href="#" class="btn btn-default"><i class="fas fa-download" aria-hidden="true"></i> {{ trans('home.Xuất tất cả') }}</a>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> {{ trans('home.Hiển thị') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('promotions-index', filter_data($filter, 'limit', 10)) }}">10 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('promotions-index', filter_data($filter, 'limit', 25)) }}">25 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('promotions-index', filter_data($filter, 'limit', 50)) }}">50 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('promotions-index', filter_data($filter, 'limit', 100)) }}">100 {{ trans('home.dòng / trang') }}</a></li>
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-sort" aria-hidden="true"></i> {{ trans('home.Sắp xếp') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('promotions-index', filter_data($filter, 'orderBy', 'fullname')) }}">{{ trans('home.Tên khách hàng') }}</a></li>
                                <li><a href="{{ route('promotions-index', filter_data($filter, 'orderBy', 'email')) }}">{{ trans('home.Email') }}</a></li>
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
                                <li><a href="{{ route('promotions-index', filter_data($filter, 'sortedBy', 'desc')) }}"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}</a></li>
                                <li><a href="{{ route('promotions-index', filter_data($filter, 'sortedBy', 'asc')) }}"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-nowrap" width="1%">STT</th>
                        <th class="text-nowrap text-left" width="15%">{{ trans('home.Tên khách hàng') }}</th>
                        <th class="text-nowrap">{{ trans('home.Email') }}</th>
                        <th class="text-nowrap">{{ trans('home.Số điện thoại') }}</th>
                        <th class="text-nowrap text-left" width="20%">{{ trans('home.Địa chỉ') }}</th>
                        <th class="text-nowrap">{{ trans('home.Thời gian đăng kí') }}</th>
                        <th class="text-nowrap">{{ trans('home.Chức năng') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @if($collections->count() === 0)
                    <tr>
                        <td colspan="7"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                    </tr>
                    @endif

                    @php
                        $i = 1
                    @endphp
                    @foreach($collections as $promo)
                    <tr>
                        <td class="text-center">{{ $i }}</td>
                        <td class="text-nowrap">{{ $promo->name }}</td>
                        <td class="text-nowrap text-center">{{ $promo->email }}</td>
                        <td class="text-center">{{ $promo->phone }}</td>
                        <td>{{ $promo->address }}</td>
                        <td class="text-center">{{ date("d/m/Y - H:i:s", strtotime($promo->created_at)) }}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" data-id="{{ $promo->id }}" class="btn-delete" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <form name="form-delete-{{ $promo->id }}" method="post" action="{{ route('promotions-delete', ['id'=> $promo->id]) }}">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                            </form>
                        </td>
                    </tr>
                    @php
                        $i++
                    @endphp
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
