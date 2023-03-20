@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<style>
    .box-search:last-child .box-body{
        margin-bottom: 0;
    }
</style>



@include('financial-manage.gross_revenue.partials.search-form')
<div class="box box-table gross-revenue">
    <div class="box-content">
        <div class="box-header">
            <h2 class="box-title">
                {{ trans('home.Danh sách doanh thu tổng') }}
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
                        <a href="{{ route('gross_revenues-add') }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</a>
                        <a href="#" class="btn btn-default"><i class="fas fa-download" aria-hidden="true"></i> {{ trans('home.Xuất tất cả') }}</a>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> {{ trans('home.Lọc') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                @foreach($mclists as $mclist)
                                    <li><a href="https://rbooks.vn/public/rbooks-vn-management/public/gross_revenues?searchValue={{$mclist->id}}&searchFields=itemcost_id">{{ $mclist->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> {{ trans('home.Hiển thị') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('gross_revenues-index', filter_data($filter, 'limit', 10)) }}">10 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('gross_revenues-index', filter_data($filter, 'limit', 25)) }}">25 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('gross_revenues-index', filter_data($filter, 'limit', 50)) }}">50 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('gross_revenues-index', filter_data($filter, 'limit', 100)) }}">100 {{ trans('home.dòng / trang') }}</a></li>
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
                                <li><a href="{{ route('gross_revenues-index', filter_data($filter, 'sortedBy', 'desc')) }}"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}</a></li>
                                <li><a href="{{ route('gross_revenues-index', filter_data($filter, 'sortedBy', 'asc')) }}"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-nowrap" rowspan="2" width="1%">STT</th>
                        <th rowspan="2">{{ trans('home.Nguồn thu') }}</th>
                        <th rowspan="2">{{ trans('home.Ngày thu') }}</th>
                        <th rowspan="2">{{ trans('home.Khách hàng') }}</th>
                        <th width="12%" rowspan="2">{{ trans('home.Thanh toán') }}</th>
                        <th class="text-left" width="15%" rowspan="2">{{ trans('home.Mã chứng từ') }}</th>
                        <th width="8%" rowspan="2">{{ trans('home.Tổng số lượng') }}</th>
                        <th style="text-align: center;" colspan="3">{{ trans('home.Tổng tiền') }}</th>
                        <th rowspan="2">{{ trans('home.Trạng thái') }}</th>
                        <th class="text-nowrap" rowspan="2">{{ trans('home.Chức năng') }}</th>
                    </tr>

                    <tr>
                        <th>{{ trans('home.Tổng tiền') }}</th>
                        <th>{{ trans('home.Đã thu') }}</th>
                        <th>{{ trans('home.Chưa thu') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @if($collections->count() === 0)
                    <tr>
                        <td colspan="10"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                    </tr>
                    @endif

                    @php
                        $i = 1
                    @endphp
                    @foreach($collections as $gross_revenue)
                    <tr>
                        <td class="text-center">{{ $i }}</td>
                        <td class="text-center">{{ $gross_revenue->mclist()->first() == NULL ? "" : $gross_revenue->mclist()->first()->name }}</td>
                        <td class="text-center">{{ date("d/m/Y", strtotime($gross_revenue->start_date)) }}</td>
                        <td class="text-center">{{ $gross_revenue->name_customer }}</td>
                        <td class="text-center">{{ $gross_revenue->method_revenue }}</td>
                        <td>{{ $gross_revenue->code_license }}</td>
                        <td class="text-center">{{ $gross_revenue->quantity }}</td>
                        <td class="text-center">{{ number_format($gross_revenue->vat_revenue) }}</td>
                        <td class="text-center">{{ number_format($gross_revenue->dathu_vat) }}</td>
                        <td class="text-center">{{ number_format($gross_revenue->conlai_vat) }}</td>
                        <td class="text-center">
                            @if ($gross_revenue->status == '1')
                                <span class="alert alert-success">{{ trans('home.Đã thu') }}</span>
                            @elseif($gross_revenue->status == '2')
                                <span class="alert alert-danger">{{ trans('home.Chưa thu') }}</span>
                            @else
                                <span class="alert alert-warning">{{ trans('home.Thu từng phần') }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('gross_revenues-detail', ['id' => $gross_revenue->id]) }}" title="Xem chi tiết"><i class="fa fa-eye" aria-hidden="true"></i></a>

                            <a href="{{ route('gross_revenues-edit', ['id' => $gross_revenue->id]) }}" title="Chỉnh sửa"><i class="fas fa-pencil-alt"></i></a>

                            <a href="javascript:void(0)" data-id="{{ $gross_revenue->id }}" class="btn-delete" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <form name="form-delete-{{ $gross_revenue->id }}" method="post" action="{{ route('gross_revenues-delete', ['id'=> $gross_revenue->id]) }}">
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

        $('#reservation').daterangepicker();
    });
</script>
@endsection
