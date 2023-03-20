<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationModulesStoreRequest;
use RBooks\Services\ApplicationModulesService;
use App\Constants\NotificationMessage;
use RBooks\Models\ApplicationModules;
use RBooks\Services\APIAdminService;

class ApplicationModulesController extends Controller
{
    public function __construct(ApplicationModulesService $service)
    {
        parent::__construct($service);

        $this->view->collections =  $this->main_service->getPaginate();       
        $this->setViewPrefix('company-manage.applicationmodules.');
        $this->setRoutePrefix('applicationmodules-');
        $this->view->setHeading('Thông tin module chức năng');
    }

    public function index(Request $request)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();
        return $this->view('index');
    }

    public function beforeAdd()
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();
    }
    
    public function store(ApplicationModulesStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();
        $this->view->model = $this->main_service->find($id);
        $this->view->setSubHeading('Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(ApplicationModulesStoreRequest $request, $id)
    {
        return $this->_update($request, $id);
    }

}
