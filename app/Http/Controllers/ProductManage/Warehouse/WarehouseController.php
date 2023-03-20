<?php

namespace App\Http\Controllers\ProductManage\Warehouse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\WarehouseStoreRequest;
use App\Http\Requests\WarehouseUpdateRequest;
use RBooks\Services\WarehouseService;

class WarehouseController extends Controller
{
    public function __construct(WarehouseService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.warehouse.');
        $this->setRoutePrefix('warehouses-');
        $this->view->setHeading('home.Quản lý kho hàng');
    }

    public function store(WarehouseStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function update(WarehouseUpdateRequest $request, $id)
    {
        return $this->_update($request, $id);
    }

    /*
    * Tính năng báo cáo kho
    * Thống kê báo cáo của từng kho hàng theo số lượng Nhập hàng vào kho
    * (dựa trên phiếu Nhập hàng và phiếu Chuyển Kho),
    * số lượng Xuất hàng khỏi kho (dựa trên phiếu Xuất kho và phiếu Chuyển Kho)
    * và tổng số lượng tồn kho của các sản phẩm trong kho hiện tại
    * Link mô tả tính năng https://docs.google.com/spreadsheets/d/1v5cF714LAhMDNLpSHRs9So9HN3I4Mffl/edit#gid=222092342
    */
    public function reports(Request $request)
    {
        $warehouses_all = $this->main_service->get_reports_by_date($request);
        $this->view->export_and_import_times = ($this->main_service->get_export_and_import_times($warehouses_all)
        );

        $this->view->export_and_import_quantity = ($this->main_service->get_total_export_and_import_quantity($warehouses_all)
        );

        $this->view->collections = $this->main_service->get_collections($request);
        $locale = session('locale');
        $this->view->locale = $locale;
        $this->view->setSubHeading('home.Báo cáo kho');
        return $this->view('reports.index');
    }

    /*
    * Tính năng báo cáo chi tiết của từng kho
    * Thống kê báo cáo của kho hàng theo số lượng Nhập hàng vào kho
    * (dựa trên phiếu Nhập hàng và phiếu Chuyển Kho),
    * số lượng Xuất hàng khỏi kho (dựa trên phiếu Xuất kho và phiếu Chuyển Kho)
    * và tổng số lượng tồn kho của các sản phẩm trong kho
    * Link mô tả tính năng https://docs.google.com/spreadsheets/d/1v5cF714LAhMDNLpSHRs9So9HN3I4Mffl/edit#gid=222092342
    */
    public function report_details(Request $request, $warehouse_id)
    {
        $warehouse = ($this->main_service->get_specify_warehouse_with_date($request, $warehouse_id)
        );

        $this->view->warehouse = $warehouse;
        $this->view->in_stock = $warehouse->in_stock;
        $this->view->collections = $this->main_service->get_details_collections(
            $warehouse,
            $this->view->filter['limit']
        );
        return $this->view('reports.details');
    }
}
