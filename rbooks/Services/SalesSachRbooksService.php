<?php

namespace RBooks\Services;

use RBooks\Repositories\TaskOneRepository;

use \Auth;
use DB;

class SalesSachRbooksService extends BaseService
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
        $sales = $this->repository->find($id);
        $data = [
            'taskname' => $request->taskname,
            'tasktype'=> $request->tasktype,
            'project'=> $request->project,
            'fromdate'=> $request->fromdate,
            'todate'=> $request->todate,
            'numday'=> $request->numday,
            'description'=> $request->description,
            'updated_user_id' => Auth::user()->id
        ];

        $sales = $this->repository->update($data, $id);
        return $sales;
    }
}
