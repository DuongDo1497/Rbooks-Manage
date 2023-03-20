<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PositionStoreRequest;
use RBooks\Services\PositionService;
use RBooks\Services\DivisionService;
use RBooks\Services\DepartmentService;

class PositionController extends Controller
{
    public function __construct(PositionService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('company-manage.position.');
        $this->setRoutePrefix('positions-');

        $this->view->setHeading('home.Quản lý chức vụ');
    }

    public function store(PositionStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {
        $this->view->position = $this->main_service->find($id);
        // Setup title
        $this->view->setSubHeading('home.Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(Request $request, $id)
    {
        return $this->_update($request, $id);
    }
}
