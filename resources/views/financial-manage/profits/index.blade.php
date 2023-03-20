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

    .table-bordered > thead > tr > th,
    .table-bordered > tbody > tr > td,
    .table-bordered > tfoot > tr > td{
        border: 2px solid #999999;
    }

    .table-bordered > thead:first-child > tr:first-child > th{
        border-top: 2px solid #999999;
    }

</style>

@include('financial-manage.profits.partials.search-form')

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header" style="text-align: center;">
                <h1 class="box-title">
                    {{ trans('home.BÁO CÁO LỢI NHUẬN') }}
                </h1>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%" rowspan="2">{{ trans('home.STT') }}</th>
                            <th rowspan="2" width="20%">{{ trans('home.Mục') }}</th>
                            <th style="text-align: center;" colspan="2">{{ trans('home.Thực tế') }}</th>
                            <th style="text-align: center;" colspan="2">{{ trans('home.Công nợ') }}</th>
                            <th style="text-align: center;" colspan="2">{{ trans('home.Tổng') }}</th>
                        </tr>

                        <tr>
                            <th>{{ trans('home.Không VAT') }}</th>
                            <th>{{ trans('home.VAT') }}</th>
                            <th>{{ trans('home.Không VAT') }}</th>
                            <th>{{ trans('home.VAT') }}</th>
                            <th>{{ trans('home.Không VAT') }}</th>
                            <th>{{ trans('home.VAT') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        <!-- Doanh thu -->
                        <tr>
                            <td style="font-size: 16px;"><b>1</b></td>
                            <td style="font-size: 16px;"><b>{{ trans('home.DOANH THU') }}</b></td>
                            <td style="text-align: center; font-size: 16px;"><b>{{ number_format($dt_netnotvat) }}</b></td>
                            <td style="text-align: center; font-size: 16px;"><b>{{ number_format($dt_netvat) }}</b></td>
                            <td style="text-align: center; font-size: 16px;"><b>{{ number_format($dt_receivablenotvat) }}</b></td>
                            <td style="text-align: center; font-size: 16px;"><b>{{ number_format($dt_receivablevat) }}</b></td>
                            <td style="text-align: center; font-size: 16px;"><b>{{ number_format($dt_revenue_notvat) }}</b></td>
                            <td style="text-align: center; font-size: 16px;"><b>{{ number_format($dt_revenue_vat) }}</b></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 20px;">1.1</td>
                            <td style="padding-left: 20px;">{{ trans('home.Sách') }}</td>
                            <td style="text-align: center;">{{ number_format($sach_netnotvat) }}</td>
                            <td style="text-align: center;">{{ number_format($sach_netvat) }}</td>
                            <td style="text-align: center;">{{ number_format($sach_conlainotvat) }}</td>
                            <td style="text-align: center;">{{ number_format($sach_conlaivat) }}</td>
                            <td style="text-align: center;">{{ number_format($sach_phaithunotvat) }}</td>
                            <td style="text-align: center;">{{ number_format($sach_phaithuvat) }}</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 20px;">1.2</td>
                            <td style="padding-left: 20px;">{{ trans('home.Dịch vụ sách') }}</td>
                            <td style="text-align: center;">{{ number_format($dvsach_netnotvat) }}</td>
                            <td style="text-align: center;">{{ number_format($dvsach_netvat) }}</td>
                            <td style="text-align: center;">{{ number_format($dvsach_conlainotvat) }}</td>
                            <td style="text-align: center;">{{ number_format($dvsach_conlaivat) }}</td>
                            <td style="text-align: center;">{{ number_format($dvsach_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($dvsach_vat) }}</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 20px;">1.3</td>
                            <td style="padding-left: 20px;">{{ trans('home.Dịch vụ in ấn') }}</td>
                            <td style="text-align: center;">{{ number_format($dvinan_netnotvat) }}</td>
                            <td style="text-align: center;">{{ number_format($dvinan_netvat) }}</td>
                            <td style="text-align: center;">{{ number_format($dvinan_conlainotvat) }}</td>
                            <td style="text-align: center;">{{ number_format($dvinan_conlaivat) }}</td>
                            <td style="text-align: center;">{{ number_format($dvinan_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($dvinan_vat) }}</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 20px;">1.4</td>
                            <td style="padding-left: 20px;">{{ trans('home.Dịch vụ khác') }}</td>
                            <td style="text-align: center;">{{ number_format($dvkhac_netnotvat) }}</td>
                            <td style="text-align: center;">{{ number_format($dvkhac_netvat) }}</td>
                            <td style="text-align: center;">{{ number_format($dvkhac_conlainotvat) }}</td>
                            <td style="text-align: center;">{{ number_format($dvkhac_conlaivat) }}</td>
                            <td style="text-align: center;">{{ number_format($dvkhac_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($dvkhac_vat) }}</td>
                        </tr>
                        <!-- End Doanh thu -->


                        <!-- Chi phí -->
                        <tr>
                            <td style="font-size: 16px;"><b>2</b></td>
                            <td style="font-size: 16px;"><b>{{ trans('home.CHI PHÍ') }}</b></td>
                            <td style="text-align: center; font-size: 16px;"><b>{{ number_format($cp_tong_tt_notvat) }}</b></td>
                            <td style="text-align: center; font-size: 16px;"><b>{{ number_format($cp_tong_tt_vat) }}</b></td>
                            <td style="text-align: center; font-size: 16px;"><b>{{ number_format($cp_tong_cn_notvat) }}</b></td>
                            <td style="text-align: center; font-size: 16px;"><b>{{ number_format($cp_tong_cn_vat) }}</b></td>
                            <td style="text-align: center; font-size: 16px;"><b>{{ number_format($cp_tong_notvat) }}</b></td>
                            <td style="text-align: center; font-size: 16px;"><b>{{ number_format($cp_tong_vat) }}</b></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 20px;">2.1</td>
                            <td style="padding-left: 20px;"><b>{{ trans('home.Giá vốn hàng bán') }}</b></td>
                            <td style="text-align: center;">{{ number_format($cp_gvhb_tt_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_gvhb_tt_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_gvhb_cn_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_gvhb_cn_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_gvhb_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_gvhb_vat) }}</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 40px;">2.1.1</td>
                            <td style="padding-left: 40px;">{{ trans('home.Sách') }}</td>
                            <td style="text-align: center;">{{ number_format($cp_gvsach_tt_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_gvsach_tt_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_gvsach_cn_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_gvsach_cn_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_gvsach_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_gvsach_vat) }}</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 40px;">2.1.2</td>
                            <td style="padding-left: 40px;">{{ trans('home.Dịch vụ sách') }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvsach_tt_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvsach_tt_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvsach_cn_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvsach_cn_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvsach_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvsach_vat) }}</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 40px;">2.1.3</td>
                            <td style="padding-left: 40px;">{{ trans('home.Dịch vụ in ấn') }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvinan_tt_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvinan_tt_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvinan_cn_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvinan_cn_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvinan_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvinan_vat) }}</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 40px;">2.1.4</td>
                            <td style="padding-left: 40px;">{{ trans('home.Dịch vụ khác') }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvkhac_tt_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvkhac_tt_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvkhac_cn_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvkhac_cn_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvkhac_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvkhac_vat) }}</td>
                        </tr>

                        <tr>
                            <td style="padding-left: 20px;">2.2</td>
                            <td style="padding-left: 20px;"><b>{{ trans('home.Quản lý bán hàng') }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_bh_tt_notvat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_bh_tt_vat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_bh_cn_notvat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_bh_cn_vat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_bh_notvat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_bh_vat) }}</b></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 40px;">2.2.1</td>
                            <td style="padding-left: 40px;">{{ trans('home.Chi phí Marketing') }}</td>
                            <td style="text-align: center;">{{ number_format($cp_marketing_tt_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_marketing_tt_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_marketing_cn_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_marketing_cn_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_marketing_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_marketing_vat) }}</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 40px;">2.2.2</td>
                            <td style="padding-left: 40px;">Chi phí dịch vụ thuê ngoài</td>
                            <td style="text-align: center;">{{ number_format($cp_km_tt_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_km_tt_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_km_cn_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_km_cn_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_km_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_km_vat) }}</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 40px;">2.2.3</td>
                            <td style="padding-left: 40px;">{{ trans('home.Chi phí chăm sóc khách hàng') }}</td>
                            <td style="text-align: center;">{{ number_format($cp_cskh_tt_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_cskh_tt_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_cskh_cn_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_cskh_cn_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_cskh_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_cskh_vat) }}</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 40px;">2.2.4</td>
                            <td style="padding-left: 40px;">{{ trans('home.Chi phí tiếp khách') }}</td>
                            <td style="text-align: center;">{{ number_format($cp_cskh_tt_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_cskh_tt_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_cskh_cn_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_cskh_cn_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_cskh_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_cskh_vat) }}</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 40px;">2.2.5</td>
                            <td style="padding-left: 40px;">Chi phí bán hàng khác</td>
                            <td style="text-align: center;">{{ number_format($cp_dvngoai_tt_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvngoai_tt_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvngoai_cn_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvngoai_cn_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvngoai_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvngoai_vat) }}</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 40px;">2.2.6</td>
                            <td style="padding-left: 40px;">{{ trans('home.Chi phí vận chuyển') }}</td>
                            <td style="text-align: center;">{{ number_format($cp_vc_tt_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_vc_tt_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_vc_cn_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_vc_cn_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_vc_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_vc_vat) }}</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 40px;">2.2.7</td>
                            <td style="padding-left: 40px;">{{ trans('home.KPI doanh số') }}</td>
                            <td style="text-align: center;">{{ number_format($cp_kpids_tt_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_kpids_tt_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_kpids_cn_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_kpids_cn_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_kpids_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_kpids_vat) }}</td>
                        </tr>

                        <tr>
                            <td style="padding-left: 40px;">2.2.8</td>
                            <td style="padding-left: 40px;">KPI đầu việc</td>
                            <td style="text-align: center;">{{ number_format($cp_kpidv_tt_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_kpidv_tt_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_kpidv_cn_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_kpidv_cn_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_kpidv_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_kpidv_vat) }}</td>
                        </tr>

                        <tr>
                            <td style="padding-left: 20px;">2.3</td>
                            <td style="padding-left: 20px;"><b>{{ trans('home.Quản lý doanh nghiệp') }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_dn_tt_notvat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_dn_tt_vat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_dn_cn_notvat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_dn_cn_vat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_dn_notvat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_dn_vat) }}</b></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 40px;">2.3.1</td>
                            <td style="padding-left: 40px;">{{ trans('home.Chi phí nhân sự') }}</td>
                            <td style="text-align: center;">{{ number_format($cp_ns_tt_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_ns_tt_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_ns_cn_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_ns_cn_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_ns_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_ns_vat) }}</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 40px;">2.3.2</td>
                            <td style="padding-left: 40px;">{{ trans('home.Chi phí thuê văn phòng') }}</td>
                            <td style="text-align: center;">{{ number_format($cp_thuevp_tt_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_thuevp_tt_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_thuevp_cn_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_thuevp_cn_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_thuevp_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_thuevp_vat) }}</td>
                        </tr>

                        <tr>
                            <td style="padding-left: 40px;">2.3.3</td>
                            <td style="padding-left: 40px;">{{ trans('home.Chi phí văn phòng phẩm') }}</td>
                            <td style="text-align: center;">{{ number_format($cp_vpp_tt_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_vpp_tt_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_vpp_cn_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_vpp_cn_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_vpp_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_vpp_vat) }}</td>
                        </tr>

                        <tr>
                            <td style="padding-left: 40px;">2.3.4</td>
                            <td style="padding-left: 40px;">Chi phí dịch vụ thuê ngoài</td>
                            <td style="text-align: center;">{{ number_format($cp_dvtn_tt_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvtn_tt_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvtn_cn_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvtn_cn_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvtn_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dvtn_vat) }}</td>
                        </tr>

                        <tr>
                            <td style="padding-left: 40px;">2.3.5</td>
                            <td style="padding-left: 40px;">Chi phí doanh nghiệp khác</td>
                            <td style="text-align: center;">{{ number_format($cp_dnk_tt_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dnk_tt_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dnk_cn_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dnk_cn_vat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dnk_notvat) }}</td>
                            <td style="text-align: center;">{{ number_format($cp_dnk_vat) }}</td>
                        </tr>

                        <tr>
                            <td style="padding-left: 20px;">2.4</td>
                            <td style="padding-left: 20px;"><b>{{ trans('home.Tài sản cố định') }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_tscd_tt_notvat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_tscd_tt_vat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_tscd_cn_notvat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_tscd_cn_vat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_tscd_notvat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_tscd_vat) }}</b></td>
                        </tr>

                        <tr>
                            <td style="padding-left: 20px;">2.5</td>
                            <td style="padding-left: 20px;"><b>{{ trans('home.Chi phí khác') }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_khac_tt_notvat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_khac_tt_vat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_khac_cn_notvat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_khac_cn_vat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_khac_notvat) }}</b></td>
                            <td style="text-align: center;"><b>{{ number_format($cp_khac_vat) }}</b></td>
                        </tr>
                        <!-- End Chi phí -->
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="2" style="text-align: right; padding-right: 50px;"><b>{{ trans('home.LỢI NHUẬN TỔNG') }}</b></td>
                            <td colspan="3"><b>{{ trans('home.Không VAT') }}: {{ number_format($dt_revenue_notvat - $cp_tong_notvat) }} VND</b> <span></span></td>
                            <td colspan="3"><b>{{ trans('home.VAT') }}: {{ number_format($dt_revenue_vat - $cp_tong_vat) }} VND</b> <span></span></td>
                        </tr>

                        <tr>
                            <td colspan="2" style="text-align: right; padding-right: 50px;"><b>{{ trans('home.LỢI NHUẬN THỰC TẾ') }}</b></td>
                            <td colspan="3"><b>{{ trans('home.Không VAT') }}: {{ number_format($dt_netnotvat - $cp_tong_tt_notvat) }} VND</b> <span></span></td>
                            <td colspan="3"><b>{{ trans('home.VAT') }}: {{ number_format($dt_netvat - $cp_tong_tt_vat) }} VND</b> <span></span></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function() {
        $('#reservation').daterangepicker();
    });
</script>
@endsection
