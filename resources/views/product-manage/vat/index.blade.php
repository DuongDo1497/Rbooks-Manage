@extends('layouts.master')
@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('product-manage.vat.partials.search-form')
<div class="box box-table vat">
    <div class="box-content">
        <div class="box-header">
            <h2 class="box-title">
            {{ trans('home.Danh sách hóa đơn VAT') }}
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
                                <li><a href="#">10 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="#">25 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="#">50 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="#">100 {{ trans('home.dòng / trang') }}</a></li>
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-sort" aria-hidden="true"></i> {{ trans('home.Sắp xếp') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#">{{ trans('home.Mã đơn hàng') }}</a></li>
                                <li><a href="#">{{ trans('home.Tên khách hàng') }}</a></li>
                                <li><a href="#">{{ trans('home.Tình trạng') }}</a></li>
                                <li><a href="#">{{ trans('home.Ngày nhận đơn') }}</a></li>
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
                                <li><a href="#"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}</a></li>
                                <li><a href="#"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-nowrap">STT</th>
                        <th class="text-nowrap" width="7%">{{ trans('home.Mã đơn hàng') }}</th>
                        <th class="text-nowrap" >{{ trans('home.Tên công ty') }}</th>
                        <th class="text-nowrap" >{{ trans('home.Mã số thuế') }}</th>
                        <th class="text-nowrap text-left" width="30%">{{ trans('home.Địa chỉ') }}</th>
                        <th class="text-nowrap">{{ trans('home.Ngày nhận đơn') }}</th>
                        <th class="text-nowrap">{{ trans('home.Chức năng') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @if($collections->count() === 0)
                    <tr>
                        <td colspan="7"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                    </tr>
                    @endif
                    @foreach($collections as $vat)
                    <tr>
                        <td class="text-center"> {{ $vat->id }} </td>
                        <td class="text-nowrap text-center">
                            {{ $vat->order_id }}
                        </td>
                        <td class="text-nowrap text-center">
                            <ul class="list-unstyled">
                                <li>{{ $vat->name_company }}</li>
                            </ul>
                        </td>
                        <td class="text-nowrap text-center">
                            <ul class="list-unstyled">
                                <li>{{ $vat->code_vat }}</li>
                            </ul>
                        </td>
                        <td class="text-nowrap">
                            <ul class="list-unstyled">
                                <li>{{ $vat->address_company }}</li>
                            </ul>
                        </td>
                        <td class="text-nowrap text-center">
                            <ul class="list-unstyled">
                                <li>{{ $vat->created_at }}</li>
                            </ul>
                        </td>
                        <td class="text-center">
                            <a href="#" data-id="#" class="btn btn-default btn-delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <form name="" method="post" action="#">
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

<!-- @section('scripts')
@include('product-manage.order.partials.script')
@endsection -->
