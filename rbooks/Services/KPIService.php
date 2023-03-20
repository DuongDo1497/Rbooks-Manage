<?php

namespace RBooks\Services;

use RBooks\Repositories\KPIRepository;
use RBooks\Repositories\DetailTaskRepository;
use RBooks\Repositories\TaskOneRepository;
use RBooks\Repositories\EmployeeRepository;
use RBooks\Models\DetailTask;
use \Auth;
use App\Exports\KPIExport;
use App\Constants\Export;
use Excel;

class KPIService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(KPIRepository::class);
    }

    // public function create($request)
    // {

    //     // $detailtask = app(DetailTaskRepository::class)->select('taskid')->findByField('initialization_user_id', $request->employeeid)->where('status', 22)->toArray();
    //     $detailtasks = DetailTask::select('taskid')->where('initialization_user_id', $request->employeeid)->where('status', 22)->get()->toArray();
    //     // dd($detailtasks);
    //     if ($request->fromdate != null && $request->todate != null) {
    //         $tasks = app(TaskOneRepository::class)->findWhereIn('id', $detailtasks)->where('module_type', '!=', 10)->whereBetween('fromdate', [$request->fromdate, $request->todate]);
    //     } else {
    //         $tasks = app(TaskOneRepository::class)->findWhereIn('id', $detailtasks)->where('module_type', '!=', 10);
    //     }

    //     $employeeid = app(EmployeeRepository::class)->find($request->employeeid);
    //     $departmentid = $employeeid->department->id;
    //     $positionid = $employeeid->position->id;

    //     // $projects = "";
    //     // $deadlinepjs = "";
    //     // foreach ($tasks as $task) {
    //     //     $projects = $projects . "," . $task->taskname;
    //     //     $deadlinepjs = $deadlinepjs . "," . $task->fromdate . "/" . $task->todate;
    //     // }
    //     // $projects = substr($projects, 1);
    //     // $deadlinepjs = substr($deadlinepjs, 1);
    //     $kpis =  array();
    //     foreach ($tasks as $task) { // get jobs of projects
    //         $jobs = "";
    //         foreach ($task->detailTasks as $detailTask) {
    //             $jobs = $jobs . ", " . "- " . $detailTask->detailtaskname . " (" . date("d/m/Y", strtotime($detailTask->fromdate)) . "-" . date("d/m/Y", strtotime($detailTask->todate)) . ")";
    //         }
    //         $jobs = substr($jobs, 1);
    //         $data = [
    //             'fromdate' => $request->fromdate,
    //             'todate' => $request->todate,
    //             'department_id' => $departmentid,
    //             'position_id' => $positionid,
    //             'employee_id' => $employeeid->id,
    //             'projects' => $task->taskname,
    //             'fromdate_pj' => $task->fromdate,
    //             'todate_pj' => $task->todate,
    //             'completeddate_pj' => $task->updated_at,
    //             'jobs' => $jobs,
    //             'status' => 0,
    //             // 'kpi%' => $request->kpi,
    //             // 'point' => $request->point,
    //             // 'note' => $request->note,
    //             'approved' => 0,
    //             'created_user_id' => Auth::user()->id
    //         ];
    //         $this->repository->create($data);
    //         $kpis[] = $data;
    //     }
    //     $employeename = $employeeid->fullname;
    //     $positionname = $employeeid->position->code_position;
    //     $departmentname = $employeeid->division->name;

    //     Excel::download(new KPIExport($kpis, $employeename, $positionname, $departmentname), 'export-'. $employeename . '-' . date(Export::DATE_FORMAT) . '.xlsx');
    // }
}
