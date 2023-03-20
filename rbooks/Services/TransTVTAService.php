<?php

namespace RBooks\Services;

use RBooks\Repositories\TaskOneRepository;
use RBooks\Repositories\TaskWaitReceiveRepository;
use RBooks\Services\TaskWaitReceiveService;
use \Auth;
use DB;

class TransTVTAService extends BaseService
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
            'module_type' => 20,
            'taskname' => $request->taskname,
            'tasktype'=> $request->tasktype,
            'project'=> $request->project,
            'status'=> 0,
            'filter_status' => 0,
            'progress'=> 0,
            'fromdate'=> $request->fromdate,
            'todate'=> $request->todate,
            'numday'=> $numday + 1,
            'priority'=> $request->priority,
            'description'=> $request->description,
            'initialization_user_id'=>  Auth::user()->id,
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
        if($request->assign == 'trans_tvta2') {
            $data = [
                'taskname' => $task->taskname,
                'tasktype' => $task->tasktype,
                'description' => $task->description,
                'priority' => $task->priority,
                'module_type' => 21,
                'module_id' => 11,
                'division_id' => 11,
                'status' => 0,
                'filter_status' => 0,
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'numday' => $numday + 1,
                'note' => $request->note,
                'roman_numerals' => 'I',
            ];
            $waitReceive = app(TaskWaitReceiveRepository::class)->create($data);
        }
        // Khởi tạo công việc
        app(TaskWaitReceiveService::class)->createNew($waitReceive->id);
        // Cập nhật trạng thái chuyển giao Task
        $assigned_status = [
            'assigned_status' => $request->status,
        ];
        return $this->repository->update($assigned_status, $id);
    }
}
