<?php

namespace RBooks\Services;

use RBooks\Repositories\TranslateOneRepository;
use RBooks\Repositories\DetailTaskRepository;
use RBooks\Repositories\TaskWaitReceiveRepository;
use RBooks\Services\TaskWaitReceiveService;

use \Auth;
use DB;

class DesignOneService extends BaseService
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

    // 10. CEO bàn giao Task
    public function CEOAssignDivision($request, $id)
    {   
        $task = $this->repository->find($id);
        $numday = (strtotime($request->todate) - strtotime($request->fromdate)) / (60 * 60 * 24);
        if($request->assign == 'it1') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority'=> $task->priority,
                'module_type' => 1,
                'module_id' => 4,
                'division_id' => 4,
                'status' => 0,
                'filter_status' => 0,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'numday' => $numday + 1,
                'note'=> $request->note,
                'roman_numerals' => 'IV',
            ];
            $waitReceive = app(TaskWaitReceiveRepository::class)->create($data);
            app(TaskWaitReceiveService::class)->createNew($waitReceive->id);

        } elseif($request->assign == 'sales1') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority'=> $task->priority,
                'module_type' => 1,
                'module_id' => 8,
                'division_id' => 8,
                'status' => 0,
                'filter_status' => 0,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'numday' => $numday + 1,
                'note'=> $request->note,
                'roman_numerals' => 'V',
            ];
            $waitReceive = app(TaskWaitReceiveRepository::class)->create($data);
            app(TaskWaitReceiveService::class)->SalesReceive($waitReceive->id);

        } elseif($request->assign == 'license1') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority'=> $task->priority,
                'module_type' => 1,
                'module_id' => 14,
                'division_id' => 9,
                'status' => 0,
                'filter_status' => 0,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'numday' => $numday + 1,
                'note'=> $request->note,
                'roman_numerals' => 'X',
            ];
            $waitReceive = app(TaskWaitReceiveRepository::class)->create($data);
            app(TaskWaitReceiveService::class)->createNew($waitReceive->id);
        }
        // Cập nhật trạng thái chuyển giao Task
        $assigned_status = [
            'assigned_status' => $request->status,
        ];
        return $this->repository->update($assigned_status, $id);
    }
}
