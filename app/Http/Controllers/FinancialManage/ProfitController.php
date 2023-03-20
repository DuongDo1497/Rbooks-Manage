<?php

namespace App\Http\Controllers\FinancialManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\GrossRevenueService;
use RBooks\Repositories\CtcpListRepository;

class ProfitController extends Controller
{
    public function __construct()
    {
        parent::__construct(null);

        $this->setViewPrefix('financial-manage.profits.');
        $this->setRoutePrefix('profit-');
        //$this->view->suppliers = app(SupplierService::class)->getAll();
        //$this->view->imports = app(ImportService::class)->getAll();

        $this->view->setHeading('home.Quản lý lợi nhuận');
    }

    public function index(Request $request)
    {
        //Start Doanh thu
        //doanh thu tổng
        $dt_revenue_notvat = app(GrossRevenueController::class)->index($request)->revenue_notvat; // Tổng doanh thu k VAT
        $dt_revenue_vat = app(GrossRevenueController::class)->index($request)->revenue_vat; // Tổng doanh thu k VAT
        $dt_netnotvat = app(GrossRevenueController::class)->net($request)->paided_cost_novat; // doanh thu thực tế k VAT
        $dt_netvat = app(GrossRevenueController::class)->net($request)->paided_cost_vat; // doanh thu thực tế k VAT
        $dt_receivablenotvat = app(GrossRevenueController::class)->receivable($request)->remaining_cost_novat; // công nợ phải thu k VAT
        $dt_receivablevat = app(GrossRevenueController::class)->receivable($request)->remaining_cost_vat; // công nợ phải thu VAT

        $this->view->dt_revenue_notvat = $dt_revenue_notvat;
        $this->view->dt_revenue_vat = $dt_revenue_vat;
        $this->view->dt_netnotvat = $dt_netnotvat;
        $this->view->dt_netvat = $dt_netvat;
        $this->view->dt_receivablenotvat = $dt_receivablenotvat;
        $this->view->dt_receivablevat = $dt_receivablevat;
        //End tính doanh thu tổng

        // doanh thu sách
        $sach_netnotvat = 0;
        $sach_netvat = 0;
        $sachs = app(GrossRevenueService::class)->sach_revenue();
        foreach($sachs->where('dathu_notvat', '!=', 0) as $sach) {
            $sach_netnotvat += $sach->dathu_notvat;
            $sach_netvat += $sach->dathu_vat;
        }
        $this->view->sach_netnotvat = $sach_netnotvat;
        $this->view->sach_netvat = $sach_netvat;

        $sach_conlaivat = 0;
        $sach_conlainotvat = 0;
        foreach($sachs->where('conlai_notvat', '!=', 0) as $sach) {
            $sach_conlainotvat += $sach->conlai_notvat;
            $sach_conlaivat += $sach->conlai_vat;
        }
        $this->view->sach_conlainotvat = $sach_conlainotvat;
        $this->view->sach_conlaivat = $sach_conlaivat;

        $sach_phaithunotvat = 0;
        $sach_phaithuvat = 0;
        foreach($sachs as $sach) {
            $sach_phaithunotvat += $sach->notvat_revenue;
            $sach_phaithuvat += $sach->vat_revenue;
        }
        $this->view->sach_phaithunotvat = $sach_phaithunotvat;
        $this->view->sach_phaithuvat = $sach_phaithuvat;
        // end dt sách
        // dịch vụ làm sách
        $dvsach_netnotvat = 0;
        $dvsach_netvat = 0;
        $dvsachs = app(GrossRevenueService::class)->dichvu_sach();
        foreach($dvsachs->where('dathu_notvat', '!=', 0) as $sach) {
            $dvsach_netnotvat += $sach->dathu_notvat;
            $dvsach_netvat += $sach->dathu_vat;
        }
        $this->view->dvsach_netnotvat = $dvsach_netnotvat;
        $this->view->dvsach_netvat = $dvsach_netvat;

        $dvsach_conlainotvat = 0;
        $dvsach_conlaivat = 0;
        foreach($dvsachs->where('conlai_notvat', '!=', 0) as $sach) {
            $dvsach_conlainotvat += $sach->conlai_notvat;
            $dvsach_conlaivat += $sach->conlai_vat;
        }
        $this->view->dvsach_conlainotvat = $dvsach_conlainotvat;
        $this->view->dvsach_conlaivat = $dvsach_conlaivat;

        $dvsach_notvat = 0;
        $dvsach_vat = 0;
        foreach($dvsachs as $sach) {
            $dvsach_notvat += $sach->notvat_revenue;
            $dvsach_vat += $sach->vat_revenue;
        }
        $this->view->dvsach_notvat = $dvsach_notvat;
        $this->view->dvsach_vat = $dvsach_vat;
        // end dịch vụ làm sách
        // Dịch vụ in ấn
        $dvinan_netnotvat = 0;
        $dvinan_netvat = 0;
        $dvinans = app(GrossRevenueService::class)->dichvu_inan();
        foreach($dvinans->where('dathu_notvat', '!=', 0) as $sach) {
            $dvinan_netnotvat += $sach->dathu_notvat;
            $dvinan_netvat += $sach->dathu_vat;
        }
        $this->view->dvinan_netnotvat = $dvinan_netnotvat;
        $this->view->dvinan_netvat = $dvinan_netvat;

        $dvinan_conlainotvat = 0;
        $dvinan_conlaivat = 0;
        foreach($dvinans->where('conlai_notvat', '!=', 0) as $sach) {
            $dvinan_conlainotvat += $sach->conlai_notvat;
            $dvinan_conlaivat += $sach->conlai_vat;
        }
        $this->view->dvinan_conlainotvat = $dvinan_conlainotvat;
        $this->view->dvinan_conlaivat = $dvinan_conlaivat;

        $dvinan_notvat = 0;
        $dvinan_vat = 0;
        foreach($dvinans as $sach) {
            $dvinan_notvat += $sach->notvat_revenue;
            $dvinan_vat += $sach->vat_revenue;
        }
        $this->view->dvinan_notvat = $dvinan_notvat;
        $this->view->dvinan_vat = $dvinan_vat;
        // End dv in ấn
        // Dịch vụ khác
        $dvkhac_netnotvat = 0;
        $dvkhac_netvat = 0;
        $dvkhacs = app(GrossRevenueService::class)->dichvu_khac();
        foreach($dvkhacs->where('dathu_notvat', '!=', 0) as $sach) {
            $dvkhac_netnotvat += $sach->dathu_notvat;
            $dvkhac_netvat += $sach->dathu_vat;
        }
        $this->view->dvkhac_netnotvat = $dvkhac_netnotvat;
        $this->view->dvkhac_netvat = $dvkhac_netvat;

        $dvkhac_conlainotvat = 0;
        $dvkhac_conlaivat = 0;
        foreach($dvkhacs->where('conlai_notvat', '!=', 0) as $sach) {
            $dvkhac_conlainotvat += $sach->conlai_notvat;
            $dvkhac_conlaivat += $sach->conlai_vat;
        }
        $this->view->dvkhac_conlainotvat = $dvkhac_conlainotvat;
        $this->view->dvkhac_conlaivat = $dvkhac_conlaivat;

        $dvkhac_notvat = 0;
        $dvkhac_vat = 0;
        foreach($dvkhacs as $sach) {
            $dvkhac_notvat += $sach->notvat_revenue;
            $dvkhac_vat += $sach->vat_revenue;
        }
        $this->view->dvkhac_notvat = $dvkhac_notvat;
        $this->view->dvkhac_vat = $dvkhac_vat;
        // End dv khác
        //End Doanh thu

        // Chi Phí

        // START CHI PHÍ

        //Chi phí tổng
            $cp_tongs = app(CtcpListRepository::class)->get();

            $cp_tong_notvat = 0;
            $cp_tong_vat = 0;
            $cp_tong_tt_notvat = 0;
            $cp_tong_tt_vat = 0;
            $cp_tong_cn_notvat = 0;
            $cp_tong_cn_vat = 0;

            foreach($cp_tongs as $cp_tong) {
                $cp_tong_notvat += $cp_tong->novat_cost;
                $cp_tong_vat += $cp_tong->vat_cost;
                $cp_tong_tt_notvat += $cp_tong->paided_cost_novat;
                $cp_tong_tt_vat += $cp_tong->paided_cost_vat;
                $cp_tong_cn_notvat += $cp_tong->remaining_cost_novat;
                $cp_tong_cn_vat += $cp_tong->remaining_cost_vat;
            }
            $this->view->cp_tong_notvat = $cp_tong_notvat;
            $this->view->cp_tong_vat = $cp_tong_vat;
            $this->view->cp_tong_tt_notvat = $cp_tong_tt_notvat;
            $this->view->cp_tong_tt_vat = $cp_tong_tt_vat;
            $this->view->cp_tong_cn_notvat = $cp_tong_cn_notvat;
            $this->view->cp_tong_cn_vat = $cp_tong_cn_vat;
        // End chi phí tổng
        // Chi phí giá vốn hàng bán
            $cp_gvhb_tt_notvat = app(CptCostPriceController::class)->list_cptt_gvhb($request)->paided_cost_novat;
            $cp_gvhb_tt_vat = app(CptCostPriceController::class)->list_cptt_gvhb($request)->paided_cost_vat;
            $cp_gvhb_cn_notvat = app(CptCostPriceController::class)->list_cpcn_gvhb($request)->remaining_cost_novat;
            $cp_gvhb_cn_vat = app(CptCostPriceController::class)->list_cpcn_gvhb($request)->remaining_cost_vat;
            $cp_gvhb_notvat = app(CptCostPriceController::class)->index($request)->novat_cost;
            $cp_gvhb_vat = app(CptCostPriceController::class)->index($request)->vat_cost;

            $this->view->cp_gvhb_notvat = $cp_gvhb_notvat;
            $this->view->cp_gvhb_vat = $cp_gvhb_vat;
            $this->view->cp_gvhb_tt_notvat = $cp_gvhb_tt_notvat;
            $this->view->cp_gvhb_tt_vat = $cp_gvhb_tt_vat;
            $this->view->cp_gvhb_cn_notvat = $cp_gvhb_cn_notvat;
            $this->view->cp_gvhb_cn_vat = $cp_gvhb_cn_vat;

        // Chi phí giá vốn hàng bán sach1
            $cp_gvsach_tt_notvat = 0;
            $cp_gvsach_tt_vat = 0;
            $cp_gvsach_cn_notvat = 0;
            $cp_gvsach_cn_vat = 0;
            $cp_gvsach_notvat = 0;
            $cp_gvsach_vat = 0;

            foreach($cp_tongs->where('cplist_id', 1)->where('itemcost_id', 11) as $cp_tong) {
                $cp_gvsach_notvat += $cp_tong->novat_cost;
                $cp_gvsach_vat += $cp_tong->vat_cost;
                $cp_gvsach_tt_notvat += $cp_tong->paided_cost_novat;
                $cp_gvsach_tt_vat += $cp_tong->paided_cost_vat;
                $cp_gvsach_cn_notvat += $cp_tong->remaining_cost_novat;
                $cp_gvsach_cn_vat += $cp_tong->remaining_cost_vat;
            }
            $this->view->cp_gvsach_notvat = $cp_gvsach_notvat;
            $this->view->cp_gvsach_vat = $cp_gvsach_vat;
            $this->view->cp_gvsach_tt_notvat = $cp_gvsach_tt_notvat;
            $this->view->cp_gvsach_tt_vat = $cp_gvsach_tt_vat;
            $this->view->cp_gvsach_cn_notvat = $cp_gvsach_cn_notvat;
            $this->view->cp_gvsach_cn_vat = $cp_gvsach_cn_vat;

        // Chi phí dv làm sách
            $cp_dvsach_tt_notvat = 0;
            $cp_dvsach_tt_vat = 0;
            $cp_dvsach_cn_notvat = 0;
            $cp_dvsach_cn_vat = 0;
            $cp_dvsach_notvat = 0;
            $cp_dvsach_vat = 0;

            foreach($cp_tongs->where('cplist_id', 1)->where('itemcost_id', 12) as $cp_tong) {
                $cp_dvsach_notvat += $cp_tong->novat_cost;
                $cp_dvsach_vat += $cp_tong->vat_cost;
                $cp_dvsach_tt_notvat += $cp_tong->paided_cost_novat;
                $cp_dvsach_tt_vat += $cp_tong->paided_cost_vat;
                $cp_dvsach_cn_notvat += $cp_tong->remaining_cost_novat;
                $cp_dvsach_cn_vat += $cp_tong->remaining_cost_vat;
            }
            $this->view->cp_dvsach_notvat = $cp_dvsach_notvat;
            $this->view->cp_dvsach_vat = $cp_dvsach_vat;
            $this->view->cp_dvsach_tt_notvat = $cp_dvsach_tt_notvat;
            $this->view->cp_dvsach_tt_vat = $cp_dvsach_tt_vat;
            $this->view->cp_dvsach_cn_notvat = $cp_dvsach_cn_notvat;
            $this->view->cp_dvsach_cn_vat = $cp_dvsach_cn_vat;

        // Chi phí dv in ấn
            $cp_dvinan_tt_notvat = 0;
            $cp_dvinan_tt_vat = 0;
            $cp_dvinan_cn_notvat = 0;
            $cp_dvinan_cn_vat = 0;
            $cp_dvinan_notvat = 0;
            $cp_dvinan_vat = 0;

            foreach($cp_tongs->where('cplist_id', 1)->where('itemcost_id', 13) as $cp_tong) {
                $cp_dvinan_notvat += $cp_tong->novat_cost;
                $cp_dvinan_vat += $cp_tong->vat_cost;
                $cp_dvinan_tt_notvat += $cp_tong->paided_cost_novat;
                $cp_dvinan_tt_vat += $cp_tong->paided_cost_vat;
                $cp_dvinan_cn_notvat += $cp_tong->remaining_cost_novat;
                $cp_dvinan_cn_vat += $cp_tong->remaining_cost_vat;
            }
            $this->view->cp_dvinan_notvat = $cp_dvinan_notvat;
            $this->view->cp_dvinan_vat = $cp_dvinan_vat;
            $this->view->cp_dvinan_tt_notvat = $cp_dvinan_tt_notvat;
            $this->view->cp_dvinan_tt_vat = $cp_dvinan_tt_vat;
            $this->view->cp_dvinan_cn_notvat = $cp_dvinan_cn_notvat;
            $this->view->cp_dvinan_cn_vat = $cp_dvinan_cn_vat;
        // End chi phí dv in ấn

            // Chi phí dv khác
            $cp_dvkhac_tt_notvat = 0;
            $cp_dvkhac_tt_vat = 0;
            $cp_dvkhac_cn_notvat = 0;
            $cp_dvkhac_cn_vat = 0;
            $cp_dvkhac_notvat = 0;
            $cp_dvkhac_vat = 0;

            foreach($cp_tongs->where('cplist_id', 1)->where('itemcost_id', 14) as $cp_tong) {
                $cp_dvkhac_notvat += $cp_tong->novat_cost;
                $cp_dvkhac_vat += $cp_tong->vat_cost;
                $cp_dvkhac_tt_notvat += $cp_tong->paided_cost_novat;
                $cp_dvkhac_tt_vat += $cp_tong->paided_cost_vat;
                $cp_dvkhac_cn_notvat += $cp_tong->remaining_cost_novat;
                $cp_dvkhac_cn_vat += $cp_tong->remaining_cost_vat;
            }
            $this->view->cp_dvkhac_notvat = $cp_dvkhac_notvat;
            $this->view->cp_dvkhac_vat = $cp_dvkhac_vat;
            $this->view->cp_dvkhac_tt_notvat = $cp_dvkhac_tt_notvat;
            $this->view->cp_dvkhac_tt_vat = $cp_dvkhac_tt_vat;
            $this->view->cp_dvkhac_cn_notvat = $cp_dvkhac_cn_notvat;
            $this->view->cp_dvkhac_cn_vat = $cp_dvkhac_cn_vat;
        // End chi phí dv khác
        // End chi phí giá vốn hàng bán sách

        // Start Chi phí ql bán hàng
            $cp_bh_tt_notvat = app(CptSaleCostController::class)->list_cptt_bh($request)->paided_cost_novat;
            $cp_bh_tt_vat = app(CptSaleCostController::class)->list_cptt_bh($request)->paided_cost_vat;
            $cp_bh_cn_notvat = app(CptSaleCostController::class)->list_cpcn_bh($request)->remaining_cost_novat;
            $cp_bh_cn_vat = app(CptSaleCostController::class)->list_cpcn_bh($request)->remaining_cost_vat;
            $cp_bh_notvat = app(CptSaleCostController::class)->index($request)->novat_cost;
            $cp_bh_vat = app(CptSaleCostController::class)->index($request)->vat_cost;

            $this->view->cp_bh_notvat = $cp_bh_notvat;
            $this->view->cp_bh_vat = $cp_bh_vat;
            $this->view->cp_bh_tt_notvat = $cp_bh_tt_notvat;
            $this->view->cp_bh_tt_vat = $cp_bh_tt_vat;
            $this->view->cp_bh_cn_notvat = $cp_bh_cn_notvat;
            $this->view->cp_bh_cn_vat = $cp_bh_cn_vat;

        // start cp marketing
            $cp_marketing_tt_notvat = 0;
            $cp_marketing_tt_vat = 0;
            $cp_marketing_cn_notvat = 0;
            $cp_marketing_cn_vat = 0;
            $cp_marketing_notvat = 0;
            $cp_marketing_vat = 0;

            foreach($cp_tongs->where('cplist_id', 2)->where('itemcost_id', 1) as $cp_tong) {
                $cp_marketing_notvat += $cp_tong->novat_cost;
                $cp_marketing_vat += $cp_tong->vat_cost;
                $cp_marketing_tt_notvat += $cp_tong->paided_cost_novat;
                $cp_marketing_tt_vat += $cp_tong->paided_cost_vat;
                $cp_marketing_cn_notvat += $cp_tong->remaining_cost_novat;
                $cp_marketing_cn_vat += $cp_tong->remaining_cost_vat;
            }
            $this->view->cp_marketing_notvat = $cp_marketing_notvat;
            $this->view->cp_marketing_vat = $cp_marketing_vat;
            $this->view->cp_marketing_tt_notvat = $cp_marketing_tt_notvat;
            $this->view->cp_marketing_tt_vat = $cp_marketing_tt_vat;
            $this->view->cp_marketing_cn_notvat = $cp_marketing_cn_notvat;
            $this->view->cp_marketing_cn_vat = $cp_marketing_cn_vat;
        // end marketing
        // start cp khuyến mãi
            $cp_km_tt_notvat = 0;
            $cp_km_tt_vat = 0;
            $cp_km_cn_notvat = 0;
            $cp_km_cn_vat = 0;
            $cp_km_notvat = 0;
            $cp_km_vat = 0;

            foreach($cp_tongs->where('cplist_id', 2)->where('itemcost_id', 2) as $cp_tong) {
                $cp_km_notvat += $cp_tong->novat_cost;
                $cp_km_vat += $cp_tong->vat_cost;
                $cp_km_tt_notvat += $cp_tong->paided_cost_novat;
                $cp_km_tt_vat += $cp_tong->paided_cost_vat;
                $cp_km_cn_notvat += $cp_tong->remaining_cost_novat;
                $cp_km_cn_vat += $cp_tong->remaining_cost_vat;
            }
            $this->view->cp_km_notvat = $cp_km_notvat;
            $this->view->cp_km_vat = $cp_km_vat;
            $this->view->cp_km_tt_notvat = $cp_km_tt_notvat;
            $this->view->cp_km_tt_vat = $cp_km_tt_vat;
            $this->view->cp_km_cn_notvat = $cp_km_cn_notvat;
            $this->view->cp_km_cn_vat = $cp_km_cn_vat;
        // end khuyến mãi
        // start cp chăm sóc kh
            $cp_cskh_tt_notvat = 0;
            $cp_cskh_tt_vat = 0;
            $cp_cskh_cn_notvat = 0;
            $cp_cskh_cn_vat = 0;
            $cp_cskh_notvat = 0;
            $cp_cskh_vat = 0;

            foreach($cp_tongs->where('cplist_id', 2)->where('itemcost_id', 3) as $cp_tong) {
                $cp_cskh_notvat += $cp_tong->novat_cost;
                $cp_cskh_vat += $cp_tong->vat_cost;
                $cp_cskh_tt_notvat += $cp_tong->paided_cost_novat;
                $cp_cskh_tt_vat += $cp_tong->paided_cost_vat;
                $cp_cskh_cn_notvat += $cp_tong->remaining_cost_novat;
                $cp_cskh_cn_vat += $cp_tong->remaining_cost_vat;
            }
            $this->view->cp_cskh_notvat = $cp_cskh_notvat;
            $this->view->cp_cskh_vat = $cp_cskh_vat;
            $this->view->cp_cskh_tt_notvat = $cp_cskh_tt_notvat;
            $this->view->cp_cskh_tt_vat = $cp_cskh_tt_vat;
            $this->view->cp_cskh_cn_notvat = $cp_cskh_tt_vat;
            $this->view->cp_cskh_cn_vat = $cp_cskh_cn_vat;
        // end cp chăm sóc kh
        // start cp tiếp khách
            $cp_tk_tt_notvat = 0;
            $cp_tk_tt_vat = 0;
            $cp_tk_cn_notvat = 0;
            $cp_tk_cn_vat = 0;
            $cp_tk_notvat = 0;
            $cp_tk_vat = 0;

            foreach($cp_tongs->where('cplist_id', 2)->where('itemcost_id', 4) as $cp_tong) {
                $cp_tk_notvat += $cp_tong->novat_cost;
                $cp_tk_vat += $cp_tong->vat_cost;
                $cp_tk_tt_notvat += $cp_tong->paided_cost_novat;
                $cp_tk_tt_vat += $cp_tong->paided_cost_vat;
                $cp_tk_cn_notvat += $cp_tong->remaining_cost_novat;
                $cp_tk_cn_vat += $cp_tong->remaining_cost_vat;
            }
            $this->view->cp_tk_notvat = $cp_tk_notvat;
            $this->view->cp_tk_vat = $cp_tk_vat;
            $this->view->cp_tk_tt_notvat = $cp_tk_tt_notvat;
            $this->view->cp_tk_tt_vat = $cp_tk_tt_vat;
            $this->view->cp_tk_tt_vat = $cp_tk_tt_vat;
            $this->view->cp_tk_cn_vat = $cp_tk_cn_vat;
        // end cp tiếp khách
        // start cp dv ngoài
            $cp_dvngoai_tt_notvat = 0;
            $cp_dvngoai_tt_vat = 0;
            $cp_dvngoai_cn_notvat = 0;
            $cp_dvngoai_cn_vat = 0;
            $cp_dvngoai_notvat = 0;
            $cp_dvngoai_vat = 0;

            foreach($cp_tongs->where('cplist_id', 2)->where('itemcost_id', 6) as $cp_tong) {
                $cp_dvngoai_notvat += $cp_tong->novat_cost;
                $cp_dvngoai_vat += $cp_tong->vat_cost;
                $cp_dvngoai_tt_notvat += $cp_tong->paided_cost_novat;
                $cp_dvngoai_tt_vat += $cp_tong->paided_cost_vat;
                $cp_dvngoai_cn_notvat += $cp_tong->remaining_cost_novat;
                $cp_dvngoai_cn_vat += $cp_tong->remaining_cost_vat;
            }
            $this->view->cp_dvngoai_notvat = $cp_dvngoai_notvat;
            $this->view->cp_dvngoai_vat = $cp_dvngoai_vat;
            $this->view->cp_dvngoai_tt_notvat = $cp_dvngoai_tt_notvat;
            $this->view->cp_dvngoai_tt_vat = $cp_dvngoai_tt_vat;
            $this->view->cp_dvngoai_cn_notvat = $cp_dvngoai_cn_notvat;
            $this->view->cp_dvngoai_cn_vat = $cp_dvngoai_cn_vat;
        // end cp dv ngoài
        // start cp vận chuyển
            $cp_vc_tt_notvat = 0;
            $cp_vc_tt_vat = 0;
            $cp_vc_cn_notvat = 0;
            $cp_vc_cn_vat = 0;
            $cp_vc_notvat = 0;
            $cp_vc_vat = 0;

            foreach($cp_tongs->where('cplist_id', 2)->where('itemcost_id', 5) as $cp_tong) {
                $cp_vc_notvat += $cp_tong->novat_cost;
                $cp_vc_vat += $cp_tong->vat_cost;
                $cp_vc_tt_notvat += $cp_tong->paided_cost_novat;
                $cp_vc_tt_vat += $cp_tong->paided_cost_vat;
                $cp_vc_cn_notvat += $cp_tong->remaining_cost_novat;
                $cp_vc_cn_vat += $cp_tong->remaining_cost_vat;
            }
            $this->view->cp_vc_notvat = $cp_vc_notvat;
            $this->view->cp_vc_vat = $cp_vc_vat;
            $this->view->cp_vc_tt_notvat = $cp_vc_tt_notvat;
            $this->view->cp_vc_tt_vat = $cp_vc_tt_vat;
            $this->view->cp_vc_cn_notvat = $cp_vc_cn_notvat;
            $this->view->cp_vc_cn_vat = $cp_vc_cn_vat;
        // end cp vận chuyển
        // start cp KPI doanh số
            $cp_kpids_tt_notvat = 0;
            $cp_kpids_tt_vat = 0;
            $cp_kpids_cn_notvat = 0;
            $cp_kpids_cn_vat = 0;
            $cp_kpids_notvat = 0;
            $cp_kpids_vat = 0;

            foreach($cp_tongs->where('cplist_id', 2)->where('itemcost_id', 7) as $cp_tong) {
                $cp_kpids_notvat += $cp_tong->novat_cost;
                $cp_kpids_vat += $cp_tong->vat_cost;
                $cp_kpids_tt_notvat += $cp_tong->paided_cost_novat;
                $cp_kpids_tt_vat += $cp_tong->paided_cost_vat;
                $cp_kpids_cn_notvat += $cp_tong->remaining_cost_novat;
                $cp_kpids_cn_vat += $cp_tong->remaining_cost_vat;
            }
            $this->view->cp_kpids_notvat = $cp_kpids_notvat;
            $this->view->cp_kpids_vat = $cp_kpids_vat;
            $this->view->cp_kpids_tt_notvat = $cp_kpids_tt_notvat;
            $this->view->cp_kpids_tt_vat = $cp_kpids_tt_vat;
            $this->view->cp_kpids_cn_notvat = $cp_kpids_cn_notvat;
            $this->view->cp_kpids_cn_vat = $cp_kpids_cn_vat;
        // end cp KIP doanh số
        // start cp KPI dau viec
            $cp_kpidv_tt_notvat = 0;
            $cp_kpidv_tt_vat = 0;
            $cp_kpidv_cn_notvat = 0;
            $cp_kpidv_cn_vat = 0;
            $cp_kpidv_notvat = 0;
            $cp_kpidv_vat = 0;

            foreach($cp_tongs->where('cplist_id', 2)->where('itemcost_id', 15) as $cp_tong) {
                $cp_kpidv_notvat += $cp_tong->novat_cost;
                $cp_kpidv_vat += $cp_tong->vat_cost;
                $cp_kpidv_tt_notvat += $cp_tong->paided_cost_novat;
                $cp_kpidv_tt_vat += $cp_tong->paided_cost_vat;
                $cp_kpidv_cn_notvat += $cp_tong->remaining_cost_novat;
                $cp_kpidv_cn_vat += $cp_tong->remaining_cost_vat;
            }
            $this->view->cp_kpidv_notvat = $cp_kpidv_notvat;
            $this->view->cp_kpidv_vat = $cp_kpidv_vat;
            $this->view->cp_kpidv_tt_notvat = $cp_kpidv_tt_notvat;
            $this->view->cp_kpidv_tt_vat = $cp_kpidv_tt_vat;
            $this->view->cp_kpidv_cn_notvat = $cp_kpidv_cn_notvat;
            $this->view->cp_kpidv_cn_vat = $cp_kpidv_cn_vat;
        // end cp KIP doanh số
        // End ql bán hàng

        // Start ql doanh nghiệp
            $cp_dn_tt_notvat = app(CptEnterpriseController::class)->list_cptt_dn($request)->paided_cost_novat;
            $cp_dn_tt_vat = app(CptEnterpriseController::class)->list_cptt_dn($request)->paided_cost_vat;
            $cp_dn_cn_notvat = app(CptEnterpriseController::class)->list_cpcn_dn($request)->remaining_cost_novat;
            $cp_dn_cn_vat = app(CptEnterpriseController::class)->list_cpcn_dn($request)->remaining_cost_vat;
            $cp_dn_notvat = app(CptEnterpriseController::class)->index($request)->novat_cost;
            $cp_dn_vat = app(CptEnterpriseController::class)->index($request)->vat_cost;

            $this->view->cp_dn_notvat = $cp_dn_notvat;
            $this->view->cp_dn_vat = $cp_dn_vat;
            $this->view->cp_dn_tt_notvat = $cp_dn_tt_notvat;
            $this->view->cp_dn_tt_vat = $cp_dn_tt_vat;
            $this->view->cp_dn_cn_notvat = $cp_dn_cn_notvat;
            $this->view->cp_dn_cn_vat = $cp_dn_cn_vat;
        // start nhân sự
            $cp_ns_tt_notvat = 0;
            $cp_ns_tt_vat = 0;
            $cp_ns_cn_notvat = 0;
            $cp_ns_cn_vat = 0;
            $cp_ns_notvat = 0;
            $cp_ns_vat = 0;

            foreach($cp_tongs->where('cplist_id', 3)->where('itemcost_id', 8) as $cp_tong) {
                $cp_ns_notvat += $cp_tong->novat_cost;
                $cp_ns_vat += $cp_tong->vat_cost;
                $cp_ns_tt_notvat += $cp_tong->paided_cost_novat;
                $cp_ns_tt_vat += $cp_tong->paided_cost_vat;
                $cp_ns_cn_notvat += $cp_tong->remaining_cost_novat;
                $cp_ns_cn_vat += $cp_tong->remaining_cost_vat;
            }
            $this->view->cp_ns_notvat = $cp_ns_notvat;
            $this->view->cp_ns_vat = $cp_ns_vat;
            $this->view->cp_ns_tt_notvat = $cp_ns_tt_notvat;
            $this->view->cp_ns_tt_vat = $cp_ns_tt_vat;
            $this->view->cp_ns_cn_notvat = $cp_ns_cn_notvat;
            $this->view->cp_ns_cn_vat = $cp_ns_cn_vat;
        // end nhân sự
        // start thuê văn phòng
            $cp_thuevp_tt_notvat = 0;
            $cp_thuevp_tt_vat = 0;
            $cp_thuevp_cn_notvat = 0;
            $cp_thuevp_cn_vat = 0;
            $cp_thuevp_notvat = 0;
            $cp_thuevp_vat = 0;

            foreach($cp_tongs->where('cplist_id', 3)->where('itemcost_id', 9) as $cp_tong) {
                $cp_thuevp_notvat += $cp_tong->novat_cost;
                $cp_thuevp_vat += $cp_tong->vat_cost;
                $cp_thuevp_tt_notvat += $cp_tong->paided_cost_novat;
                $cp_thuevp_tt_vat += $cp_tong->paided_cost_vat;
                $cp_thuevp_cn_notvat += $cp_tong->remaining_cost_novat;
                $cp_thuevp_cn_vat += $cp_tong->remaining_cost_vat;
            }
            $this->view->cp_thuevp_notvat = $cp_thuevp_notvat;
            $this->view->cp_thuevp_vat = $cp_thuevp_vat;
            $this->view->cp_thuevp_tt_notvat = $cp_thuevp_tt_notvat;
            $this->view->cp_thuevp_tt_vat = $cp_thuevp_tt_vat;
            $this->view->cp_thuevp_cn_notvat = $cp_thuevp_cn_notvat;
            $this->view->cp_thuevp_cn_vat = $cp_thuevp_cn_vat;
        // end thuê văn phòng
            // start văn phòng phẩm
                $cp_vpp_tt_notvat = 0;
                $cp_vpp_tt_vat = 0;
                $cp_vpp_cn_notvat = 0;
                $cp_vpp_cn_vat = 0;
                $cp_vpp_notvat = 0;
                $cp_vpp_vat = 0;

                foreach($cp_tongs->where('cplist_id', 3)->where('itemcost_id', 10) as $cp_tong) {
                    $cp_vpp_notvat += $cp_tong->novat_cost;
                    $cp_vpp_vat += $cp_tong->vat_cost;
                    $cp_vpp_tt_notvat += $cp_tong->paided_cost_novat;
                    $cp_vpp_tt_vat += $cp_tong->paided_cost_vat;
                    $cp_vpp_cn_notvat += $cp_tong->remaining_cost_novat;
                    $cp_vpp_cn_vat += $cp_tong->remaining_cost_vat;
                }
                $this->view->cp_vpp_notvat = $cp_vpp_notvat;
                $this->view->cp_vpp_vat = $cp_vpp_vat;
                $this->view->cp_vpp_tt_notvat = $cp_vpp_tt_notvat;
                $this->view->cp_vpp_tt_vat = $cp_vpp_tt_vat;
                $this->view->cp_vpp_cn_notvat = $cp_vpp_cn_notvat;
                $this->view->cp_vpp_cn_vat = $cp_vpp_cn_vat;
            // end văn phòng phẩm
            // start dich vu thue ngoai
                $cp_dvtn_tt_notvat = 0;
                $cp_dvtn_tt_vat = 0;
                $cp_dvtn_cn_notvat = 0;
                $cp_dvtn_cn_vat = 0;
                $cp_dvtn_notvat = 0;
                $cp_dvtn_vat = 0;

                foreach($cp_tongs->where('cplist_id', 3)->where('itemcost_id', 16) as $cp_tong) {
                    $cp_dvtn_notvat += $cp_tong->novat_cost;
                    $cp_dvtn_vat += $cp_tong->vat_cost;
                    $cp_dvtn_tt_notvat += $cp_tong->paided_cost_novat;
                    $cp_dvtn_tt_vat += $cp_tong->paided_cost_vat;
                    $cp_dvtn_cn_notvat += $cp_tong->remaining_cost_novat;
                    $cp_dvtn_cn_vat += $cp_tong->remaining_cost_vat;
                }
                $this->view->cp_dvtn_notvat = $cp_dvtn_notvat;
                $this->view->cp_dvtn_vat = $cp_dvtn_vat;
                $this->view->cp_dvtn_tt_notvat = $cp_dvtn_tt_notvat;
                $this->view->cp_dvtn_tt_vat = $cp_dvtn_tt_vat;
                $this->view->cp_dvtn_cn_notvat = $cp_dvtn_cn_notvat;
                $this->view->cp_dvtn_cn_vat = $cp_dvtn_cn_vat;
            // end Dich vu thu ngoai
            // start doanh nghiep khac
                $cp_dnk_tt_notvat = 0;
                $cp_dnk_tt_vat = 0;
                $cp_dnk_cn_notvat = 0;
                $cp_dnk_cn_vat = 0;
                $cp_dnk_notvat = 0;
                $cp_dnk_vat = 0;

                foreach($cp_tongs->where('cplist_id', 3)->where('itemcost_id', 17) as $cp_tong) {
                    $cp_dnk_notvat += $cp_tong->novat_cost;
                    $cp_dnk_vat += $cp_tong->vat_cost;
                    $cp_dnk_tt_notvat += $cp_tong->paided_cost_novat;
                    $cp_dnk_tt_vat += $cp_tong->paided_cost_vat;
                    $cp_dnk_cn_notvat += $cp_tong->remaining_cost_novat;
                    $cp_dnk_cn_vat += $cp_tong->remaining_cost_vat;
                }
                $this->view->cp_dnk_notvat = $cp_dnk_notvat;
                $this->view->cp_dnk_vat = $cp_dnk_vat;
                $this->view->cp_dnk_tt_notvat = $cp_dnk_tt_notvat;
                $this->view->cp_dnk_tt_vat = $cp_dnk_tt_vat;
                $this->view->cp_dnk_cn_notvat = $cp_dnk_cn_notvat;
                $this->view->cp_dnk_cn_vat = $cp_dnk_cn_vat;
            // end doanh nghiep khac
        // End ql doanh nghiệp

        // Start tscd
            $cp_tscd_tt_notvat = app(CptFixedAssetController::class)->list_cptt_tscd($request)->paided_cost_novat;
            $cp_tscd_tt_vat = app(CptFixedAssetController::class)->list_cptt_tscd($request)->paided_cost_vat;
            $cp_tscd_cn_notvat = app(CptFixedAssetController::class)->list_cpcn_tscd($request)->remaining_cost_novat;
            $cp_tscd_cn_vat = app(CptFixedAssetController::class)->list_cpcn_tscd($request)->remaining_cost_vat;
            $cp_tscd_notvat = app(CptFixedAssetController::class)->index($request)->novat_cost;
            $cp_tscd_vat = app(CptFixedAssetController::class)->index($request)->vat_cost;

            $this->view->cp_tscd_notvat = $cp_tscd_notvat;
            $this->view->cp_tscd_vat = $cp_tscd_vat;
            $this->view->cp_tscd_tt_notvat = $cp_tscd_tt_notvat;
            $this->view->cp_tscd_tt_vat = $cp_tscd_tt_vat;
            $this->view->cp_tscd_cn_notvat = $cp_tscd_cn_notvat;
            $this->view->cp_tscd_cn_vat = $cp_tscd_cn_vat;
        // End tscd

        // Start khác
            $cp_khac_tt_notvat = app(CptOtherController::class)->list_cptt_khac($request)->paided_cost_novat;
            $cp_khac_tt_vat = app(CptOtherController::class)->list_cptt_khac($request)->paided_cost_vat;
            $cp_khac_cn_notvat = app(CptOtherController::class)->list_cpcn_khac($request)->remaining_cost_novat;
            $cp_khac_cn_vat = app(CptOtherController::class)->list_cpcn_khac($request)->remaining_cost_vat;
            $cp_khac_notvat = app(CptOtherController::class)->index($request)->novat_cost;
            $cp_khac_vat = app(CptOtherController::class)->index($request)->vat_cost;

            $this->view->cp_khac_notvat = $cp_khac_notvat;
            $this->view->cp_khac_vat = $cp_khac_vat;
            $this->view->cp_khac_tt_notvat = $cp_khac_tt_notvat;
            $this->view->cp_khac_tt_vat = $cp_khac_tt_vat;
            $this->view->cp_khac_cn_notvat = $cp_khac_cn_notvat;
            $this->view->cp_khac_cn_vat = $cp_khac_cn_vat;
        // End khác

        // END CHI PHÍ

        $this->view->setSubHeading('home.Danh sách');
        return $this->view('index');
    }
}
