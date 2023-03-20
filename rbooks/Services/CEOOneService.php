<?php

namespace RBooks\Services;

use RBooks\Repositories\TaskOneRepository;
use RBooks\Repositories\TaskWaitReceiveRepository;
use RBooks\Services\TaskWaitReceiveService;

use \Auth;
use DB;

class CEOOneService extends BaseService
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

    // CEO phân công Task
    public function CEOAssignDivision($request, $id)
    {   
        $task = $this->repository->find($id);

        $numday = (strtotime($request->todate) - strtotime($request->fromdate)) / (60 * 60 * 24);
        if($request->assign == 'layout1') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority'=> $task->priority,
                'module_type' => 1,
                'module_id' => 12,
                'division_id' => 12,
                'status' => 0,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'numday' => $numday + 1,
                'note'=> $request->note,
                'roman_numerals' => 'IX',
            ];
            $waitReceive = app(TaskWaitReceiveRepository::class)->create($data);
            app(TaskWaitReceiveService::class)->layoutAssign($waitReceive->id);
            // Cập nhật trạng thái chuyển giao Task
        }
        $assigned_status = [
            'assigned_status' => $request->status,
        ];
        return $this->repository->update($assigned_status, $id);
    }
}
