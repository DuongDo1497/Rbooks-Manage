<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\OtherCostStoreRequest;
use RBooks\Services\OtherCostService;

class OtherCostController extends Controller
{
    public function __construct(OtherCostService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('company-manage.cp_othercost.');
        $this->setRoutePrefix('other_costs-');

        $this->view->other_costs = app(OtherCostService::class)->getAll();

        $this->view->setHeading('Chi phí khác');
    }

    public function store(OtherCostStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {
        $this->view->other_cost = $this->main_service->find($id);
        $this->view->setSubHeading('Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(Request $request, $id)
    {
        return $this->_update($request, $id);
    }
}
