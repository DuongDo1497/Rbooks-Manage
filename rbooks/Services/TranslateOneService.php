<?php

namespace RBooks\Services;

use RBooks\Repositories\TaskOneRepository;
use RBooks\Repositories\DetailTaskRepository;
use RBooks\Repositories\TaskWaitReceiveRepository;
use RBooks\Services\TaskWaitReceiveService;

use \Auth;
use DB;

class TranslateOneService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(TaskOneRepository::class);
    }

    public function create($request)
    {
        $numday = (strtotime($request->todate) - strtotime($request->fromdate)) / (60 * 60 * 24);

        $data = [
            'module_id' => 11,
            'division_id' => 11,
            'module_type' => 1,
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
        $numday = (strtotime($request->todate) - strtotime($request->fromdate)) / (60 * 60 * 24);
        $translate = $this->repository->find($id);
        $data = [
            'taskname' => $request->taskname,
            'tasktype'=> $request->tasktype,
            'note'=> $request->note,
            'fromdate'=> $request->fromdate,
            'todate'=> $request->todate,
            'numday'=> $numday + 1,
            'priority'=> $request->priority,
            'description'=> $request->description,
            'updated_user_id' => Auth::user()->id
        ];

        $translate = $this->repository->update($data, $id);
        return $translate;
    }

    // CEO phân công Task
    public function CEOAssignDivision($request, $id)
    {   
        $task = $this->repository->find($id);
        $numday = (strtotime($request->todate) - strtotime($request->fromdate)) / (60 * 60 * 24);
        if($request->assign == 'design1') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority'=> $task->priority,
                'module_type' => 1,
                'module_id' => 3,
                'division_id' => 3,
                'status' => 0,
                'filter_status' => 0,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'numday' => $numday + 1,
                'note' => $request->note,
                'roman_numerals' => 'I',
            ];
            $waitReceive = app(TaskWaitReceiveRepository::class)->create($data);
            app(TaskWaitReceiveService::class)->createNew($waitReceive->id);

        } elseif($request->assign == 'translate2') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority' => $task->priority,
                'module_type' => 2,
                'module_id' => 11,
                'division_id' => 11,
                'status' => 0,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'numday' => $numday + 1,
                'note'=> $request->note,
                'roman_numerals' => 'III',
            ];
            $waitReceive = app(TaskWaitReceiveRepository::class)->create($data);
            app(TaskWaitReceiveService::class)->leadTranslateTwoReceive($waitReceive->id);

        } elseif($request->assign == 'marketing1') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority'=> $task->priority,
                'module_type' => 1,
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
            app(TaskWaitReceiveService::class)->createNew($waitReceive->id);
        }

        // Cập nhật trạng thái chuyển giao Task
        $assigned_status = [
            'assigned_status' => $request->status,
        ];
        return $this->repository->update($assigned_status, $id);
    }
}
