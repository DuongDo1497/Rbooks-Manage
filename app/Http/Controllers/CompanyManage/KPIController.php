<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\KPIStoreRequest;
use RBooks\Services\KPIService;
use RBooks\Services\EmployeeService;
use RBooks\Models\DetailTask;
use RBooks\Models\Task;
use RBooks\Repositories\TaskOneRepository;
use RBooks\Repositories\EmployeeRepository;
use RBooks\Repositories\KPIRepository;
use App\Constants\NotificationMessage;
use App\Exports\KPIExport;
use App\Constants\Export;
use Excel;
use \Auth;

class KPIController extends Controller
{
    public function __construct(KPIService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('company-manage.kpi.');
        $this->setRoutePrefix('kpis-');

        $this->view->setHeading('Quản lý KPI');

        $this->view->employees = app(EmployeeService::class)->getAll()->where('status', 1);
    }

    public function index(Request $request)
    {
        $detailtasks = DetailTask::select('taskid')->where('initialization_user_id', $request->searchField)->where('status', 22)->get()->toArray();
        //dd($detailtasks);
        if ($request->fromdate != null && $request->todate != null) {
            $tasks = Task::whereIn('id', $detailtasks)->where('module_type', '!=', 10)->whereBetween('fromdate', [$request->fromdate, $request->todate])->get();
            $this->view->fromdate = $request->fromdate;
            $this->view->todate = $request->todate;
        } else {
            $tasks = Task::whereIn('id', $detailtasks)->where('module_type', '!=', 10)->get();
            $this->view->fromdate = null;
            $this->view->todate = null;
        }

        $this->view->tasks = $tasks;

        if ($request->searchField != null) {
            $this->view->employeeid = $request->searchField;
            $this->view->employeename = app(EmployeeService::class)->find($request->searchField);
            $this->view->employee = app(EmployeeService::class)->find($request->searchField);
        }

        // Setup title
        $this->view->setSubHeading('home.Danh sách');
        return $this->view('index');
    }

    public function store(Request $request)
    {
        // $detailtask = app(DetailTaskRepository::class)->select('taskid')->findByField('initialization_user_id', $request->employeeid)->where('status', 22)->toArray();
        $detailtasks = DetailTask::select('taskid')->where('initialization_user_id', $request->employeeid)->where('status', 22)->get()->toArray();
        // dd($detailtasks);
        if ($request->fromdate != null && $request->todate != null) {
            $tasks = app(TaskOneRepository::class)->findWhereIn('id', $detailtasks)->where('module_type', '!=', 10)->whereBetween('fromdate', [$request->fromdate, $request->todate]);
        } else {
            $tasks = app(TaskOneRepository::class)->findWhereIn('id', $detailtasks)->where('module_type', '!=', 10);
        }

        $employeeid = app(EmployeeRepository::class)->find($request->employeeid);
        $departmentid = $employeeid->department->id;
        $positionid = $employeeid->position->id;

        // $projects = "";
        // $deadlinepjs = "";
        // foreach ($tasks as $task) {
        //     $projects = $projects . "," . $task->taskname;
        //     $deadlinepjs = $deadlinepjs . "," . $task->fromdate . "/" . $task->todate;
        // }
        // $projects = substr($projects, 1);
        // $deadlinepjs = substr($deadlinepjs, 1);
        $kpis =  array();
        foreach ($tasks as $task) { // get jobs of projects
            $jobs = "";
            foreach ($task->detailTasks as $detailTask) {
                $jobs = $jobs . ", " . "- " . $detailTask->detailtaskname . " (" . date("d/m/Y", strtotime($detailTask->fromdate)) . "-" . date("d/m/Y", strtotime($detailTask->todate)) . ")";
            }
            $jobs = substr($jobs, 1);
            $data = [
                'fromdate' => $request->fromdate,
                'todate' => $request->todate,
                'department_id' => $departmentid,
                'position_id' => $positionid,
                'employee_id' => $employeeid->id,
                'projects' => $task->taskname,
                'fromdate_pj' => $task->fromdate,
                'todate_pj' => $task->todate,
                'completeddate_pj' => $task->updated_at,
                'jobs' => $jobs,
                'status' => 0,
                // 'kpi%' => $request->kpi,
                // 'point' => $request->point,
                // 'note' => $request->note,
                'approved' => 0,
                'created_user_id' => Auth::user()->id
            ];
            app(KPIRepository::class)->create($data);
            $kpis[] = $data;
        }
        $employeename = $employeeid->fullname;
        $positionname = $employeeid->position->code_position;
        $departmentname = $employeeid->division->name;

        return Excel::download(new KPIExport($kpis, $employeename, $positionname, $departmentname), 'KPI-'. $employeename . '-' . date(Export::DATE_FORMAT) . '.xlsx');
    }

    // public function edit($id)
    // {
    //     $this->view->checkemployee = $this->main_service->find($id);
    //     $this->view->setSubHeading('Chỉnh sửa');
    //     return $this->view('edit');
    // }

    public function edit($id)
    {
        $this->view->kpi = $this->main_service->find($id);
        $this->view->setSubHeading('Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(Request $request, $id)
    {
        return $this->_update($request, $id);
    }

    // public function accept(Request $request, $id)
    // {
    //     return $this->_accept($request, $id);
    // }

    // public function cancel(Request $request, $id)
    // {
    //     return $this->_cancel($request, $id);
    // }

    public function taskExport(Request $request)
    {
        dd($request->tasks);
    }
}
