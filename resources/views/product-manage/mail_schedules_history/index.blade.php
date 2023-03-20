@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.mail_schedules_history.success')
@endif

@include('product-manage.mail_schedules_history.partials.search-form')
<div class="box box-table mail-productHistory">
    <div class="box-content">
        <div class="box-header">
            <h2 class="box-title">
                Danh sách gửi giới thiệu
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
                        <a href="#" class="btn btn-default"><i class="fas fa-download" aria-hidden="true"></i> {{ trans('home.Xuất tất cả') }}</a>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> {{ trans('home.Hiển thị') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('mail_schedules_history-index', filter_data($filter, 'limit', 10)) }}">10 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('mail_schedules_history-index', filter_data($filter, 'limit', 25)) }}">25 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('mail_schedules_history-index', filter_data($filter, 'limit', 50)) }}">50 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('mail_schedules_history-index', filter_data($filter, 'limit', 100)) }}">100 {{ trans('home.dòng / trang') }}</a></li>
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-sort" aria-hidden="true"></i> {{ trans('home.Sắp xếp') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('mail_schedules_history-index', filter_data($filter, 'orderBy', 'id')) }}">{{ trans('home.Họ tên khách hàng') }}</a></li>
                                <li><a href="{{ route('mail_schedules_history-index', filter_data($filter, 'orderBy', 'fullname')) }}">{{ trans('home.Email') }}</a></li>
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
                                <li><a href="{{ route('mail_schedules_history-index', filter_data($filter, 'sortedBy', 'desc')) }}"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}</a></li>
                                <li><a href="{{ route('mail_schedules_history-index', filter_data($filter, 'sortedBy', 'asc')) }}"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-nowrap" width="1%">STT</th>
                        <th class="text-nowrap text-left" width="10%">Họ tên khách hàng</th>
                        <th class="text-nowrap" width="5%">Số đơn hàng</th>
                        <th class="text-nowrap">Ngày đặt hàng</th>
                        <th class="text-nowrap text-left" width="15%">Sách đã mua</th>
                        <th class="text-nowrap text-left" width="15%">Sách giới thiệu kế tiếp</th>
                        <th class="text-nowrap">Ngày sẽ gửi mail</th>
                        <th class="text-nowrap">Trạng thái</th>
                        <th class="text-nowrap">{{ trans('home.Chức năng') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @if($collections->count() === 0)
                    <tr>
                        <td colspan="9"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                    </tr>
                    @endif

                    @php
                        $i = 1
                    @endphp
                    @foreach($collections as $mailschedule)
                    <tr>
                        <td class="text-center">{{ $i }}</td>
                        <td>{{ $mailschedule->customer()->first() == NULL ? "" : $mailschedule->customer()->first()->fullname }}</td>
                        <td class="text-center">{{ $mailschedule->order_number }}</td>
                        <td class="text-center">{{ date("d/m/Y", strtotime($mailschedule->order_date)) }}</td>
                        <td>{{ $mailschedule->product()->first() == NULL ? "" : $mailschedule->product()->first()->name }}</td>
                        <td>{{ $mailschedule->sendmailProduct()->first() == NULL ? "" : $mailschedule->sendmailProduct()->first()->name }}</td>
                        <td class="text-center">{{ date("d/m/Y", strtotime($mailschedule->sendmail_date)) }}</td>
                        <td class="text-center">
                            @if($mailschedule->status == 1)
                                <span class="alert alert-success"><b>{{ trans('home.Đã gửi') }}</b></span>
                            @else
                                <span class="alert alert-warning"><b>{{ trans('home.Chưa gửi') }}</b></span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('warehouses-edit', ['id' => $warehouse->id]) }}" title="Chỉnh sửa"><i class="fas fa-pencil-alt"></i></a>

                            <a href="javascript:void(0)" data-id="{{ $warehouse->id }}" class="btn-delete" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <form name="form-delete-{{ $warehouse->id }}" method="post" action="{{ route('warehouses-delete', ['id'=> $warehouse->id]) }}">
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
