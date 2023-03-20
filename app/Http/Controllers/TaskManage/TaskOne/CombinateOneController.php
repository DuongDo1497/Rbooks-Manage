<?php

namespace App\Http\Controllers\TaskManage\TaskOne;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskOneStoreRequest;
use RBooks\Services\CombinateOneService;
use \Auth;

class CombinateOneController extends Controller
{
    public function __construct(CombinateOneService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('task-manage.taskones.combinate.');
        $this->setRoutePrefix('task_ones-');

        $this->view->setHeading('Task-Manage');
    }

    public function index(Request $request)
    {   
        $this->view->collections = $this->main_service->getAll()->where('module_id', 23)->where('module_type', 1);
        // Setup title
        $this->view->setSubHeading('Lưu đồ 1');

        return $this->view('index');
    }

    public function store(TaskOneStoreRequest $request)
    {
        return $this->_store($request);
    }
}
