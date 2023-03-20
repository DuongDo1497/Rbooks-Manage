<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SecurityResourcesStoreRequest;
use RBooks\Services\SecurityResourcesService;
use App\Constants\NotificationMessage;
use RBooks\Models\SecurityResources;
use RBooks\Models\ApplicationResources;
use RBooks\Services\ApplicationRolesService;
use RBooks\Services\UserService;
use RBooks\Services\APIAdminService;

class SecurityResourcesController extends Controller
{
    public function __construct(SecurityResourcesService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('company-manage.securityresources.');
        $this->setRoutePrefix('securityresources-');
        $this->view->setHeading('Thông tin phân quyền trang truy cập');
    }

    public function index(Request $request)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();
        
        $applicationresourceid = $request->applicationresourceid;
        $this->view->applicationresourceid = $applicationresourceid;

        $this->view->collections = $this->main_service->getSecurityResources($applicationresourceid);
        $this->view->setSubHeading('Thông tin phân quyền trang truy cập');
        return $this->view('index');
    }

    public function addSecurityResources(Request $request)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();
        $applicationresourceid = $request->applicationresourceid;
        $applicationresources = app(ApplicationResources::class)->find($applicationresourceid);
        $this->view->applicationresources = $applicationresources;
        $this->view->applicationresourceid = $applicationresourceid;

        $this->view->applicationroles = app(ApplicationRolesService::class)->getAll();
        $this->view->users = app(UserService::class)->getAll();

        $this->view->setSubHeading('Tạo mới dữ liệu');

        return $this->view('add');
    }
        
    public function store(SecurityResourcesStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function editSecurityResources(Request $request)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();
        $applicationresourceid = $request->applicationresourceid;
        $applicationresources = app(ApplicationResources::class)->find($applicationresourceid);
        $this->view->applicationresources = $applicationresources;
        $this->view->applicationresourceid = $applicationresourceid;

        $this->view->applicationroles = app(ApplicationRolesService::class)->getAll();
        $this->view->users = app(UserService::class)->getAll();

        $id = $request->id;
        $this->view->model = $this->main_service->find($id);
        
        if ($this->view->model->cuserview != ""){
            $this->view->model->cuserview = explode(",", $this->view->model->cuserview);         
        }else{
            $this->view->model->cuserview = array();
        }

        $this->view->setSubHeading('Chỉnh sửa dữ liệu');

        return $this->view('edit');
    }

    public function update(Request $request, $id)
    {
        $applicationresourceid = $request->resourcecode;

        $model = $this->main_service->update($request, $id);

        if (!$model) {
            return redirect()
                ->route($this->route_prefix . 'edit', ['id' => $id])
                ->withErrors(NotificationMessage::UPDATE_ERROR);
        }

        return redirect()
            ->route($this->route_prefix . 'index', ['applicationresourceid' => $applicationresourceid])
            ->with(NotificationMessage::UPDATE_SUCCESS);
    }

    public function deleteSecurityResources(Request $request)
    {
        $applicationresourceid = $request->applicationresourceid;

        $id = $request->id;
        $this->main_service->delete($id);
        return redirect()->route($this->route_prefix . 'index', ['applicationresourceid' => $applicationresourceid])->with(NotificationMessage::DELETE_SUCCESS);
    }
}
