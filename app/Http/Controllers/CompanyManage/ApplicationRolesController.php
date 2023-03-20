<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constants\NotificationMessage;
use App\Http\Requests\ApplicationRolesStoreRequest;
use RBooks\Services\ApplicationRolesService;
use RBooks\Services\ApplicationModulesService;
use RBooks\Services\ApplicationResourcesService;
use RBooks\Models\ApplicationRoles;
use RBooks\Services\APIAdminService;

class ApplicationRolesController extends Controller
{
    
    public function __construct(ApplicationRolesService $service)
    {
        parent::__construct($service);

        $this->view->collections = app(ApplicationRolesService::class)->getAll();       
        $this->setViewPrefix('company-manage.applicationroles.');
        $this->setRoutePrefix('applicationroles-');
        $this->view->setHeading('Thông tin role chức năng');
    }

    public function index(Request $request)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();       

        return $this->view('index');
    }

    public function beforeAdd()
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();
        $this->view->applicationmodules = app(ApplicationModulesService::class)->getAll();
        $this->view->applicationroles = app(ApplicationRolesService::class)->getAll();
    }

    public function store(ApplicationRolesStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();
        $this->view->model = $this->main_service->find($id);
        $ModulesAllowed = explode(',', $this->view->model->modulesallowed);
        
        $this->view->applicationmodules = app(ApplicationModulesService::class)->getAll();
        $this->view->modulesallowed = $ModulesAllowed;

        $this->view->applicationroles = app(ApplicationRolesService::class)->getAll();
                
        $this->view->setSubHeading('Chỉnh sửa');

        return $this->view('edit');
    }

    public function update(ApplicationRolesStoreRequest $request, $id)
    {
        return $this->_update($request, $id);
    }

    public function setResource($id)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu(); 
        $this->view->roleid = $id;        
        $this->view->checkall = '';        
        $this->view->checkvalue = '';        

        $this->view->listprefix = app(ApplicationResourcesService::class)->getApplicationResourcesPrefix();
        $searchfilename = '';
        $searchprefix = '';
        $this->view->searchfilename = $searchfilename;
        $this->view->searchprefix = $searchprefix;

        $this->view->collections = $this->main_service->getSecurityResourcesFromRoleId($id, $searchprefix, $searchfilename);        
              
        return $this->view('setResource');
    }

    public function updateResource(Request $request)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu(); 
        $this->view->roleid = $request->roleid;        
        $this->view->checkall = $request->checkall;        
        $this->view->checkvalue = $request->checkvalue;        

        $this->view->listprefix = app(ApplicationResourcesService::class)->getApplicationResourcesPrefix();
        $searchfilename = ($request->searchfilename == null ? '' : $request->searchfilename);
        $searchprefix = ($request->searchprefix == null ? '' : $request->searchprefix);
        $this->view->searchfilename = $searchfilename;
        $this->view->searchprefix = $searchprefix;

        $typereport = $request->typereport;
        if ($typereport == 'update'){
        	$result = $this->main_service->updateSecurityResources($request); 
            $collections = $this->main_service->getSecurityResourcesFromRoleId($request->roleid, $searchprefix, $searchfilename);

            $message = "";
            if ($result){
                $message = "Thông tin đã được lưu thành công !";
            }else{
                $message = "Lỗi lưu dữ liệu !";
            }
            $this->view->infor = $message;
            
        }else{
            if ($typereport == 'getResource'){
                $ret = $this->main_service->updateNewSecurityResourcesFromRoleId($request->roleid);    
            }
            if ($typereport == 'search' OR $typereport == 'getResource'){
                $collections = $this->main_service->getSecurityResourcesFromRoleId($request->roleid, $searchprefix, $searchfilename);
            }else{
        	    $collections = $this->main_service->changeSecurityResourcesFromRoleId($request);
            }
        }

        $this->view->collections = $collections; 
        
              
        return $this->view('setResource');
    }
    
    public function setMenu($id)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu(); 
        $this->view->roleid = $id;        
        $this->view->checkall = '';        
        $this->view->checkvalue = '';        

        $this->view->collections = $this->main_service->getMenuSecurityResourcesFromRoleId($id);        
              
        return $this->view('setMenu');
    }

    public function updateMenu(Request $request)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu(); 
        $this->view->roleid = $request->roleid;        
        $this->view->checkall = $request->checkall;        
        $this->view->checkvalue = $request->checkvalue;        

        $typereport = $request->typereport;
        if ($typereport == 'update'){
            $result = $this->main_service->updateMenuSecurityResources($request); 
            $collections = $this->main_service->getMenuSecurityResourcesFromRoleId($request->roleid);

            $message = "";
            if ($result){
                $message = "Thông tin đã được lưu thành công !";
            }else{
                $message = "Lỗi lưu dữ liệu !";
            }
            $this->view->infor = $message;
            
        }else{
            if ($typereport == 'getResource'){
                $ret = $this->main_service->updateNewSecurityResourcesFromRoleId($request);    
            }
            $collections = $this->main_service->changeMenuSecurityResourcesFromRoleId($request);
        }

        $this->view->collections = $collections; 
        
              
        return $this->view('setMenu');
    }

    public function getApplicationRoles(Request $request)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu(); 
        $ret = $this->main_service->updateApplicationRoles();

        return redirect()->route($this->route_prefix . 'index')->with(NotificationMessage::UPDATE_SUCCESS);;
    }        
}
