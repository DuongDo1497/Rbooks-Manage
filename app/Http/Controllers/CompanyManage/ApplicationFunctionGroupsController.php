<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationFunctionGroupsStoreRequest;
use RBooks\Services\ApplicationFunctionGroupsService;
use App\Constants\NotificationMessage;
use RBooks\Models\ApplicationFunctionGroups;
use RBooks\Models\ApplicationModules;
use RBooks\Services\ApplicationResourcesService;
use RBooks\Services\APIAdminService;

class ApplicationFunctionGroupsController extends Controller
{
    public function __construct(ApplicationFunctionGroupsService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('company-manage.applicationfunctiongroups.');
        $this->setRoutePrefix('applicationfunctiongroups-');
        $this->view->setHeading('Thông tin nhóm menu chức năng');
    }

    public function index(Request $request)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();
        
        $applicationmoduleid = $request->applicationmoduleid;
        $applicationmodules = app(ApplicationModules::class)->find($applicationmoduleid);
        $this->view->applicationmodules = $applicationmodules;
        $this->view->applicationmoduleid = $applicationmoduleid;

        $this->view->collections = $this->main_service->getApplicatinFunctionGroups($applicationmoduleid);
        $this->view->setSubHeading('Thông tin nhóm menu chức năng');
        return $this->view('index');
    }

    public function addApplicationFunctionGroups(Request $request)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();
        
        $applicationmoduleid = $request->applicationmoduleid;

        $applicationmodules = app(ApplicationModules::class)->find($applicationmoduleid);
        $this->view->applicationmodules = $applicationmodules;
        $this->view->applicationmoduleid = $applicationmoduleid;

        $this->view->applicationresources = app(ApplicationResourcesService::class)->getAll();
        
        $this->view->setSubHeading('Tạo mới dữ liệu');

        return $this->view('add');
    }
    
    public function store(ApplicationFunctionGroupsStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function editApplicationFunctionGroups(Request $request)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();
        
        $applicationmoduleid = $request->applicationmoduleid;

        $applicationmodules = app(ApplicationModules::class)->find($applicationmoduleid);
        $this->view->applicationmodules = $applicationmodules;
        $this->view->applicationmoduleid = $applicationmoduleid;

        $this->view->applicationresources = app(ApplicationResourcesService::class)->getAll();
        
        $id = $request->id;
        $this->view->model = $this->main_service->find($id);
        $this->view->setSubHeading('Chỉnh sửa dữ liệu');

        return $this->view('edit');
    }
    
    public function update(Request $request, $id)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();
        
        $applicationmoduleid = $request->applicationmoduleid;

        $applicationmodules = app(ApplicationModules::class)->find($applicationmoduleid);
        $this->view->applicationmodules = $applicationmodules;
        $this->view->applicationmoduleid = $applicationmoduleid;

        $this->view->applicationresources = app(ApplicationResourcesService::class)->getAll();
        
        $model = $this->main_service->update($request, $id);

        if (!$model) {
            return redirect()
                ->route($this->route_prefix . 'edit', ['id' => $id])
                ->withErrors(NotificationMessage::UPDATE_ERROR);
        }

        return redirect()
            ->route($this->route_prefix . 'index', ['applicationmoduleid' => $applicationmoduleid])
            ->with(NotificationMessage::UPDATE_SUCCESS);
    }

    public function deleteApplicationFunctionGroups(Request $request)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();
        
        $applicationmoduleid = $request->applicationmoduleid;

        $applicationmodules = app(ApplicationModules::class)->find($applicationmoduleid);
        $this->view->applicationmodules = $applicationmodules;
        $this->view->applicationmoduleid = $applicationmoduleid;

        $id = $request->id;
        $this->main_service->delete($id);
        return redirect()->route($this->route_prefix . 'index', ['applicationmoduleid' => $applicationmoduleid])->with(NotificationMessage::DELETE_SUCCESS);
    }

}
