<?php

namespace App\Http\Controllers\FinancialManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReceivablesDebtStoreRequest;
use App\Http\Requests\ReceivablesDebtUpdateRequest;
use RBooks\Services\ReceivablesDebtService;
use RBooks\Services\SupplierService;
use RBooks\Services\ImportService;

class ReceivablesDebtController extends Controller
{
    public function __construct(ReceivablesDebtService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('financial-manage.receivables_debt.');
        $this->setRoutePrefix('receivables_debts-');
        $this->view->suppliers = app(SupplierService::class)->getAll();
        $this->view->imports = app(ImportService::class)->getAll();

        $this->view->setHeading('Quản lý công nợ phải thu');
    }

    public function index(Request $request )
    {
        // Get data
        // $order = $request->sortedBy ? $request->sortedBy : 'desc';
        // $field = $request->orderBy ? $request->orderBy : 'id';
        $this->view->collections = $this->main_service->getSortPage($this->view->filter['limit']);

        // Tổng tiền k vat
        $revenue_notvat = 0;
        foreach($this->view->collections->where('status', "Chưa thu") as $receivable) {
            $revenue_notvat += $receivable['receivable_notvat'];
        }

        // Tổng tiền có vat
        $revenue_vat = 0;
        foreach($this->view->collections->where('status', "Chưa thu") as $receivable) {
            $revenue_vat += $receivable['receivable_vat'];
        }
        $this->view->revenue_notvat = $revenue_notvat;
        $this->view->revenue_vat = $revenue_vat;
        // Setup title
        $this->view->setSubHeading('Danh sách');
        return $this->view('index');
    }

    public function store(ReceivablesDebtStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function update(ReceivablesDebtUpdateRequest $request, $id)
    {
        return $this->_update($request, $id);
    }
}
