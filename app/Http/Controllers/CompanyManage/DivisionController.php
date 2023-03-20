<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DivisionStoreRequest;
use RBooks\Services\DivisionService;
use RBooks\Services\DepartmentService;

class DivisionController extends Controller
{
    public function __construct(DivisionService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('company-manage.division.');
        $this->setRoutePrefix('divisions-');
        $this->view->departments = app(DepartmentService::class)->getAll();

        $this->view->setHeading('home.Quản lý bộ phận');
    }

    public function store(DivisionStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {
        $this->view->division = $this->main_service->find($id);
        // Setup title
        $this->view->setSubHeading('home.Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(Request $request, $id)
    {
        return $this->_update($request, $id);
    }
}
