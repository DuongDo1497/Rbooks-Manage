<?php

namespace App\Http\Controllers\TaskManage\TaskOne;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskOneStoreRequest;
use RBooks\Services\HrOneService;
use \Auth;

class HrOneController extends Controller
{
    public function __construct(HrOneService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('task-manage.taskones.hr.');
        $this->setRoutePrefix('task_ones-');

        $this->view->setHeading('Task-Manage');
    }

    public function index(Request $request)
    {   
        $this->view->collections = $this->main_service->getAll()->where('module_id', 7)->where('module_type', 1);
        // Setup title
        $this->view->setSubHeading('Lưu đồ 1');

        if(Auth::user()->employee()->first()->division()->first()->code_division == 'NHANSU' || Auth::user()->roles()->first()->name == 'owner') {
            return $this->view('index');
        }
        else {
            return redirect()->back()->with('success', 'Bạn không có quyền truy cập !!!.');
        }
    }

    public function store(TaskOneStoreRequest $request)
    {
        return $this->_store($request);
    }
}
