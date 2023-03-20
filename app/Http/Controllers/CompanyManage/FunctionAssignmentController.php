<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FunctionAssignmentStoreRequest;
use RBooks\Services\FunctionAssignmentService;
use App\Constants\NotificationMessage;
use RBooks\Models\FunctionAssignment;
use RBooks\Models\ApplicationModules;
use RBooks\Models\ApplicationFunctionGroups;
use RBooks\Services\ApplicationResourcesService;
use RBooks\Services\APIAdminService;

class FunctionAssignmentController extends Controller
{
    public function __construct(FunctionAssignmentService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('company-manage.functionassignment.');
        $this->setRoutePrefix('functionassignment-');
        $this->view->setHeading('Thông tin chức năng');
    }

    public function index(Request $request)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();
        
        $applicationmoduleid = $request->applicationmoduleid;
        $applicationmodules = app(ApplicationModules::class)->find($applicationmoduleid);
        $this->view->applicationmodules = $applicationmodules;
        $this->view->applicationmoduleid = $applicationmoduleid;

        $applicationfunctiongroupid = $request->applicationfunctiongroupid;
        $applicationfunctiongroup = app(ApplicationFunctionGroups::class)->find($applicationfunctiongroupid);
        $this->view->applicationfunctiongroup = $applicationfunctiongroup;
        $this->view->applicationfunctiongroupid = $applicationfunctiongroupid;


        $this->view->collections = $this->main_service->getFunctionAssignment($applicationfunctiongroupid);
        $this->view->setSubHeading('Thông tin chức năng');
        return $this->view('index');
    }

    public function addFunctionAssignment(Request $request)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();
        
        $applicationmoduleid = $request->applicationmoduleid;

        $applicationmodules = app(ApplicationModules::class)->find($applicationmoduleid);
        $this->view->applicationmodules = $applicationmodules;
        $this->view->applicationmoduleid = $applicationmoduleid;

        $applicationfunctiongroupid = $request->applicationfunctiongroupid;
        $applicationfunctiongroup = app(ApplicationFunctionGroups::class)->find($applicationfunctiongroupid);
        $this->view->applicationfunctiongroup = $applicationfunctiongroup;
        $this->view->applicationfunctiongroupid = $applicationfunctiongroupid;

        $this->view->applicationresources = app(ApplicationResourcesService::class)->getAll();
        
        $this->view->setSubHeading('Tạo mới dữ liệu');

        return $this->view('add');
    }
    
    public function store(FunctionAssignmentStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function editFunctionAssignment(Request $request)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();
        
        $applicationmoduleid = $request->applicationmoduleid;

        $applicationmodules = app(ApplicationModules::class)->find($applicationmoduleid);
        $this->view->applicationmodules = $applicationmodules;
        $this->view->applicationmoduleid = $applicationmoduleid;

        $applicationfunctiongroupid = $request->applicationfunctiongroupid;
        $applicationfunctiongroup = app(ApplicationFunctionGroups::class)->find($applicationfunctiongroupid);
        $this->view->applicationfunctiongroup = $applicationfunctiongroup;
        $this->view->applicationfunctiongroupid = $applicationfunctiongroupid;

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

        $applicationfunctiongroupid = $request->applicationfunctiongroupid;
        $applicationfunctiongroup = app(ApplicationFunctionGroups::class)->find($applicationfunctiongroupid);
        $this->view->applicationfunctiongroup = $applicationfunctiongroup;
        $this->view->applicationfunctiongroupid = $applicationfunctiongroupid;

        $model = $this->main_service->update($request, $id);

        if (!$model) {
            return redirect()
                ->route($this->route_prefix . 'edit', ['id' => $id])
                ->withErrors(NotificationMessage::UPDATE_ERROR);
        }

        return redirect()
            ->route($this->route_prefix . 'index', ['applicationmoduleid' => $applicationmoduleid, 'applicationfunctiongroupid' => $applicationfunctiongroupid])
            ->with(NotificationMessage::UPDATE_SUCCESS);
    }

    public function deleteFunctionAssignment(Request $request)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();
        
        $applicationmoduleid = $request->applicationmoduleid;

        $applicationmodules = app(ApplicationModules::class)->find($applicationmoduleid);
        $this->view->applicationmodules = $applicationmodules;
        $this->view->applicationmoduleid = $applicationmoduleid;

        $applicationfunctiongroupid = $request->applicationfunctiongroupid;
        $applicationfunctiongroup = app(ApplicationFunctionGroups::class)->find($applicationfunctiongroupid);
        $this->view->applicationfunctiongroup = $applicationfunctiongroup;
        $this->view->applicationfunctiongroupid = $applicationfunctiongroupid;

        $id = $request->id;
        $this->main_service->delete($id);
        return redirect()->route($this->route_prefix . 'index', ['applicationmoduleid' => $applicationmoduleid, 'applicationfunctiongroupid' => $applicationfunctiongroupid])->with(NotificationMessage::DELETE_SUCCESS);
    }

}
