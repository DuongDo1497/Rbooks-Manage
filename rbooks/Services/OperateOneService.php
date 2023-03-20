<?php

namespace RBooks\Services;

use RBooks\Repositories\TranslateOneRepository;
use RBooks\Repositories\TaskWaitReceiveRepository;
use RBooks\Services\TaskWaitReceiveService;

use \Auth;
use DB;

class OperateOneService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(TranslateOneRepository::class);
    }

    public function create($request)
    {

    }

    public function update($request, $id)
    {

    }

    // 7. CEO bàn giao Task
    public function CEOAssignDivision($request, $id)
    {   
        $task = $this->repository->find($id);
        $numday = (strtotime($request->todate) - strtotime($request->fromdate)) / (60 * 60 * 24);
        if($request->assign == 'it2') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority'=> $task->priority,
                'module_type' => 2,
                'module_id' => 4,
                'division_id' => 4,
                'status' => 0,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'numday' => $numday + 1,
                'note'=> $request->note,
                'roman_numerals' => 'XVI',
            ];
            $waitReceive = app(TaskWaitReceiveRepository::class)->create($data);

        } elseif($request->assign == 'account1') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority'=> $task->priority,
                'module_type' => 1,
                'module_id' => 5,
                'division_id' => 5,
                'status' => 0,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'numday' => $numday + 1,
                'note'=> $request->note,
                'roman_numerals' => 'XV',
            ];
            $waitReceive = app(TaskWaitReceiveRepository::class)->create($data);

        } elseif($request->assign == 'layout2') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority'=> $task->priority,
                'module_type' => 2,
                'module_id' => 12,
                'division_id' => 3,
                'status' => 0,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'numday' => $numday + 1,
                'note'=> $request->note,
                'roman_numerals' => 'XVII',
            ];
            $waitReceive = app(TaskWaitReceiveRepository::class)->create($data);

        }

        // Chuyển giao công việc
        app(TaskWaitReceiveService::class)->createNew($waitReceive->id);
        // Cập nhật trạng thái chuyển giao Task
        $assigned_status = [
            'assigned_status' => $request->status,
        ];
        return $this->repository->update($assigned_status, $id);
    }
}
