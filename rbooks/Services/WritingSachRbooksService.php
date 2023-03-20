<?php

namespace RBooks\Services;

use RBooks\Repositories\TaskOneRepository;
use RBooks\Repositories\TaskWaitReceiveRepository;
use RBooks\Services\TaskWaitReceiveService;
use \Auth;
use DB;

class WritingSachRbooksService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(TaskOneRepository::class);
    }

    public function create($request)
    {
        $numday = (strtotime($request->todate) - strtotime($request->fromdate)) / (60 * 60 * 24);

        $data = [
            'module_id' => 10,
            'division_id' => 10,
            'module_type' => 16,
            'taskname' => $request->taskname,
            'tasktype' => $request->tasktype,
            'note' => $request->note,
            'status' => 0,
            'filter_status' => 0,
            'progress' => 0,
            'fromdate' => $request->fromdate,
            'todate' => $request->todate,
            'numday' => $numday + 1,
            'priority' => $request->priority,
            'description' => $request->description,
            'initialization_user_id' =>  Auth::user()->id,
            'created_user_id' => Auth::user()->id,
            'updated_user_id' => Auth::user()->id
        ];
        $task = $this->repository->create($data);
        return $task;
    }

    public function update($request, $id)
    {

    }

    // CEO phân công Task
    public function CEOAssignDivision($request, $id)
    {   
        $task = $this->repository->find($id);

        $numday = (strtotime($request->todate) - strtotime($request->fromdate)) / (60 * 60 * 24);
        if($request->assign == 'design_rbooks1') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority'=> $task->priority,
                'module_type' => 16,
                'module_id' => 3,
                'division_id' => 3,
                'status' => 0,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'numday' => $numday + 1,
                'note'=> $request->note,
                'roman_numerals' => 'I',
            ];
            $waitReceive = app(TaskWaitReceiveRepository::class)->create($data);

        } elseif($request->assign == 'mkt_rbooks1') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority'=> $task->priority,
                'module_type' => 16,
                'module_id' => 6,
                'division_id' => 6,
                'status' => 0,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'numday' => $numday + 1,
                'note'=> $request->note,
                'roman_numerals' => 'II',
            ];
            $waitReceive = app(TaskWaitReceiveRepository::class)->create($data);

        } elseif($request->assign == 'ceo_rbooks1') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority'=> $task->priority,
                'module_type' => 16,
                'module_id' => 16,
                'division_id' => 16,
                'status' => 0,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'numday' => $numday + 1,
                'note'=> $request->note,
                'roman_numerals' => 'III',
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
