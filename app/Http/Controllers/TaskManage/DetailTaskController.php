<?php

namespace App\Http\Controllers\TaskManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DetailTaskStoreRequest;
use App\Http\Requests\DetailTaskUpdateRequest;
use RBooks\Services\DetailTaskService;
use RBooks\Services\EmployeeService;
use App\Constants\NotificationMessage;
use RBooks\Repositories\DetailTaskRepository;
use RBooks\Repositories\TaskOneRepository;
use RBooks\Repositories\EmployeeRepository;
use \Auth;
use Response;

class DetailTaskController extends Controller
{
    public function __construct(DetailTaskService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('task-manage.taskchild.');
        $this->setRoutePrefix('taskChild-');
    }

    // Khởi tạo task nhỏ
    public function storeDetailTask(Request $request, $id)
    {
        $this->main_service->storeDetailTask($request, $id);
        return redirect()->back()
                 ->with(NotificationMessage::CREATE_SUCCESS);
    }

    public function store(DetailTaskStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function update(DetailTaskUpdateRequest $request, $id)
    {
        $this->main_service->update($request, $id);
        return redirect()->back()->with(NotificationMessage::UPDATE_SUCCESS);
    }

    public function deleteTaskchild($idtaskParent, $id)
    {
        $this->main_service->deleteTaskchild($idtaskParent, $id);
        return redirect()->back()->with(NotificationMessage::DELETE_SUCCESS);
    }

    // edit taskChild CEO rbooks
    public function editCEO($id)
    {
        $this->view->taskChild = app(DetailTaskRepository::class)->get()->where('id', $id)->first();

        $this->view->employees = app(EmployeeService::class)->getAll()->where('id', 23);

        $this->view->setSubHeading('Chỉnh sửa Task việc');
        return $this->view('edit');
    }

    // edit taskChild
    public function editTrans($id)
    {
        $this->view->taskChild = app(DetailTaskRepository::class)->get()->where('id', $id)->first();

        $this->view->employees = app(EmployeeRepository::class)->scopeQuery(function($query){
            return $query->where('division_id', 11)->orWhere('id', 12);
        })->all();

        $this->view->setSubHeading('Chỉnh sửa Task việc');
        return $this->view('edit');
    }

    // edit taskChild Trans
    public function editTransTVTA($id)
    {
        $this->view->taskChild = app(DetailTaskRepository::class)->get()->where('id', $id)->first();

        $this->view->employees = app(EmployeeService::class)->getAll()->where('id', 15);

        $this->view->setSubHeading('Chỉnh sửa Task việc');
        return $this->view('edit');
    }

    // edit taskChild Kế toán
    public function editAccount($id)
    {
        $this->view->taskChild = app(DetailTaskRepository::class)->get()->where('id', $id)->first();

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 5);

        $this->view->setSubHeading('Chỉnh sửa Task việc');
        return $this->view('edit');
    }

    // edit taskChild Data khác
    public function editData($id)
    {
        $this->view->taskChild = app(DetailTaskRepository::class)->get()->where('id', $id)->first();

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 2);

        $this->view->setSubHeading('Chỉnh sửa Task việc');
        return $this->view('edit');
    }

    // edit taskChild Design 1
    public function editDesign($id)
    {
        $this->view->taskChild = app(DetailTaskRepository::class)->get()->where('id', $id)->first();

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 3);

        $this->view->setSubHeading('Chỉnh sửa Task việc');
        return $this->view('edit');
    }

    // edit taskChild nhân sự khác
    public function editHR($id)
    {
        $this->view->taskChild = app(DetailTaskRepository::class)->get()->where('id', $id)->first();

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 7);

        $this->view->setSubHeading('Chỉnh sửa Task việc');
        return $this->view('edit');
    }

    // edit taskChild IT
    public function editIT($id)
    {
        $this->view->taskChild = app(DetailTaskRepository::class)->get()->where('id', $id)->first();

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 4);

        $this->view->setSubHeading('Chỉnh sửa Task việc');
        return $this->view('edit');
    }

    // edit taskChild Language
    public function editLanguage($id)
    {
        $this->view->taskChild = app(DetailTaskRepository::class)->get()->where('id', $id)->first();

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 10);

        $this->view->setSubHeading('Chỉnh sửa Task việc');
        return $this->view('edit');
    }

    // edit taskChild Dàn trang
    public function editLayout($id)
    {
        $this->view->taskChild = app(DetailTaskRepository::class)->get()->where('id', $id)->first();

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 3);

        $this->view->setSubHeading('Chỉnh sửa Task việc');
        return $this->view('edit');
    }

    // edit taskChild bản quyền
    public function editLicense($id)
    {
        $this->view->taskChild = app(DetailTaskRepository::class)->get()->where('id', $id)->first();

        $this->view->employees = app(EmployeeService::class)->getAll()->whereIn('id', [1, 15]);

        $this->view->setSubHeading('Chỉnh sửa Task việc');
        return $this->view('edit');
    }

    // edit taskChild marketing 1
    public function editMarketing($id)
    {
        $this->view->taskChild = app(DetailTaskRepository::class)->get()->where('id', $id)->first();

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 6);

        $this->view->setSubHeading('Chỉnh sửa Task việc');
        return $this->view('edit');
    }

    // edit taskChild Vận hành 1
    public function editOperate($id)
    {
        $this->view->taskChild = app(DetailTaskRepository::class)->get()->where('id', $id)->first();

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 9);

        $this->view->setSubHeading('Chỉnh sửa Task việc');
        return $this->view('edit');
    }

    // edit taskChild In ấn 1
    public function editPrint($id)
    {
        $this->view->taskChild = app(DetailTaskRepository::class)->get()->where('id', $id)->first();

        $this->view->employees = app(EmployeeService::class)->getAll()->whereIn('id', [1, 14]);

        $this->view->setSubHeading('Chỉnh sửa Task việc');
        return $this->view('edit');
    }

    // edit taskChild sales 1
    public function editSales($id)
    {
        $this->view->taskChild = app(DetailTaskRepository::class)->get()->where('id', $id)->first();

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 8);

        $this->view->setSubHeading('Chỉnh sửa Task việc');
        return $this->view('edit');
    }

    // edit taskChild writing rbooks
    public function editWriting($id)
    {
        $this->view->taskChild = app(DetailTaskRepository::class)->get()->where('id', $id)->first();
        
        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', 10);

        $this->view->setSubHeading('Chỉnh sửa Task việc');
        return $this->view('edit');
    }

    // edit taskChild kho rbooks
    public function editWarehouse($id)
    {
        $this->view->taskChild = app(DetailTaskRepository::class)->get()->where('id', $id)->first();

        $this->view->employees = app(EmployeeService::class)->getAll()->whereIn('division_id', [2, 5, 8, 9]);

        $this->view->setSubHeading('Chỉnh sửa Task việc');
        return $this->view('edit');
    }

    // edit taskChild content thiết kế sp
    public function editContent($id)
    {
        $this->view->taskChild = app(DetailTaskRepository::class)->get()->where('id', $id)->first();

        $this->view->employees = app(EmployeeService::class)->getAll()->whereIn('id', [14, 15]);

        $this->view->setSubHeading('Chỉnh sửa Task việc');
        return $this->view('edit');
    }

    // User nhận task
    public function taskChildReceive(Request $request, $id)
    {
        $this->main_service->taskChildReceive($request, $id);
        return redirect()->back()
                         ->with(NotificationMessage::ACCEPT_SUCCESS);
    }

    // User không nhận task
    public function taskChildDeny(Request $request, $id)
    {
        $this->main_service->taskChildDeny($request, $id);
        return redirect()->back()
                         ->with(NotificationMessage::ACCEPT_SUCCESS);
    }

    // User thực hiện Task
    public function staffPerform($id)
    {
        $this->view->taskChild = app(DetailTaskRepository::class)->get()->where('id', $id)->first();

        $this->view->employees = app(EmployeeService::class)->getAll()->where('division_id', $task_moduleid->module_id);

        $this->view->setSubHeading('Nhân viên thực hiện Task');
        return $this->view('perform');
    }

    // User Báo cáo progress
    public function progressTaskChild(Request $request, $id)
    {
        $this->main_service->updateProgressTaskChild($request, $id);
    }

    // Upload file báo cáo
    public function uploadGetFile($id, $iddivision)
    {
        $this->view->taskchild = $this->main_service->find($id);
        $this->view->iddivision = $iddivision;
        $this->view->setSubHeading('Nộp file báo cáo');
        return $this->view('upload');
    }

    public function uploadPostFile(Request $request, $id)
    {
        $this->main_service->uploadPostFile($request, $id);
        return redirect()->back()->with(NotificationMessage::APPROVE_SUCCESS);
    }

    // Download file báo cáo
    public function download($iddivision, $file_name)
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
            // Send Download
            return Response::download($file_path, $file_name, [
                'Content-Length: '. filesize($file_path)
            ]);
        } else {
            // Error
            exit('Requested file does not exist on our server!');
        }
    }
    // Xóa file báo cáo
    public function deleteFile($id, $iddivision, $file_name)
    {
        $this->main_service->deleteFile($id, $iddivision, $file_name);
        return redirect()->back()->with(NotificationMessage::DELETE_SUCCESS);
    }

    // Leader báo cáo task nhỏ đã hoàn thành lên CEO (Phòng vận hành)
    public function operateReport(Request $request, $id)
    {
        $this->main_service->operateReport($request, $id);
        return redirect()->back()
                         ->with(NotificationMessage::REPORT_SUCCESS);
    }

    // Leader duyệt task child
    // public function taskChildApprove($id)
    // {
    //     $this->main_service->taskChildApprove($id);
    //     return redirect()->back()
    //                      ->with(NotificationMessage::APPROVE_SUCCESS);
    // }

    // Leader duyệt task child - Phòng biên dịch
    public function taskChildTranslateApprove($id)
    {
        $this->main_service->taskChildTranslateApprove($id);
        return redirect()->back()
                         ->with(NotificationMessage::APPROVE_SUCCESS);
    }

    // Leader duyệt task child - Phòng biên dịch
    public function taskChildTranslateApproveNot($id)
    {
        $this->main_service->taskChildTranslateApproveNot($id);
        return redirect()->back()
                         ->with(NotificationMessage::APPROVE_SUCCESS);
    }
}
