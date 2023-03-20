<?php

namespace App\Http\Controllers\FinancialManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\ClearingDebtService;
use App\Constants\NotificationMessage;

class ClearingDebtController extends Controller
{
    public function __construct(ClearingDebtService $service)
    {
        parent::__construct($service);
        $this->setViewPrefix('financial-manage.gross_revenue.');
        $this->setRoutePrefix('clearing_debt-');
    }

    public function store(Request $request, $gross_revenue_id)
    {
        $model = $this->main_service->create($request, $gross_revenue_id);
        return redirect()->back()->with(NotificationMessage::CREATE_SUCCESS);
    }

    /**
     * Delete a model
     */
    public function delete($id)
    {
        $this->main_service->delete($id);
        return redirect()->back()->with(NotificationMessage::DELETE_SUCCESS);;
    }

    public function edit($id)
    {
        $this->view->clearing = $this->main_service->find($id);
        $this->view->setSubHeading('home.Chỉnh sửa');
        return $this->view('editClearing');
    }

    public function update(Request $request, $id)
    {
        $model = $this->main_service->update($request, $id);
        return redirect()->back()->with(NotificationMessage::UPDATE_SUCCESS);;
    }
}
