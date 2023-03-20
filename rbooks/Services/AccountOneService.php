<?php

namespace RBooks\Services;

use RBooks\Repositories\TaskOneRepository;
use RBooks\Repositories\DetailTaskRepository;

use \Auth;
use DB;

class AccountOneService extends BaseService
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
        $numday = (strtotime($request->todate) - strtotime($request->fromdate)) / (60 * 60 * 24);
        $account = $this->repository->find($id);
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

        $account = $this->repository->update($data, $id);
        return $account;
    }
}
