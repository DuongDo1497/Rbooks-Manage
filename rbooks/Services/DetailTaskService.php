<?php

namespace RBooks\Services;

use RBooks\Repositories\DetailTaskRepository;
use RBooks\Repositories\TaskOneRepository;
use RBooks\Repositories\DetailTaskRPRepository;
use Carbon\Carbon;
use Auth;

class DetailTaskService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(DetailTaskRepository::class);
    }

    // Lead Khởi tạo task nhỏ và gắn User
    public function storeDetailTask($request, $id)
    {   
        $numday = (strtotime($request->todate) - strtotime($request->fromdate)) / (60 * 60 * 24);

        $task_parent = app(TaskOneRepository::class)->find($id);

        $data = [
            'taskid' => $task_parent->id,
            'detailtaskname' => $request->detailtaskname,
            'status' => 8,
            'progress' => 0,
            'fromdate' => $request->fromdate,
            'todate' => $request->todate,
            'numday' => $numday + 1,
            'priority' => $request->priority,
            'description' => $request->description,
            'initialization_user_id' => $request->initialization_user_id,
            'created_user_id' => Auth::user()->id,
        ];

        $progresstaskChild = $this->repository->create($data);
        $this->updateProgressTaskParent($progresstaskChild);

        return $progresstaskChild;
    }

    // Lead Khởi tạo task nhỏ và gắn User
    public function store($request)
    {

    }

    // Chỉnh sửa task nhỏ, Báo cáo task
    public function update($request, $id)
    {
        $numday = (strtotime($request->todate) - strtotime($request->fromdate)) / (60 * 60 * 24);
        $taskChild = $this->repository->find($id);
        $data = [
            'detailtaskname' => $request->detailtaskname,
            'priority' => $request->priority,
            'fromdate' => $request->fromdate,
            'todate' => $request->todate,
            'numday' => $numday + 1,
            'description' => $request->description,
            'note' => $request->note,
            'initialization_user_id' => $request->initialization_user_id,
            'update_user_id' => Auth::user()->id,
        ];
        $this->repository->update($data, $id);
    }

    public function deleteTaskchild($idtaskParent, $id)
    {
        $this->repository->delete($id);
        // Start Lấy tất cã progress task Child tính trung bình cộng update task Parent
        $progresstaskChilds = $this->repository->get()->where('taskid', $idtaskParent);

        $progress_child = 0;
        foreach($progresstaskChilds as $progresstaskChild) {
            $progress_child += $progresstaskChild->progress;
        }

        $progressTask = $progress_child / $progresstaskChilds->count();

        $progressParent = [
            'progress' => $progressTask,
        ];
        app(TaskOneRepository::class)->update($progressParent, $idtaskParent);
    }

    // Leader duyệt task child
    // public function taskChildApprove($id)
    // {
    //     $leadApprove = $this->repository->find($id);
    //     $data = [
    //         'approved' => 1,
    //         'approved_user_id' => Auth::user()->id,
    //     ];
    //     $leadApprove = $this->repository->update($data, $id);

    //     if(app(TaskOneRepository::class)->find($leadApprove->taskid)->status_child == 0) {
    //         $status = [
    //             'status' => 6, // cập nhật lên Leader duyệt hoàn thành
    //             'status_child' => 1,
    //         ];
    //         app(TaskOneRepository::class)->update($status, $leadApprove->taskid);
    //     }

    //     return $leadApprove;
    // }

    // Leader duyệt task child - Phòng biên dịch
    public function taskChildTranslateApprove($id)
    {
        $leadApprove = $this->repository->find($id);
        $approved_at = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if ($leadApprove->progress < 100) {
            if (Auth::user()->roles()->first()->name == "Leader") { // Leader duyệt 1 phần task nhỏ
                // Cập nhật trạng thái task nhỏ
                $status_child = [
                    'status' => 17,
                    'approved_at' => $approved_at,
                    'approved_user_id' => Auth::user()->id,
                ];
                $leadApprove = $this->repository->update($status_child, $id);

                $status_parent = [
                    'status' => 17,
                ];
                app(TaskOneRepository::class)->update($status_parent, $leadApprove->taskid);

            } elseif (Auth::user()->roles()->first()->name == "owner") { // CEO duyệt 1 phần task nhỏ
                // Cập nhật trạng thái task nhỏ
                $status_child = [
                    'status' => 21,
                    'approved_at' => $approved_at,
                    'approved_user_id' => Auth::user()->id,
                ];
                $leadApprove = $this->repository->update($status_child, $id);

                $status_parent = [
                    'status' => 21,
                ];
                app(TaskOneRepository::class)->update($status_parent, $leadApprove->taskid);
            }
        } elseif ($leadApprove->progress == 100) {
            if (Auth::user()->roles()->first()->name == "Leader") { // Leader duyệt hoàn thành task nhỏ
                // Cập nhật trạng thái task nhỏ
                $status_child = [
                    'status' => 18,
                    'approved_at' => $approved_at,
                    'approved_user_id' => Auth::user()->id,
                ];
                $leadApprove = $this->repository->update($status_child, $id);

                $status_parent = [
                    'status' => 18,
                ];
                app(TaskOneRepository::class)->update($status_parent, $leadApprove->taskid);
            } elseif (Auth::user()->roles()->first()->name == "owner") { // CEO duyệt hoàn thành task nhỏ
                // Cập nhật trạng thái task nhỏ
                $status_child = [
                    'status' => 22,
                    'approved_at' => $approved_at,
                    'approved_user_id' => Auth::user()->id,
                ];
                $leadApprove = $this->repository->update($status_child, $id);

                // Cập nhật status Task chính
                $countTaskchild1 = $this->repository->get()->where('taskid', $leadApprove->taskid)->count();
                $countTaskchild2 = $this->repository->get()->where('taskid', $leadApprove->taskid)->where('status', 22)->count();
                if ($countTaskchild1 == $countTaskchild2) {
                    $status_parent = [
                        'status' => 22,
                        'filter_status' => 8,
                    ];
                    app(TaskOneRepository::class)->update($status_parent, $leadApprove->taskid);
                }
            }
        }
        return $leadApprove;
    }

    // Ko duyệt task child - Phòng biên dịch
    public function taskChildTranslateApproveNot($id)
    {
        $leadApprove = $this->repository->find($id);
        $approved_at = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if (Auth::user()->roles()->first()->name == "Leader") { // Leader duyệt hoàn thành task nhỏ
            // Cập nhật trạng thái task nhỏ
            $status_child = [
                'status' => 15,
                'approved_at' => $approved_at,
                'approved_user_id' => Auth::user()->id,
            ];
            $leadApprove = $this->repository->update($status_child, $id);

            $status_parent = [
                'status' => 15,
            ];
            app(TaskOneRepository::class)->update($status_parent, $leadApprove->taskid);
        } elseif (Auth::user()->roles()->first()->name == "owner") { // CEO duyệt hoàn thành task nhỏ
            // Cập nhật trạng thái task nhỏ
            $status_child = [
                'status' => 19,
                'approved_at' => $approved_at,
                'approved_user_id' => Auth::user()->id,
            ];
            $leadApprove = $this->repository->update($status_child, $id);

            $status_parent = [
                'status' => 19,
                'filter_status' => 6,
            ];
            app(TaskOneRepository::class)->update($status_parent, $leadApprove->taskid);
        }
        return $leadApprove;
    }

    // User nhận Task
    public function taskChildReceive($request, $id)
    {
        $userReceive = $this->repository->find($id);
        $data = [
            'status' => 11,
        ];
        $this->repository->update($data, $id);

        // Cập nhật trạng thái task lớn khi User nhận task
        $status_taskParent = [
            'status' => 17,
        ];
        app(TaskOneRepository::class)->update($status_taskParent, $userReceive->taskid);
        return $userReceive;
    }

    // User từ chối nhận Task
    public function taskChildDeny($request, $id)
    {
        $userReceive = $this->repository->find($id);
        $data = [
            'status' => 9,
        ];
        $this->repository->update($data, $id);
        return $userReceive;
    }

    // User Báo cáo
    public function updateProgressTaskChild($request, $id)
    {
        $progresstaskChild = $this->repository->find($id);

        if($request->report == "") {
            $progress = ($request->numberPage / $request->totalNumberPage) * 100 ;
        } else {
            $progress = $request->report;
        }

        $data = [
            'progress' => $progress,
            'status' => 13,
            'note' => $request->note,
            'updated_user_id' => Auth::user()->id,
        ];
        $progresstaskChild = $this->repository->update($data, $id); // báo cáo tiến độ task child

        if($progresstaskChild->progress == 100 && Auth::user()->roles()->first()->name == 'owner') {
            $stt = [
                'status' => 22, 
            ];

            // if(Auth()->user()->id == 247) {
            //     $taskParent = app(TaskOneRepository::class)->update($stt, $progresstaskChild->taskid);
            // }
        } elseif ($progresstaskChild->progress == 100) {
            $stt = [
                'status' => 14,
            ];

        } else {
            $stt = [
                'status' => 13,
            ];

            // if(Auth()->user()->id == 247) {
            //     $taskParent = app(TaskOneRepository::class)->update($stt, $progresstaskChild->taskid);
            // }
        }
        $this->repository->update($stt, $progresstaskChild->id);
        $this->updateProgressTaskParent($progresstaskChild);
    }

    // Upload file báo cáo
    public function uploadPostFile($request, $id)
    {   
        if ($request->division_id == 1) {
            $division = 'content';
        } elseif ($request->division_id == 2) {
            $division = 'data';
        } elseif ($request->division_id == 3) {
            $division = 'design';
        } elseif ($request->division_id == 4) {
            $division = 'it';
        } elseif ($request->division_id == 5) {
            $division = 'ketoan';
        } elseif ($request->division_id == 6) {
            $division = 'marketing';
        } elseif ($request->division_id == 7) {
            $division = 'nhansu';
        } elseif ($request->division_id == 8) {
            $division = 'sales';
        } elseif ($request->division_id == 9) {
            $division = 'vanhanh';
        } elseif ($request->division_id == 10) {
            $division = 'writing';
        } elseif ($request->division_id == 11) {
            $division = 'biendich';
        } elseif ($request->division_id == 12) {
            $division = 'dantrang';
        } elseif ($request->division_id == 13) {
            $division = 'inan';
        } elseif ($request->division_id == 14) {
            $division = 'banquyen';
        } elseif ($request->division_id == 15) {
            $division = 'ngonngu';
        } elseif ($request->division_id == 16) {
            $division = 'bgd';
        } else {
            $division = 'kho';
        }

        $progresstaskChild = $this->repository->find($id);

        $file = $request->file('file_name');
        $file_name = $file->getClientOriginalName();
        $file->move(public_path('task_file/' . $division), $file_name);

        $data = [
            'file_name' => $file_name,
            'updated_user_id' => Auth::user()->id,
        ];
        $progresstaskChild = $this->repository->update($data, $id); // báo cáo tiến độ task child
    }
    // Xóa file báo cáo
    public function deleteFile($id, $iddivision, $file_name)
    {
        if ($iddivision == 1) {
            $division = 'content';
        } elseif ($iddivision == 2) {
            $division = 'data';
        } elseif ($iddivision == 3) {
            $division = 'design';
        } elseif ($iddivision == 4) {
            $division = 'it';
        } elseif ($iddivision == 5) {
            $division = 'ketoan';
        } elseif ($iddivision == 6) {
            $division = 'marketing';
        } elseif ($iddivision == 7) {
            $division = 'nhansu';
        } elseif ($iddivision == 8) {
            $division = 'sales';
        } elseif ($iddivision == 9) {
            $division = 'vanhanh';
        } elseif ($iddivision == 10) {
            $division = 'writing';
        } elseif ($iddivision == 11) {
            $division = 'biendich';
        } elseif ($iddivision == 12) {
            $division = 'dantrang';
        } elseif ($iddivision == 13) {
            $division = 'inan';
        } elseif ($iddivision == 14) {
            $division = 'banquyen';
        } elseif ($iddivision == 15) {
            $division = 'ngonngu';
        } elseif ($iddivision == 16) {
            $division = 'bgd';
        } else {
            $division = 'kho';
        }

        $file_path = public_path('task_file/'  . $division). '/'. $file_name;

        if (file_exists($file_path)) {
            $filename = [
                'file_name' => '',
            ];

            $this->repository->update($filename, $id);
            unlink($file_path);
        } else {
            // Error
            exit('Requested file does not exist on our server!');
        }
    }

    // Lấy tất cã progress task Child tính trung bình cộng update task Parent
    public function updateProgressTaskParent($progresstaskChild)
    {
        // Start Lấy tất cã progress task Child tính trung bình cộng update task Parent
        $progresstaskChilds = $this->repository->get()->where('taskid', $progresstaskChild->taskid);

        $progress_child = 0;
        foreach($progresstaskChilds as $progresstaskChild) {
            $progress_child += $progresstaskChild->progress;
        }

        $progressTask = $progress_child / $progresstaskChilds->count();

        // Cập nhật status Task chính
        $countTaskchild1 = $this->repository->get()->where('taskid', $progresstaskChild->taskid)->count();
        $countTaskchild2 = $this->repository->get()->where('taskid', $progresstaskChild->taskid)->where('status', 22)->count();
        if (Auth::user()->roles()->first()->name == 'owner') {
            if ($countTaskchild1 == $countTaskchild2) {
                $progressParent = [
                    'progress' => $progressTask,
                    'status' => 22,
                    'filter_status' => 8,
                ];
                app(TaskOneRepository::class)->update($progressParent, $progresstaskChild->taskid);
            } else {
                $progressParent = [
                    'progress' => $progressTask,
                    'filter_status' => 6,
                ];
                app(TaskOneRepository::class)->update($progressParent, $progresstaskChild->taskid);
            }
        } else {
            $progressParent = [
                'progress' => $progressTask,
                'filter_status' => 6,
            ];
            app(TaskOneRepository::class)->update($progressParent, $progresstaskChild->taskid);
        }
        // End
    }

    // Leader báo cáo task nhỏ đã hoàn thành lên CEO (Phòng vận hành)
    public function operateReport($request, $id)
    {
        $progresstaskChild = $this->repository->find($id);

        $status = [
            'status' => 17,
        ];
        $progresstaskChild = $this->repository->update($status, $id);
    }
}
