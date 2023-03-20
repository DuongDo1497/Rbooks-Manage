@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('content')
<div class="dashboard">
    <div class="row is-flex">
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div class="panel panel-default white">
                <div class="panel-heading">
                    <div class="title"><font size="3" color="#283b91"><b>Hiệu quả hoạt động</b></font> <small>(30 ngày qua)</small></div>
                    <div class="see-all"><a href="#">Xem chi tiết</a></div>
                </div>
                <div class="panel-body">
                    <div id="chart"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="panel panel-default white">
                <div class="panel-heading">
                    <div class="title"><font size="3" color="#283b91"><b>Thống kê tồn kho</b></font></div>
                    <div class="see-all"><a href="#">Xem chi tiết</a></div>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th width="60%">Số sản phẩm:</th>
                                <td width="40%">{{ $total_products }}</td>
                            </tr>

                            <tr>
                                <th width="60%">Tổng số lượng tồn kho thực tế:</th>
                                <td width="40%">{{ number_format($total_instock) }}</td>
                            </tr>

                            <tr>
                                <th width="60%">Doanh thu dự kiến:</th>
                                <td width="40%">{{ number_format($total_actual_inventory_value) }} đ</td>
                            </tr>

                            <tr>
                                <th width="60%">Tổng giá trị hàng tồn:</th>
                                <td width="40%">{{ number_format($total_inventory_value) }} đ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row is-flex">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="panel panel-default white">
                <div class="panel-heading">
                    <div class="title"><font size="3" color="#283b91"><b>Duyệt bán hàng</b></font></div>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th width="50%">Nhập hàng:</th>
                                <td width="10%">{{ number_format($pending_imports) }}</td>
                                <td width="40%">
                                    <a class="btn {{ $pending_imports > 0 ? 'btn-warning' : 'btn-success' }}" href="{{ route('warehouses-imports-index') }}">
                                        {{ $pending_imports > 0 ? 'Chờ duyệt' : 'Tốt' }}
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <th width="50%">Chuyển kho:</th>
                                <td width="10%">{{ number_format($pending_tranfers) }}</td>
                                <td width="40%">
                                    <a class="btn {{ $pending_tranfers > 0 ? 'btn-warning' : 'btn-success' }}" href="{{ route('warehouses-transfers-index') }}">
                                        {{ $pending_tranfers > 0 ? 'Chờ duyệt' : 'Tốt' }}
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <th width="50%">Đơn hàng:</th>
                                <td width="10%">{{ number_format($pending_orders) }}</td>
                                <td width="40%">
                                    <a class="btn {{ $pending_orders > 0 ? 'btn-warning' : 'btn-success' }}" href="{{ route('orders-index') }}">
                                        {{ $pending_orders > 0 ? 'Chờ duyệt' : 'Tốt' }}
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="panel panel-default white">
                <div class="panel-heading">
                    <div class="title"><font size="3" color="#283b91"><b>Duyệt hệ thống</b></font></div>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th width="50%">Doanh thu:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>

                            <tr>
                                <th width="50%">Chi phí:</th>
                                <td width="10%">0</td>
                                <td width="40%"><a class="btn btn-success" href="#">Tốt</a></td>
                            </tr>

                            <tr>
                                <th width="50%">Phép:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>

                            <tr>
                                <th width="50%">Bảng công lương:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>

                            <tr>
                                <th width="50%">KPI:</th>
                                <td width="10%">0</td>
                                <td width="40%"><a class="btn btn-success" href="#">Tốt</a></td>
                            </tr>

                            <tr>
                                <th width="50%">Tài sản:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row is-flex">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default white">
                <div class="panel-heading">
                    <div class="title"><font size="3" color="#283b91"><b>Duyệt Task việc</b></font></div>
                </div>
                <div class="panel-body">
                    <table class="table" width="100%">
                        <tbody>
                            <tr>
                                <th width="15%">Ban giám đốc:</th>
                                <td>10</td>
                                <td width="10%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                                <th width="15%">Sales:</th>
                                <td>10</td>
                                <td width="10%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                                <th width="15%">Kế toán:</th>
                                <td>10</td>
                                <td width="10%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>

                            <tr>
                                <th width="15%">Biên dịch:</th>
                                <td>10</td>
                                <td width="10%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                                <th width="15%">Bản quyền:</th>
                                <td>10</td>
                                <td width="10%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                                <th width="15%">Writing:</th>
                                <td>10</td>
                                <td width="10%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>

                            <tr>
                                <th width="15%">Design:</th>
                                <td>10</td>
                                <td width="10%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                                <th width="15%">Dàn trang:</th>
                                <td>10</td>
                                <td width="10%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                                <th width="15%">Content:</th>
                                <td>10</td>
                                <td width="10%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>

                            <tr>
                                <th width="15%">Marketing:</th>
                                <td>10</td>
                                <td width="10%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                                <th width="15%">In ấn:</th>
                                <td>10</td>
                                <td width="10%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                                <th width="15%">Data:</th>
                                <td>10</td>
                                <td width="10%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>

                            <tr>
                                <th width="15%">Ngôn ngữ:</th>
                                <td>10</td>
                                <td width="10%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                                <th width="15%">Vận hành:</th>
                                <td>10</td>
                                <td width="10%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                                <th width="15%">Nhân sự:</th>
                                <td>10</td>
                                <td width="10%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>

                            <tr>
                                <th width="15%">IT:</th>
                                <td>10</td>
                                <td width="10%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                                <th width="15%">Kho:</th>
                                <td>10</td>
                                <td width="10%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                                <th width="15%">Phối hợp:</th>
                                <td>10</td>
                                <td width="10%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table" width="100%">
                        <tbody>
                            <tr>
                                <th width="50%">Ban giám đốc:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>

                            <tr>
                                <th width="50%">Biên dịch:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>

                            <tr>
                                <th width="50%">Design:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>

                            <tr>
                                <th width="50%">Marketing:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>

                            <tr>
                                <th width="50%">Ngôn ngữ:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>

                            <tr>
                                <th width="50%">IT:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>
                        </tbody>

                        <tbody>
                            <tr>
                                <th width="50%">Sales:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>
                            <tr>
                                <th width="50%">Bản quyền:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>
                            <tr>
                                <th width="50%">Dàn trang:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>
                            <tr>
                                <th width="50%">In ấn:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>
                            <tr>
                                <th width="50%">Vận hành:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>
                            <tr>
                                <th width="50%">Kho:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>
                        </tbody>

                        <tbody>
                            <tr>
                                <th width="50%">Kế toán:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>
                            <tr>
                                <th width="50%">Writing:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>
                            <tr>
                                <th width="50%">Content:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>
                            <tr>
                                <th width="50%">Data:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>
                            <tr>
                                <th width="50%">Nhân sự:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>
                            <tr>
                                <th width="50%">Phối hợp:</th>
                                <td width="10%">10</td>
                                <td width="40%"><a class="btn btn-warning" href="#">Chờ duyệt</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('bower_components/c3.js/js/c3.min.js') }}"></script>
<script src="{{ asset('bower_components/c3.js/js/d3-5.8.2.min.js') }}"></script>

@include('dashboard.partials.script')
@endsection
