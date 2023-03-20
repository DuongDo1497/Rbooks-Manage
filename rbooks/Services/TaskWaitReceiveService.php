<?php

namespace RBooks\Services;

use RBooks\Repositories\TaskWaitReceiveRepository;
use RBooks\Repositories\TaskOneRepository;
use RBooks\Repositories\DetailTaskRepository;
use RBooks\Models\DetailTask;
use \Auth;

class TaskWaitReceiveService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(TaskWaitReceiveRepository::class);
    }

    public function update($request, $id)
    {
        $taskWait = $this->repository->find($id);
        $numday = (strtotime($request->todate) - strtotime($request->fromdate)) / (60 * 60 * 24);
        $data = [
            'taskname' => $request->taskname,
            'tasktype' => $request->tasktype,
            'priority' => $request->priority,
            'fromdate' => $request->fromdate,
            'todate' => $request->todate,
            'numday' => $numday + 1,
            'description' => $request->description,
            'note' => $request->note,
        ];
        $this->repository->update($data, $id);
    }

    // Khởi tạo 1 Task
    public function createNew($id)
    {
        $taskWait = $this->repository->find($id);
        $numday = (strtotime($taskWait->todate) - strtotime($taskWait->fromdate)) / (60 * 60 * 24);

        $status = [
            'status' => 1,
            'filter_status' => 6,
        ];
        $this->repository->update($status, $id);

        $data = [
            'module_id' => $taskWait->module_id,
            'division_id' => $taskWait->division_id,
            'module_type' => $taskWait->module_type,
            'taskname' => $taskWait->taskname,
            'tasktype' => $taskWait->tasktype,
            'note' => $taskWait->note,
            'status' => 0,
            'filter_status' => 0,
            'progress' => 0,
            'fromdate' => $taskWait->fromdate,
            'todate' => $taskWait->todate,
            'numday' => $numday + 1,
            'priority' => $taskWait->priority,
            'description' => $taskWait->description,
            'roman_numerals' => $taskWait->roman_numerals,
            'initialization_user_id' => Auth::user()->id,
            'created_user_id' => Auth::user()->id,
            'updated_user_id' => Auth::user()->id,
        ];
        $task = app(TaskOneRepository::class)->create($data);
        //app(TaskOneService::class)->processTasks($task);
    }

    // Leader dàn trang nhận nhiều task chờ
    public function layoutAssign($id)
    {

        $taskWait = $this->repository->find($id);
        $numday = (strtotime($taskWait->todate) - strtotime($taskWait->fromdate)) / (60 * 60 * 24);

        $status = [
            'status' => 1,
            'filter_status' => 6,
        ];
        $this->repository->update($status, $id);

        // $ix_flag = false;
        // $xi_flag = false;
        // $iv_flag = false;
        // $taskWaits1 = app(TaskWaitReceiveRepository::class)->get()->where('module_id', 1)->where('status', 1);
        // foreach($taskWaits1 as $key => $value) {
        //     if($value->roman_numerals == "IX") {
        //         $ix_flag = true;
        //     }

        //     if($value->roman_numerals == "IX") {
        //         $xi_flag = true;
        //     }

        //     if($value->roman_numerals == "IV") {
        //         $iv_flag = true;
        //     }
        // }
        // dd($xi_flag == $ix_flag && $ix_flag == $iv_flag);

        $taskWaits1 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 1)->where('roman_numerals', 'XI')->where('status', 1)->count();

        $taskWaits2 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 1)->where('roman_numerals', 'IX')->where('status', 1)->count();

        if($taskWaits1 == $taskWaits2) {
            $data = [
                'module_id' => 12,
                'division_id' => 3,
                'module_type' => 1,
                'taskname' => $taskWait->taskname,
                'tasktype' => $taskWait->tasktype,
                'note' => $taskWait->note,
                'status' => 0,
                'filter_status' => 0,
                'progress' => 0,
                'fromdate' => $taskWait->fromdate,
                'todate' => $taskWait->todate,
                'numday' => $numday + 1,
                'priority' => $taskWait->priority,
                'description' => $taskWait->description,
                'roman_numerals' => 'IX + XI',
                'initialization_user_id' => Auth::user()->id,
                'created_user_id' => Auth::user()->id,
                'updated_user_id' => Auth::user()->id,
            ];
            $task = app(TaskOneRepository::class)->create($data);
            //app(TaskOneService::class)->processTasks($task);
        }
    }

    // leader biên dịch 2 nhận Task
    public function leadTranslateTwoReceive($id)
    {
        $taskWait = $this->repository->find($id);
        $numday = (strtotime($taskWait->todate) - strtotime($taskWait->fromdate)) / (60 * 60 * 24);

        $status = [
            'status' => 1,
            'filter_status' => 6,
        ];
        $this->repository->update($status, $id);

        $data = [
            'module_id' => $taskWait->module_id,
            'division_id' => $taskWait->division_id,
            'module_type' => $taskWait->module_type,
            'taskname' => $taskWait->taskname,
            'tasktype' => $taskWait->tasktype,
            'note' => $taskWait->note,
            'status' => 2,
            'filter_status' => 6,
            'progress' => 0,
            'fromdate' => $taskWait->fromdate,
            'todate' => $taskWait->todate,
            'numday' => $numday + 1,
            'priority' => $taskWait->priority,
            'description' => $taskWait->description,
            'roman_numerals' => $taskWait->roman_numerals,
            'initialization_user_id' => Auth::user()->id,
            'created_user_id' => Auth::user()->id,
            'updated_user_id' => Auth::user()->id,
        ];
        $task = app(TaskOneRepository::class)->create($data);
        //(TaskOneService::class)->processTasks($task);

        $data_child = [
            'taskid' => $task->id,
            'detailtaskname' => 'Editor sách',
            'status' => 2,
            'progress' => 0,
            'fromdate' => $task->fromdate,
            'todate' => $task->todate,
            'numday' => $numday + 1,
            'priority' => $taskWait->priority,
            'description' => '',
            'initialization_user_id' => 15,
            'created_user_id' => Auth::user()->id,
        ];
        app(DetailTaskRepository::class)->create($data_child);
    }

    // Leader nhận nhiều task chờ
    public function OperateReceive($id)
    {
        $key = 1;
        $taskWait = $this->repository->find($id);
        $numday = (strtotime($taskWait->todate) - strtotime($taskWait->fromdate)) / (60 * 60 * 24);

        $status = [
            'status' => 1,
        ];
        $this->repository->update($status, $id);

        // $taskWaits1 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 1)->where('roman_numerals', 'X')->where('status', 1);

        // $tempCount1 = $taskWaits1->count();

        $taskWaits2 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 1)->where('roman_numerals', 'XIII')->where('status', 1);

        $tempCount2 = $taskWaits2->count();

        $taskWaits3 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 1)->where('roman_numerals', 'XIV')->where('status', 1);

        $tempCount3 = $taskWaits3->count();

        if($tempCount2 == $tempCount3) {
            $data = [
                'module_id' => 9,
                'division_id' => 9,
                'module_type' => 1,
                'taskname' => $taskWait->taskname,
                'tasktype' => $taskWait->tasktype,
                'note' => $taskWait->note,
                'status' => 0,
                'filter_status' => 0,
                'progress' => 0,
                'fromdate' => $taskWait->fromdate,
                'todate' => $taskWait->todate,
                'numday' => $numday + 1,
                'priority' => $taskWait->priority,
                'description' => 'Bìa + Bảng bông + File đăng ký',
                'roman_numerals' => 'XIII + XIV',
                'initialization_user_id' => Auth::user()->id,
                'created_user_id' => Auth::user()->id,
                'updated_user_id' => Auth::user()->id,
            ];
            $task = app(TaskOneRepository::class)->create($data);

            $this->OperateTaskChild($key, $task, $numday); // add công việc nhỏ Vận hành
        }
    }

    // Leader operate rbooks nhận nhiều Task
    public function leadOperateRBReceive($id)
    {
        $key = 2;
        $taskWait = $this->repository->find($id);
        $numday = (strtotime($taskWait->todate) - strtotime($taskWait->fromdate)) / (60 * 60 * 24);

        $status = [
            'status' => 1,
        ];
        $this->repository->update($status, $id);

        $taskWaits1 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 16)->where('roman_numerals', 'XI')->where('status', 1);

        $tempCount1 = $taskWaits1->count();

        $taskWaits2 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 16)->where('roman_numerals', 'XII')->where('status', 1);

        $tempCount2 = $taskWaits2->count();

        if($tempCount1 == $tempCount2) {

            $data = [
                'module_id' => 9,
                'division_id' => 9,
                'module_type' => 16,
                'taskname' => $taskWait->taskname,
                'tasktype' => $taskWait->tasktype,
                'note' => $taskWait->note,
                'status' => 2,
                'filter_status' => 6,
                'progress' => 0,
                'fromdate' => $taskWait->fromdate,
                'todate' => $taskWait->todate,
                'numday' => $numday + 1,
                'priority' => $taskWait->priority,
                'description' => $taskWait->description,
                'roman_numerals' => 'XI + XII',
                'initialization_user_id' => Auth::user()->id,
                'created_user_id' => Auth::user()->id,
                'updated_user_id' => Auth::user()->id,
            ];

            $task = app(TaskOneRepository::class)->create($data);

            $this->OperateTaskChild($key, $task, $numday); // add công việc nhỏ Vận hành
        }
    }

    // add công việc nhỏ Vận hành
    public function OperateTaskChild($key, $task, $numday)
    {
        // Thêm task nhỏ
        $tasknames1 = ['Gửi file CEO', 'Gửi file + bảng bông cho NXB', 'Thực hiện đăng ký GPXB', 'Hoàn thành GPXB', 'Scan + Sao y công chứng GPXB'];

        $tasknames2 = ['Làm file đăng ký đề tài GPXB', 'Gửi file CEO', 'Gửi file + bảng bông cho NXB', 'Thực hiện đăng ký GPXB', 'Hoàn thành GPXB', 'Scan + Sao y công chứng GPXB'];
        if($key == 1) {
            foreach($tasknames1 as $taskname) {

                $data_child = [
                    'taskid' => $task->id,
                    'detailtaskname' => $taskname,
                    'status' => 8,
                    'progress' => 0,
                    'fromdate' => $task->fromdate,
                    'todate' => $task->todate,
                    'numday' => $numday + 1,
                    'priority' => 1,
                    'description' => $task->description,
                    'initialization_user_id' => 1,
                    'created_user_id' => Auth::user()->id,
                ];
                app(DetailTaskRepository::class)->create($data_child);
            }
        } else {
            foreach($tasknames2 as $taskname) {

                $data_child = [
                    'taskid' => $task->id,
                    'detailtaskname' => $taskname,
                    'status' => 8,
                    'progress' => 0,
                    'fromdate' => $task->fromdate,
                    'todate' => $task->todate,
                    'numday' => $numday + 1,
                    'priority' => 1,
                    'description' => $task->description,
                    'initialization_user_id' => 1,
                    'created_user_id' => Auth::user()->id,
                ];
                app(DetailTaskRepository::class)->create($data_child);
            }
        }
        
        return $task;
    }

    // Leader Sales1 nhận nhiều task chờ
    public function SalesReceive($id)
    {
        $taskWait = $this->repository->find($id);
        $numday = (strtotime($taskWait->todate) - strtotime($taskWait->fromdate)) / (60 * 60 * 24);

        $status = [
            'status' => 1,
        ];
        $this->repository->update($status, $id);

        $taskWaits1 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 1)->where('roman_numerals', 'V')->where('status', 1); // Design 1 phân công

        $tempCount1 = $taskWaits1->count();

        $taskWaits2 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 1)->where('roman_numerals', 'VI')->where('status', 1); // Mkt 1 phân công

        $tempCount2 = $taskWaits2->count();

        $taskWaits3 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 1)->where('roman_numerals', 'XXI')->where('status', 1);

        $tempCount3 = $taskWaits3->count();

        if($tempCount1 == $tempCount2 && $tempCount2 == $tempCount3) {
            $data = [
                'module_id' => 8,
                'division_id' => 8,
                'module_type' => 1,
                'taskname' => $taskWait->taskname,
                'tasktype' => $taskWait->tasktype,
                'note' => $taskWait->note,
                'status' => 2,
                'filter_status' => 6,
                'progress' => 0,
                'fromdate' => $taskWait->fromdate,
                'todate' => $taskWait->todate,
                'numday' => $numday + 1,
                'priority' => $taskWait->priority,
                'description' => $taskWait->description,
                'roman_numerals' => 'V + VI + XXI',
                'initialization_user_id' => Auth::user()->id,
                'created_user_id' => Auth::user()->id,
                'updated_user_id' => Auth::user()->id,
            ];
            $task = app(TaskOneRepository::class)->create($data);
            //app(TaskOneService::class)->processTasks($task);
        }
    }
    
    // Leader in ấn nhận nhiều task chờ (ld dịch TA)
    public function stepPrintReceive($id)
    {
        $taskWait = $this->repository->find($id);
        $numday = (strtotime($taskWait->todate) - strtotime($taskWait->fromdate)) / (60 * 60 * 24);

        $status = [
            'status' => 1,
        ];
        $this->repository->update($status, $id);

        $taskWaits1 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 1)->where('roman_numerals', 'XIX')->where('status', 1);

        $tempCount1 = $taskWaits1->count();

        $taskWaits2 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 1)->where('roman_numerals', 'XX')->where('status', 1); // deisgn 2 phan công

        $tempCount2 = $taskWaits2->count();

        if($tempCount1 == $tempCount2) {
            $data = [
                'module_id' => 13,
                'division_id' => 3,
                'module_type' => 1,
                'taskname' => $taskWait->taskname,
                'tasktype' => $taskWait->tasktype,
                'note' => $taskWait->note,
                'status' => 2,
                'filter_status' => 6,
                'progress' => 0,
                'fromdate' => $taskWait->fromdate,
                'todate' => $taskWait->todate,
                'numday' => $numday + 1,
                'priority' => $taskWait->priority,
                'description' => $taskWait->description,
                'roman_numerals' => 'XIX + XX',
                'initialization_user_id' => Auth::user()->id,
                'created_user_id' => Auth::user()->id,
                'updated_user_id' => Auth::user()->id,
            ];
            $task = app(TaskOneRepository::class)->create($data);
            //app(TaskOneService::class)->processTasks($task);
        }
    }

    // Leader marketing2 nhận nhiều task chờ (LĐ dịch sách TA)
    public function Markt2Receive($id)
    {
        $taskWait = $this->repository->find($id);
        $numday = (strtotime($taskWait->todate) - strtotime($taskWait->fromdate)) / (60 * 60 * 24);

        $status = [
            'status' => 1,
        ];
        $this->repository->update($status, $id);

        $taskWaits1 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 2)->where('roman_numerals', 'VII')->where('status', 1); // mkt 1 phân công

        $tempCount1 = $taskWaits1->count();

        $taskWaits2 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 2)->where('roman_numerals', 'XXII')->where('status', 1); // design 2 phân công

        $tempCount2 = $taskWaits2->count();

        if($tempCount1 == $tempCount2) {
            $data = [
                'module_id' => 6,
                'division_id' => 6,
                'module_type' => 2,
                'taskname' => $taskWait->taskname,
                'tasktype' => $taskWait->tasktype,
                'note' => $taskWait->note,
                'status' => 2,
                'filter_status' => 6,
                'progress' => 0,
                'fromdate' => $taskWait->fromdate,
                'todate' => $taskWait->todate,
                'numday' => $numday + 1,
                'priority' => $taskWait->priority,
                'description' => $taskWait->description,
                'roman_numerals' => 'VII' . ' + ' . 'XXII',
                'initialization_user_id' => Auth::user()->id,
                'created_user_id' => Auth::user()->id,
                'updated_user_id' => Auth::user()->id,
            ];
            $task = app(TaskOneRepository::class)->create($data);
        }
    }

    // Leader it_project_rb2 nhận nhiều Task
    public function leadITRB2Receive($id)
    {
        $taskWait = $this->repository->find($id);
        $numday = (strtotime($taskWait->todate) - strtotime($taskWait->fromdate)) / (60 * 60 * 24);

        $status = [
            'status' => 1,
        ];
        $this->repository->update($status, $id);

        $taskWaits1 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 12)->where('roman_numerals', 'III')->where('status', 1);

        $tempCount1 = $taskWaits1->count();

        $taskWaits2 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 12)->where('roman_numerals', 'IV')->where('status', 1);

        $tempCount2 = $taskWaits2->count();

        if($tempCount1 == $tempCount2) {
            $data = [
                'module_id' => 4,
                'division_id' => 4,
                'module_type' => 12,
                'taskname' => $taskWait->taskname,
                'tasktype' => $taskWait->tasktype,
                'note' => $taskWait->note,
                'status' => 2,
                'filter_status' => 6,
                'progress' => 0,
                'fromdate' => $taskWait->fromdate,
                'todate' => $taskWait->todate,
                'numday' => $numday + 1,
                'priority' => $taskWait->priority,
                'description' => $taskWait->description,
                'roman_numerals' => 'III + IV',
                'initialization_user_id' => Auth::user()->id,
                'created_user_id' => Auth::user()->id,
                'updated_user_id' => Auth::user()->id,
            ];
            $task = app(TaskOneRepository::class)->create($data);
        }
    }

    // Leader In ấn Sách Writing Rbooks nhận nhiều Task
    public function printCreateSachRB($id)
    {
        $taskWait = $this->repository->find($id);
        $numday = (strtotime($taskWait->todate) - strtotime($taskWait->fromdate)) / (60 * 60 * 24);

        $status = [
            'status' => 1,
        ];
        $this->repository->update($status, $id);

        $taskWaits1 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 16)->where('roman_numerals', 'XVIII')->where('status', 1);

        $tempCount1 = $taskWaits1->count(); // writting 3 viết sách rb

        $taskWaits2 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 16)->where('roman_numerals', 'XIX')->where('status', 1);

        $tempCount2 = $taskWaits2->count();

        if($tempCount1 == $tempCount2) {

            $data = [
                'module_id' => 13,
                'division_id' => 13,
                'module_type' => 16,
                'taskname' => $taskWait->taskname,
                'tasktype' => $taskWait->tasktype,
                'note' => $taskWait->note,
                'status' => 2,
                'filter_status' => 6,
                'progress' => 0,
                'fromdate' => $taskWait->fromdate,
                'todate' => $taskWait->todate,
                'numday' => $numday + 1,
                'priority' => $taskWait->priority,
                'description' => $taskWait->description,
                'roman_numerals' => 'XVIII + XIX',
                'initialization_user_id' => Auth::user()->id,
                'created_user_id' => Auth::user()->id,
                'updated_user_id' => Auth::user()->id,
            ];

            $task = app(TaskOneRepository::class)->create($data);
        }
    }

    // leader marketing nhận Task sách writing rbooks
    public function mktCreateSachRB($id)
    {
        $taskWait = $this->repository->find($id);
        $numday = (strtotime($taskWait->todate) - strtotime($taskWait->fromdate)) / (60 * 60 * 24);

        $status = [
            'status' => 1,
        ];
        $this->repository->update($status, $id);

        $taskWaits1 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 17)->where('roman_numerals', 'VII')->where('status', 1);

        $tempCount1 = $taskWaits1->count();

        $taskWaits2 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 17)->where('roman_numerals', 'XXI')->where('status', 1);

        $tempCount2 = $taskWaits2->count();

        if($tempCount1 == $tempCount2) {

            $data = [
                'module_id' => 6,
                'division_id' => 6,
                'module_type' => 17,
                'taskname' => $taskWait->taskname,
                'tasktype' => $taskWait->tasktype,
                'note' => $taskWait->note,
                'status' => 2,
                'filter_status' => 6,
                'progress' => 0,
                'fromdate' => $taskWait->fromdate,
                'todate' => $taskWait->todate,
                'numday' => $numday + 1,
                'priority' => $taskWait->priority,
                'description' => $taskWait->description,
                'roman_numerals' => 'VII + XXI',
                'initialization_user_id' => Auth::user()->id,
                'created_user_id' => Auth::user()->id,
                'updated_user_id' => Auth::user()->id,
            ];

            $task = app(TaskOneRepository::class)->create($data);
        }
    }

    // Leader dàn trang dịch TV->TA nhận Task
    public function layoutCreateTVTA($id)
    {
        $taskWait = $this->repository->find($id);
        $numday = (strtotime($taskWait->todate) - strtotime($taskWait->fromdate)) / (60 * 60 * 24);

        $status = [
            'status' => 1,
        ];
        $this->repository->update($status, $id);

        $taskWaits1 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 20)->where('roman_numerals', 'III')->where('status', 1);

        $tempCount1 = $taskWaits1->count();

        $taskWaits2 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 20)->where('roman_numerals', 'IV')->where('status', 1);

        $tempCount2 = $taskWaits2->count();

        if($tempCount1 == $tempCount2) {

            $data = [
                'module_id' => 12,
                'division_id' => 12,
                'module_type' => 20,
                'taskname' => $taskWait->taskname,
                'tasktype' => $taskWait->tasktype,
                'note' => $taskWait->note,
                'status' => 2,
                'filter_status' => 6,
                'progress' => 0,
                'fromdate' => $taskWait->fromdate,
                'todate' => $taskWait->todate,
                'numday' => $numday + 1,
                'priority' => $taskWait->priority,
                'description' => $taskWait->description,
                'roman_numerals' => 'III + IV',
                'initialization_user_id' => Auth::user()->id,
                'created_user_id' => Auth::user()->id,
                'updated_user_id' => Auth::user()->id,
            ];

            $task = app(TaskOneRepository::class)->create($data);
        }
    }
    // Event mkt
    // Khởi tạo công việc phòng kế toán (Event mkt)
    public function accountCreateEventMkt($id)
    {
        $taskWait = $this->repository->find($id);
        $numday = (strtotime($taskWait->todate) - strtotime($taskWait->fromdate)) / (60 * 60 * 24);

        $status = [
            'status' => 1,
        ];
        $this->repository->update($status, $id);

        $taskWaits1 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 13)->where('roman_numerals', 'III')->where('status', 1)->count();
        $taskWaits2 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 13)->where('roman_numerals', 'V')->where('status', 1)->count();

        if($taskWaits1 == $taskWaits2) {

            $data = [
                'module_id' => 5,
                'division_id' => 5,
                'module_type' => 13,
                'taskname' => $taskWait->taskname,
                'tasktype' => $taskWait->tasktype,
                'note' => $taskWait->note,
                'status' => 2,
                'filter_status' => 6,
                'progress' => 0,
                'fromdate' => $taskWait->fromdate,
                'todate' => $taskWait->todate,
                'numday' => $numday + 1,
                'priority' => $taskWait->priority,
                'description' => $taskWait->description,
                'roman_numerals' => 'III + V',
                'initialization_user_id' => Auth::user()->id,
                'created_user_id' => Auth::user()->id,
                'updated_user_id' => Auth::user()->id,
            ];

            $task = app(TaskOneRepository::class)->create($data);
        }
    }
    // Project IT
    // Khởi tạo công việc phòng kế toán (Event mkt)
    public function itCreateProjectIT($id)
    {
        $taskWait = $this->repository->find($id);
        $numday = (strtotime($taskWait->todate) - strtotime($taskWait->fromdate)) / (60 * 60 * 24);

        $status = [
            'status' => 1,
        ];
        $this->repository->update($status, $id);

        $taskWaits1 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 12)->where('roman_numerals', 'III')->where('status', 1)->count();
        $taskWaits2 = app(TaskWaitReceiveRepository::class)->get()->where('taskname', $taskWait->taskname)->where('module_type', 12)->where('roman_numerals', 'IV')->where('status', 1)->count();

        if($taskWaits1 == $taskWaits2) {

            $data = [
                'module_id' => 4,
                'division_id' => 4,
                'module_type' => 12,
                'taskname' => $taskWait->taskname,
                'tasktype' => $taskWait->tasktype,
                'note' => $taskWait->note,
                'status' => 2,
                'filter_status' => 6,
                'progress' => 0,
                'fromdate' => $taskWait->fromdate,
                'todate' => $taskWait->todate,
                'numday' => $numday + 1,
                'priority' => $taskWait->priority,
                'description' => $taskWait->description,
                'roman_numerals' => 'III + IV',
                'initialization_user_id' => Auth::user()->id,
                'created_user_id' => Auth::user()->id,
                'updated_user_id' => Auth::user()->id,
            ];

            $task = app(TaskOneRepository::class)->create($data);
        }
    }
}
