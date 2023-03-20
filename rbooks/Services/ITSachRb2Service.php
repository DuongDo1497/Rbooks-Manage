<?php

namespace RBooks\Services;

use RBooks\Repositories\TaskOneRepository;
use RBooks\Repositories\TaskWaitReceiveRepository;
use RBooks\Services\TaskWaitReceiveService;
use \Auth;
use DB;

class ITSachRb2Service extends BaseService
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
        $writing = $this->repository->find($id);
        $data = [
            'taskname' => $request->taskname,
            'tasktype'=> $request->tasktype,
            'project'=> $request->project,
            'fromdate'=> $request->fromdate,
            'todate'=> $request->todate,
            'numday'=> $request->numday,
            'description'=> $request->description,
            'updated_user_id' => Auth::user()->id
        ];

        $writing = $this->repository->update($data, $id);
        return $writing;
    }

    // 9. CEO bàn giao Task
    public function CEOAssignDivision($request, $id)
    {   
        $task = $this->repository->find($id);

        $numday = (strtotime($request->todate) - strtotime($request->fromdate)) / (60 * 60 * 24);
        if($request->assign == 'design_rbooks2') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority'=> $task->priority,
                'module_type' => 17,
                'module_id' => 3,
                'division_id' => 3,
                'status' => 0,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'numday' => $numday + 1,
                'note'=> $request->note,
                'roman_numerals' => 'XVI',
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
