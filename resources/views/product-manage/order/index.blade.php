@extends('layouts.master')
@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('product-manage.order.partials.search-form')

<div class="box box-table order">
    <div class="box-content">
        <div class="box-header">
            <h2 class="box-title">
                {{ trans('home.Danh sách đơn hàng') }}
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
                        <a href="{{ route('orders-add') }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</a>
                        <a href="{{ route('orders-all-excel') }}" class="btn btn-default"><i class="fas fa-download" aria-hidden="true"></i> {{ trans('home.Xuất tất cả') }}</a>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> {{ trans('home.Hiển thị') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('orders-index', filter_data($filter, 'limit', 10)) }}">10 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('orders-index', filter_data($filter, 'limit', 25)) }}">25 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('orders-index', filter_data($filter, 'limit', 50)) }}">50 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('orders-index', filter_data($filter, 'limit', 100)) }}">100 {{ trans('home.dòng / trang') }}</a></li>
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-sort" aria-hidden="true"></i> {{ trans('home.Sắp xếp') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('orders-index', filter_data($filter, 'orderBy', 'id')) }}">{{ trans('home.Mã đơn hàng') }}</a></li>
                                <li><a href="{{ route('orders-index', filter_data($filter, 'orderBy', 'name')) }}">{{ trans('home.Tên khách hàng') }}</a></li>
                                <li><a href="{{ route('orders-index', filter_data($filter, 'orderBy', 'status')) }}">{{ trans('home.Tình trạng') }}</a></li>
                                <li><a href="{{ route('orders-index', filter_data($filter, 'orderBy', 'created_at')) }}">{{ trans('home.Ngày nhận đơn') }}</a></li>
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
                                <li><a href="{{ route('orders-index', filter_data($filter, 'sortedBy', 'desc')) }}"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}</a></li>
                                <li><a href="{{ route('orders-index', filter_data($filter, 'sortedBy', 'asc')) }}"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-nowrap">STT</th>
                        <th class="text-left" width="10%">Họ tên KH</th>
                        <th class="text-nowrap" width="15%">{{ trans('home.Thông tin thanh toán') }}</th>
                        <th class="text-nowrap" width="15%">{{ trans('home.Địa chỉ thanh toán') }}</th>
                        <th class="text-nowrap" width="15%">{{ trans('home.Địa chỉ giao hàng') }}</th>
                        <th class="text-nowrap" >{{ trans('home.Tình trạng') }}</th>
                        <th class="text-nowrap" >{{ trans('home.Ngày nhận đơn') }}</th>
                        <th class="text-nowrap" >Nhân viên</th>
                        <th width="15%">{{ trans('home.Ghi chú') }}</th>
                        <th width="8%" class="text-nowrap">{{ trans('home.Chức năng') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @if($collections->count() === 0)
                    <tr>
                        <td colspan="10"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                    </tr>
                    @endif
                    @foreach($collections as $order)
                    <tr>
                        <td class="text-center">{{ $order->id }}</td>
                        <td style="word-break: break-all;"> 
                            {{ $order->billingaddress->fullname }}
                        </td>
                        <td class="text-nowrap">
                            <ul class="list-unstyled">
                                <li><b>{{ trans('home.Tổng tiền gồm VAT') }}:</b> {{ number_format($order->sub_total - $order->tax_total) }} VNĐ</li>
                                <li><b>{{ trans('home.Tiền chuyển hàng') }}:</b> {{ number_format($order->ship_total) }} VNĐ</li>
                                @if($order->gift_fee == 20000)
                                <li><b>{{ trans('home.Phí gói quà') }}:</b> {{ number_format($order->gift_fee) }} VNĐ</li>
                                @endif
                                <li><b>{{ trans('home.Tổng thành tiền') }}:</b> {{ number_format($order->total) }} VNĐ</li>
                            </ul>
                        </td>
                        <td>
                            <ul class="list-unstyled">
                                <li><b>{{ trans('home.Tên người thanh toán') }}: </b>{{ $order->billingaddress->fullname }}</li>
                                <li><b>{{ trans('home.Địa chỉ') }}: </b>{{ $order->billingaddress->address }} - {{ $order->billingaddress->district }} - {{ $order->billingaddress->city }}</li>
                            </ul>
                        </td>
                        <td>
                            @if($order->gift_address_id != 0)
                            <ul class="list-unstyled">
                                <li><b>{{ trans('home.Tên người nhận') }}: </b>{{ $order->gift->recipientName }}</li>
                                <li><b>{{ trans('home.Địa chỉ') }}: </b>{{ $order->gift->address }}</li>
                            </ul>
                            @else
                            <ul class="list-unstyled">
                                <li><b>{{ trans('home.Tên người nhận hàng') }}: </b>{{ $order->deliveryaddress->fullname }}</li>
                                <li><b>{{ trans('home.Địa chỉ') }}: </b>{{ $order->deliveryaddress->address }} - {{ $order->deliveryaddress->district }} - {{ $order->deliveryaddress->city }}</li>
                            </ul>
                            @endif
                        </td>
                        <td class="text-nowrap text-center">
                            @if($order->status == 1)
                                <span style="color: #383d41; background-color: #e4e6e7; padding: 5px 10px; font-weight: bold; border-radius: 3px;">{{ trans('home.Đang chỉnh sửa') }}</span>
                            @elseif($order->status == 2)
                                <span style="color: #004085; background-color: #cce5ff; padding: 5px 10px; font-weight: bold; border-radius: 3px;">{{ trans('home.Đang vận chuyển') }}</span>
                            @elseif($order->status == 3)
                                <span style="color: #999900; background-color: #ffffcc; padding: 5px 10px; font-weight: bold; border-radius: 3px;">{{ trans('home.Hoàn thành') }}</span>
                            @elseif($order->status == 4)
                                <span style="color: #856404; background-color: #fdf1ce; padding: 5px 10px; font-weight: bold; border-radius: 3px;">{{ trans('home.Hủy đơn hàng') }}</span>
                            @elseif($order->status == 5)
                                <span style="color: #24248f; background-color: #d6d6f5; padding: 5px 10px; font-weight: bold; border-radius: 3px;">{{ trans('home.Đã xuất kho') }}</span>
                            @elseif($order->status == 6)
                                <span style="color: #e6800; background-color: #ffe8cc; padding: 5px 10px; font-weight: bold; border-radius: 3px;">{{ trans('home.Giao hàng thành công') }}</span>
                            @elseif($order->status == 7)
                                <span style="color: #800080; background-color: #ffccff; padding: 5px 10px; font-weight: bold; border-radius: 3px;">{{ trans('home.Đã thanh toán') }}</span>
                            @elseif($order->status == 8)
                                <span style="color: #ff6680; background-color: #ffccd5; padding: 5px 10px; font-weight: bold; border-radius: 3px;">{{ trans('home.Chờ duyệt') }}</span>
                            @elseif($order->status == 9)
                                <span style="color: #008000; background-color: #ccffcc; padding: 5px 10px; font-weight: bold; border-radius: 3px;">{{ trans('home.Đã duyệt') }}</span>
                            @elseif($order->status == 10)
                                <span style="color: #ff0000; background-color: #ffcccc; padding: 5px 10px; font-weight: bold; border-radius: 3px;">{{ trans('home.Không duyệt') }}</span>
                            @else
                                <span style="color: #721c24; background-color: #f5d6d9; padding: 5px 10px; font-weight: bold; border-radius: 3px;">{{ trans('home.Hủy') }}</span>
                            @endif
                        </td>
                        <td class="text-nowrap text-center">{{ date("d/m/Y", strtotime($order->created_at)) }}</td>
                        <td class="text-nowrap text-center"><b>{{ $order->users == null ? "" : $order->users->name }}</b></td>
                        @if($order->gift_fee == 0 && $order->gift_address_id != 0 && $order->note != NULL)
                            <td class="text-nowrap">{{ trans('home.Đơn hàng làm Quà tặng (Không gói quà)!') }} / {{$order->note}}</td>
                        @elseif($order->gift_fee == 0 && $order->gift_address_id != 0)
                            <td class="text-nowrap">{{ trans('home.Đơn hàng làm Quà tặng (Không gói quà)!') }}</td>
                        @elseif($order->gift_fee == 20000 && $order->gift_address_id != 0 && $order->note != NULL)
                            <td class="text-nowrap">{{ trans('home.Đơn hàng làm Quà tặng (Có gói quà)!') }} / {{ $order->note }}</td>
                        @elseif($order->gift_fee == 20000 && $order->gift_address_id != 0 && $order->note == NULL)
                            <td class="text-nowrap">{{ trans('home.Đơn hàng làm Quà tặng (Có gói quà)!') }} </td>
                        @else
                            <td>{{ $order->note }}</td>
                        @endif
                        <td class="text-center">
                            <a href="{{ route('orders-edit', ['id' => $order->id]) }}" title="Chỉnh sửa"><i class="fas fa-pencil-alt"></i></a>

                            @if($order->status != 4)
                            <a href="{{ route('orders-invoice', ['id' => $order->id]) }}" title="In hóa đơn"><i class="fa fa-print"></i></a>
                            <a href="{{ route('orders-export', ['id' => $order->id]) }}" title="In đơn hàng"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                            @endif

                            <a href="{{ route('orders-excel', ['id' => $order->id]) }}" title="Xuất đơn hàng"><i class="fa fa-download" aria-hidden="true"></i></a>

                            @if(Auth()->user()->roles()->get()->first()->name == "owner")
                            <a href="javascript:void(0)" data-id="{{ $order->id }}" class="btn-delete" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <form name="form-delete-{{ $order->id }}" method="post" action="{{ route('orders-delete', ['id'=> $order->id]) }}">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                            </form>
                            @endif
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
@include('product-manage.order.partials.script')
@endsection
