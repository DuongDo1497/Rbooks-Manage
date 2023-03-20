@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Bảng lương</h3>
            </div>

            <div class="box-body">
                @include('user-employees.partials.aboutEmployees')
            </div>

            <div class="box-footer">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">STT</th>
                            <th width="10%">Mã NV</th>
                            <th>Mức lương</th>
                            <th>Ngạch/Bậc</th>
                            <th>Ngày hiệu lực</th>
                            <th width="20%">Ghi chú</th>
                            <th>Kích hoạt</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td style="text-align: center;">01</td>
                            <td style="text-align: center;">19070012</td>
                            <td style="text-align: center;">4472000</td>
                            <td style="text-align: center;">2</td>
                            <td style="text-align: center;">01/10/2019</td>
                            <td></td>
                            <td style="text-align: center;"><b class="alert-success">Đã kích hoạt</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function() {
        
    });
</script>
@endsection
