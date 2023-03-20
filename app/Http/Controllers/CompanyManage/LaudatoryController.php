<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DiscipLineStoreRequest;
use RBooks\Services\LaudatoryService;
use RBooks\Services\EmployeeService;

class LaudatoryController extends Controller
{
    public function __construct(LaudatoryService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('user-employees.laudatory.');
        $this->setRoutePrefix('laudatories-');

        $this->view->employees = app(EmployeeService::class)->getAll();

        $this->view->setHeading('Quá trình khen thưởng');
    }

    public function store(DiscipLineStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {
        $this->view->laudatories = $this->main_service->find($id);
        $this->view->setSubHeading('Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(Request $request, $id)
    {
        return $this->_update($request, $id);
    }
}
