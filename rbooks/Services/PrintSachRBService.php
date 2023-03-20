<?php

namespace RBooks\Services;

use RBooks\Repositories\TaskOneRepository;
use RBooks\Repositories\TaskWaitReceiveRepository;
use RBooks\Services\TaskWaitReceiveService;
use \Auth;
use DB;

class PrintSachRBService extends BaseService
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

    // 10. CEO bàn giao Task
    public function CEOAssignDivision($request, $id)
    {   
        $task = $this->repository->find($id);

        $numday = (strtotime($request->todate) - strtotime($request->fromdate)) / (60 * 60 * 24);
        if($request->assign == 'account_rbooks2') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority'=> $task->priority,
                'module_type' => 17,
                'module_id' => 5,
                'division_id' => 5,
                'status' => 0,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'numday' => $numday + 1,
                'note'=> $request->note,
                'roman_numerals' => 'XXIII',
            ];
            $waitReceive = app(TaskWaitReceiveRepository::class)->create($data);

        } elseif($request->assign == 'warehouse_rbooks1') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority'=> $task->priority,
                'module_type' => 16,
                'module_id' => 17,
                'division_id' => 17,
                'status' => 0,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'numday' => $numday + 1,
                'note'=> $request->note,
                'roman_numerals' => 'XXIV',
            ];
            $waitReceive = app(TaskWaitReceiveRepository::class)->create($data);

        } elseif($request->assign == 'operate_rbooks2') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority'=> $task->priority,
                'module_type' => 17,
                'module_id' => 9,
                'division_id' => 9,
                'status' => 0,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'numday' => $numday + 1,
                'note'=> $request->note,
                'roman_numerals' => 'XXV',
            ];
            $waitReceive = app(TaskWaitReceiveRepository::class)->create($data);

        } elseif($request->assign == 'sales_rbooks2') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority'=> $task->priority,
                'module_type' => 17,
                'module_id' => 8,
                'division_id' => 8,
                'status' => 0,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'numday' => $numday + 1,
                'note'=> $request->note,
                'roman_numerals' => 'XXVI',
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
