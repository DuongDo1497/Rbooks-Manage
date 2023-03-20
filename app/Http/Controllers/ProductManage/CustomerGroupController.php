<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\CustomerGroupService;
use App\Constants\NotificationMessage;
use App\Http\Requests\CustomerGroupUpdateRequest;
use App\Http\Requests\CustomerGroupStoreRequest;

class CustomerGroupController extends Controller
{
    public function __construct(CustomerGroupService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.customer.group.');
        $this->setRoutePrefix('customers-groups');

        $this->view->setHeading('home.Quản lý nhóm khách hàng');
    }

    public function store(CustomerGroupStoreRequest $request)
    {
        $model = $this->main_service->create($request);

        if (!$model) {
            return redirect()
                ->route($this->route_prefix . '-index')
                ->withErrors(NotificationMessage::CREATE_ERROR);
        }

        if ($request->continue) {
            return redirect()
                ->route($this->route_prefix . '-add')
                ->with(NotificationMessage::CREATE_SUCCESS);
        }

        return redirect()
            ->route($this->route_prefix . '-edit', ['id' => $model->id])
            ->with(NotificationMessage::CREATE_SUCCESS);
    }

    public function update(CustomerGroupUpdateRequest $request, $id)
    {
        $model = $this->main_service->update($request, $id);

        if (!$model) {
            return redirect()
                ->route($this->route_prefix . '-index')
                ->withErrors(NotificationMessage::UPDATE_ERROR);
        }

        if ($request->continue) {
            return redirect()
                ->route($this->route_prefix . '-edit', ['id' => $id])
                ->with(NotificationMessage::UPDATE_SUCCESS);
        }

        return redirect()
            ->route($this->route_prefix . '-import')
            ->with(NotificationMessage::UPDATE_SUCCESS);
    }

    public function delete($id)
    {
        $this->main_service->delete($id);
        return redirect()->route($this->route_prefix . '-index')->with(NotificationMessage::DELETE_SUCCESS);
    }
}
