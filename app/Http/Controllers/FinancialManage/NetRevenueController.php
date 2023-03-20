<?php

namespace App\Http\Controllers\FinancialManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\NetRevenueStoreRequest;
use App\Http\Requests\NetRevenueUpdateRequest;
use RBooks\Services\NetRevenueService;
///use RBooks\Services\SupplierService;
//use RBooks\Services\ImportService;

class NetRevenueController extends Controller
{
    public function __construct(NetRevenueService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('financial-manage.net_revenue.');
        $this->setRoutePrefix('net_revenues-');
        //$this->view->suppliers = app(SupplierService::class)->getAll();
        //$this->view->imports = app(ImportService::class)->getAll();

        $this->view->setHeading('Quản lý doanh thu thực tế');
    }

    public function index(Request $request )
    {
        // Get data
        // $order = $request->sortedBy ? $request->sortedBy : 'desc';
        // $field = $request->orderBy ? $request->orderBy : 'id';
        $this->view->collections = $this->main_service->getSortPage($this->view->filter['limit']);

        // Tổng tiền k vat
        $revenue_notvat = 0;
        foreach($this->view->collections as $net) {
            $revenue_notvat += $net['revenue_notvat'];
        }

        // Tổng tiền có vat
        $revenue_vat = 0;
        foreach($this->view->collections as $net) {
            $revenue_vat += $net['revenue_vat'];
        }
        $this->view->revenue_notvat = $revenue_notvat;
        $this->view->revenue_vat = $revenue_vat;
        // Setup title
        $this->view->setSubHeading('Danh sách');
        return $this->view('index');
    }

    public function store(NetRevenueStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function update(NetRevenueUpdateRequest $request, $id)
    {
        return $this->_update($request, $id);
    }
}
