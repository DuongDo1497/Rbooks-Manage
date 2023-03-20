<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CareerStoreRequest;
use RBooks\Services\CareerService;

class CareerController extends Controller
{
    public function __construct(CareerService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('company-manage.career.');
        $this->setRoutePrefix('careers-');

        $this->view->careers = app(CareerService::class)->getAll();

        $this->view->setHeading('home.Quản lý tuyển dụng');
    }

    public function store(CareerStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {
        $this->view->career = $this->main_service->find($id);
        $this->view->setSubHeading('home.Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(Request $request, $id)
    {
        return $this->_update($request, $id);
    }
}
