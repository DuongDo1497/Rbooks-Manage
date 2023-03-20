@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<style>

    .table > thead > tr > th[rowspan]{
        vertical-align: middle;
    }

    .table > thead > tr > th[colspan]{
        text-align: center;
        border-bottom: none;
    }

    .table > thead > tr > th{
        text-align: center;
    }

</style>

@include('financial-manage.cpt_fixedassets.cpcn.search_cpcn_taisancodinh')

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    {{ trans('home.Danh sách công nợ tài sản cố định') }}
                    <small>({{ trans('home.Hiển thị') }} {{ $filter['limit'] }} {{ trans('home.dòng / trang') }}) </small>
                </h3>
                <div class="box-tools">
                    <div class="btn-group btn-group-sm">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-download" aria-hidden="true"></i> {{ trans('home.Xuất danh sách') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#"><i class="fas fa-download" aria-hidden="true"></i> {{ trans('home.Xuất tất cả') }}</a></li>
                                <li><a href="#"><i class="fa fa-file-text" aria-hidden="true"></i> {{ trans('home.Xuất tùy chọn') }}</a></li>
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-filter" aria-hidden="true"></i> {{ trans('home.Lọc') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                @foreach($mclists as $mclist)
                                    <li><a href="https://rbooks.vn/public/rbooks-vn-management/public/cpt_tscd/list_cpcn_tscd/?searchValue={{$mclist->id}}&searchFields=itemcost_id">{{ $mclist->name }}</a></li>
                                @endforeach
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
                                <li><a href="{{ route('cpcn_tscd-index', filter_data($filter, 'limit', 10)) }}">10 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('cpcn_tscd-index', filter_data($filter, 'limit', 25)) }}">25 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('cpcn_tscd-index', filter_data($filter, 'limit', 50)) }}">50 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('cpcn_tscd-index', filter_data($filter, 'limit', 100)) }}">100 {{ trans('home.dòng / trang') }}</a></li>
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
                                <li><a href="{{ route('cpcn_tscd-index', filter_data($filter, 'sortedBy', 'asc')) }}"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}</a></li>
                                <li><a href="{{ route('cpcn_tscd-index', filter_data($filter, 'sortedBy', 'desc')) }}"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}</a></li>
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
                            <th width="1%" rowspan="2">
                                <label>
                                    <input type="checkbox" class="minimal checkbox-all">
                                </label>
                            </th>
                            <th width="2.5%" rowspan="2">{{ trans('home.STT') }}</th>
                            <th rowspan="2" width="15%">{{ trans('home.Mã công nợ') }}</th>
                            <th rowspan="2">{{ trans('home.Ngày bắt đầu') }}</th>
                            <th width="12%" rowspan="2">{{ trans('home.Nội dung chi') }}</th>
                            <th rowspan="2">{{ trans('home.Số lượng') }}</th>
                            <th style="text-align: center;" colspan="2" width="15%">{{ trans('home.Dư nợ') }}</th>
                            <th rowspan="2">{{ trans('home.Trạng thái') }}</th>
                            <th rowspan="2" width="6%">
                                <span class="lbl-action">{{ trans('home.Chức năng') }}</span>
                                <button class="btn btn-danger btn-xs btn-block hide btn-delete-selected">{{ trans('home.Xóa') }} <span class="lbl-selected-rows-count">0</span> {{ trans('home.đã chọn') }}</button>
                            </th>
                        </tr>

                        <tr>
                            <th>{{ trans('home.Không VAT') }}</th>
                            <th>{{ trans('home.VAT') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($list_cpcn_tscds->count() === 0)
                            <tr>
                                <td colspan="8"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                            </tr>
                        @endif
                        @php
                            $i = 1
                        @endphp
                        @foreach($list_cpcn_tscds as $list_cpcn_tscd)
                            <tr>
                                <td>
                                    <label>
                                        <input type="checkbox" class="minimal checkbox-item">
                                    </label>
                                </td>
                                <td style="text-align: center;">{{ $i }}</td>
                                <td style="text-align: center;">{{ $list_cpcn_tscd->code }}</td>
                                <td style="text-align: center;">{{ date("d/m/Y", strtotime($list_cpcn_tscd->startday_cost)) }}</td>
                                <td style="text-align: center;">{{ $list_cpcn_tscd->content }}</td>
                                <td style="text-align: center;">{{ $list_cpcn_tscd->quantity }}</td>
                                <td style="text-align: center;">{{ number_format($list_cpcn_tscd->remaining_cost_novat) }}</td>
                                <td style="text-align: center;">{{ number_format($list_cpcn_tscd->remaining_cost_vat) }}</td>
                                <td style="text-align: center;"><b class="alert-success">{{ $list_cpcn_tscd->method_cost == '2' ? 'Chuyển khoản' : 'Tiền mặt' }}</b></td>
                                <!-- <td style="text-align: center;">{{ $list_cpcn_tscd->note }}</td> -->
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{ trans('home.Thao tác') }} <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="{{ route('cpt_tscd-detail', ['id' => $list_cpcn_tscd->id]) }}"><i class="fa fa-info-circle" style="margin-right: 10px;"></i> {{ trans('home.Chi tiết') }}</a></li>
                                            <li><a href="{{ route('cpt_tscd-edit', ['id' => $list_cpcn_tscd->id]) }}"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> {{ trans('home.Chỉnh sửa') }}</a></li>
                                            <li><a href="javascript:void(0)" data-id="" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> {{ trans('home.Xóa') }}</a>
                                                <form style="margin: 0;" name="form-delete" method="post" action="">
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
                {{ $list_cpcn_tscds->links() }}
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

        $('#reservation').daterangepicker();
    });
</script>
@endsection
