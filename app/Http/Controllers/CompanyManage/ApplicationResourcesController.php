<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationResourcesStoreRequest;
use RBooks\Services\ApplicationResourcesService;
use App\Constants\NotificationMessage;
use RBooks\Models\ApplicationResources;
use RBooks\Services\APIAdminService;

class ApplicationResourcesController extends Controller
{
    public function __construct(ApplicationResourcesService $service)
    {
        parent::__construct($service);

        $this->view->collections = $this->main_service->getSortPage('filename', 'ASC', 20);       
        $this->setViewPrefix('company-manage.applicationresources.');
        $this->setRoutePrefix('applicationresources-');
        $this->view->setHeading('Thông tin chức năng');
    }

    public function index(Request $request)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();

        $this->view->listprefix = $this->main_service->getApplicationResourcesPrefix();

        $searchfilename = ($request->searchfilename == null ? '' : $request->searchfilename);
        $searchprefix = ($request->searchprefix == null ? '' : $request->searchprefix);
        $this->view->searchfilename = $searchfilename;
        $this->view->searchprefix = $searchprefix;

        $collections = $this->main_service->getListApplicationResources($searchprefix, $searchfilename)->paginate(20);        
        $this->view->collections = $collections;

        return $this->view('index');
    }

    public function beforeAdd()
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();
        
        $maxValue = app(ApplicationResources::class)::max('code');
        $maxValue = intval($maxValue) + 1;
        $maxValue = addPadding( $maxValue, 4, '0');
        $this->view->code = $maxValue;
        $this->view->pagesecurity = 0;
    }
    
    public function store(ApplicationResourcesStoreRequest $request)
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

    public function update(ApplicationResourcesStoreRequest $request, $id)
    {
        return $this->_update($request, $id);
    }

    public function getApplicationResources(Request $request)
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu(); 
        $ret = $this->main_service->updateApplicationResources();

        return redirect()->route($this->route_prefix . 'index');
    }
}
