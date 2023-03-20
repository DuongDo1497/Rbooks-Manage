<?php

namespace RBooks\Services;

use RBooks\Repositories\TaskOneRepository;

use \Auth;
use DB;

class TransOtherService extends BaseService
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
            'module_type' => 10,
            'taskname' => $request->taskname,
            'tasktype'=> $request->tasktype,
            'project'=> $request->project,
            'status'=> 0,
            'status_child' => 0,
            'progress'=> 0,
            'fromdate'=> $request->fromdate,
            'todate'=> $request->todate,
            'numday'=> $numday + 1,
            'priority'=> $request->priority,
            'description' => $request->description,
            'note' => $request->note,
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
}
