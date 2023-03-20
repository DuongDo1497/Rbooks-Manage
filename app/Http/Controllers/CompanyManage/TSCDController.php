<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\TSCDService;
use \Auth;

class TSCDController extends Controller
{
    public function __construct(TSCDService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('company-manage.tscd.');
        $this->setRoutePrefix('tscds-');

        $this->view->tscds = app(TSCDService::class)->getAll();

        $this->view->setHeading('home.Quản lý tài sản cố định');
    }

    public function index(Request $request )
    {
        $this->view->collections = $this->main_service->getPaginate($this->view->filter['limit']);
        // Setup title
        $this->view->setSubHeading('home.Danh sách');
        if(Auth::user()->id == '235' || Auth::user()->employee()->first()->division()->first()->code_division == 'KETOAN' || Auth::user()->employee()->first()->division()->first()->code_division == 'DATA' || Auth::user()->employee()->first()->division()->first()->code_division == 'VANHANH' || Auth::user()->roles()->first()->name == 'owner'){
            return $this->view('index');
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập !!!.');
        }
    }

    public function store(Request $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {
        $tscd = $this->main_service->find($id);
        /*
         * Nếu trạng thái đang là tạo mới hoặc không được duyệt hoặc user đang ở quyền owner , admin thì mới được
         * phép chỉnh sửa thông tin
         */
        if(in_array($tscd->status, [1, 4]) || Auth::user()->hasRole(['owner', 'admin'])) {
            $this->view->tscd = $tscd;
            $this->view->setSubHeading('home.Chỉnh sửa');
            return $this->view('edit');
        }
        return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa !!!.');
    }

    public function update(Request $request, $id)
    {
        return $this->_update($request, $id);
    }

    public function delete($id)
    {
        $tscd = $this->main_service->find($id);
        /*
         * Nếu trạng thái đang là tạo mới hoặc không được duyệt hoặc user đang ở quyền owner , admin thì mới được
         * phép xóa tscd
         */
        if(in_array($tscd->status, [1, 4]) || Auth::user()->hasRole(['owner', 'admin'])) {
            $tscd->delete($id);
            return redirect()->route($this->route_prefix . 'index')
                   ->with(\App\Constants\NotificationMessage::DELETE_SUCCESS);
        }
        return redirect()->back()->with('error', 'Bạn không có quyền xóa !!!.');
    }
}
