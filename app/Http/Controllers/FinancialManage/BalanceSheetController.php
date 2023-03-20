<?php

namespace App\Http\Controllers\FinancialManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\BalanceSheetService;

class BalanceSheetController extends Controller
{
    public function __construct(BalanceSheetService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('financial-manage.balance_sheet.');
        $this->setRoutePrefix('balancesheets-');

        $this->view->setHeading('Cân đối kế toán');
    }

    public function index(Request $request )
    {

        $this->view->collections = $this->main_service->getSortPage($this->view->filter['limit']);
        // Setup title
        $this->view->setSubHeading('Danh sách');
        return $this->view('index');
    }

    public function store(Request $request)
    {
        return $this->_store($request);
    }

    public function update(Request $request, $id)
    {
        return $this->_update($request, $id);
    }
}
