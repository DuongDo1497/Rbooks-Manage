<?php

namespace RBooks\Services;

use RBooks\Repositories\TaskOneRepository;
use RBooks\Repositories\TaskWaitReceiveRepository;
use RBooks\Services\TaskWaitReceiveService;
use \Auth;
use DB;

class LayoutSachRb2Service extends BaseService
{
    public function __construct()
    {
        $this->repository = app(TaskOneRepository::class);
    }

    public function create($request)
    {

    }

    public function update($request, $id)
    {

    }

    // 9. CEO bàn giao Task
    public function CEOAssignDivision($request, $id)
    {   
        $task = $this->repository->find($id);

        $numday = (strtotime($request->todate) - strtotime($request->fromdate)) / (60 * 60 * 24);
        if($request->assign == 'writing_rbooks3') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority'=> $task->priority,
                'module_type' => 18,
                'module_id' => 10,
                'division_id' => 10,
                'status' => 0,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'numday' => $numday + 1,
                'note'=> $request->note,
                'roman_numerals' => 'XVII',
            ];
            $waitReceive = app(TaskWaitReceiveRepository::class)->create($data);
        }
        // Khởi tạo task chuyển giao
        app(TaskWaitReceiveService::class)->createNew($waitReceive->id);
        // Cập nhật trạng thái chuyển giao Task
        $assigned_status = [
            'assigned_status' => $request->status,
        ];
        return $this->repository->update($assigned_status, $id);
    }
}
