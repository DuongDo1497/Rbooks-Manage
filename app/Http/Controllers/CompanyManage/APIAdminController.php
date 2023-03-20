<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\APIAdminService;

class APIAdminController extends Controller
{
    public function __construct(APIAdminService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('company-manage.apiadmin.');
        $this->setRoutePrefix('apiadmin-');
        
        $this->view->setHeading('Phê duyệt');
        $this->view->setSubHeading('Chi tiết');        
    }

    public function index(Request $request)
    {
        $this->view->setHeading('Phê duyệt');
        return $this->view('index');        
    }

    public function approvecheckemployee(Request $request)
    {
        $ret = $this->main_service->approvecheckemployee($request);

        if ($ret['status'] == 0){
            $message = "Yêu cầu này đã được phê duyệt rồi !";
        }elseif ($ret['status'] == 1){
            $message = "Yêu cầu đã được duyệt thành công !";                   
        }

        $this->view->infor = $message;        
        $this->view->employeename = $ret['employeename'];        

        return $this->view('message');        
    }  

    public function rejectcheckemployee(Request $request)
    {
        $ret = $this->main_service->rejectcheckemployee($request);

        if ($ret['status'] == 0){
            $message = "Yêu cầu này đã được phê duyệt rồi !";
        }elseif ($ret['status'] == 1){
            $message = "Yêu cầu đã từ chối phê duyệt thành công !";                   
        }

        $this->view->infor = $message;        
        $this->view->employeename = $ret['employeename'];        

        return $this->view('message');  
    }

    public function access()
    {
        $this->view->leftmenu = app(APIAdminService::class)->setLeftMenu();

        $message = "Thiết lập bảo mật truy cập hệ thống, bạn không được phép truy cập chức năng này !";
        $this->view->infor = $message;        
        $this->view->setHeading('Thông báo hệ thống');

        return $this->view('access');  
    }    
}
