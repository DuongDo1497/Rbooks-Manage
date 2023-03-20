<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentStoreRequest;
use RBooks\Services\DepartmentService;

class DepartmentController extends Controller
{
    public function __construct(DepartmentService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('company-manage.department.');
        $this->setRoutePrefix('departments-');
        $this->view->setHeading('home.Quản lý phòng ban');
    }

    public function store(DepartmentStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {
        $this->view->department = $this->main_service->find($id);
        $this->view->setSubHeading('home.Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(Request $request, $id)
    {
        return $this->_update($request, $id);
    }
}
