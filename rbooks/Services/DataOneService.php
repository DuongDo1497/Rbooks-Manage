<?php

namespace RBooks\Services;

use RBooks\Repositories\TranslateOneRepository;
use RBooks\Repositories\DetailTaskRepository;

use \Auth;
use DB;

class DataOneService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(TranslateOneRepository::class);
    }

    public function create($request)
    {
        $data = [
            'module_id' => 2,
            'division_id' => 2,
            'module_type' => 1,
            'taskname' => $request->taskname,
            'tasktype'=> $request->tasktype,
            'project'=> $request->project,
            'status'=> 1,
            'status_child' => 0,
            'progress'=> 0,
            'fromdate'=> $request->fromdate,
            'todate'=> $request->todate,
            'numday'=> $request->numday,
            'priority'=> $request->priority,
            'description'=> $request->description,
            'initialization_user_id'=>  Auth::user()->id,
            'created_user_id' => Auth::user()->id,
            'updated_user_id' => Auth::user()->id
        ];

        $task = $this->repository->create($data);
        return $task;
    }
}
