<?php

namespace RBooks\Services;

use RBooks\Repositories\TaskOneRepository;
use RBooks\Repositories\DetailTaskRepository;
use RBooks\Repositories\TaskWaitReceiveRepository;
use Carbon\Carbon;
use \Auth;
use DB;

class TaskOneService extends BaseService
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
        $task = $this->repository->find($id);
        $numday = (strtotime($request->todate) - strtotime($request->fromdate)) / (60 * 60 * 24);
        $data = [
            'taskname' => $request->taskname,
            'tasktype'=> $request->tasktype,
            'priority'=> $request->priority,
            'note' => $request->note,
            'fromdate'=> $request->fromdate,
            'todate'=> $request->todate,
            'numday'=> $numday + 1,
            'description' => $request->description,
            'updated_user_id' => Auth::user()->id
        ];

        $task = $this->repository->update($data, $id);
        return $task;
    }

    public function receiveTask($id)
    {
        $status = [
            'status' => 2,
            'filter_status' => 6,
        ];
        $this->repository->update($status, $id);
    }

    // Duyệt Task
    public function ApproveTask($request, $id)
    {
        $task = $this->repository->find($id);
        // Kiểm tra filter_status(đang làm) == 6 thì ko cập nhật
        if ($task->filter_status == 6) {
            $filter_status = 6;    
        } else {
            $filter_status = $request->status;
        }
        $data = [
            'status' => $request->status,
            'filter_status' => $filter_status,
            // 'note' => $request->note, ghi chú vì sao ko duyệt
        ];
        $task = $this->repository->update($data, $id);

        return $task;
    }

    // Leader báo cáo CEO (lưu đồ 2)
    public function ApproveTaskTwo($request, $id)
    {
        $task = $this->repository->find($id);
        $data = [
            'status' => $request->status,
        ];
        $task = $this->repository->update($data, $id);
        return $task;
    }

}
