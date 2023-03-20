<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmplperdayStoreRequest;
use RBooks\Services\EmplperdayService;
use RBooks\Services\EmployeeService;
use RBooks\Services\CheckEmployeeService;

class EmplperdayController extends Controller
{
    public function __construct(EmplperdayService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('company-manage.emplperday.');
        $this->setRoutePrefix('emplperdays-');

        $this->view->employees = app(EmployeeService::class)->getAll();
        // $this->view->listcheckemplInYear = app(CheckEmployeeService::class)->listcheckemplInYear();
        // dd($this->view->listcheckemplInYear);

        $this->view->setHeading('home.Quản lý ngày phép');
    }

    public function index(Request $request )
    {
        parent::index($request);
        foreach ($this->view->collections as $value) {
            $value->listcheckemplInYear = app(CheckEmployeeService::class)->listcheckemplInYear($value->employee_id);
        }

        return $this->view('index');
    }

    public function store(EmplperdayStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {
        $this->view->emplperday = $this->main_service->find($id);
        $this->view->setSubHeading('home.Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(Request $request, $id)
    {
        return $this->_update($request, $id);
    }

}
