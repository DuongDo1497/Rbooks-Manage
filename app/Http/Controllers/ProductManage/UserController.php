<?php

namespace App\Http\Controllers\ProductManage;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use RBooks\Services\UserService;
use Illuminate\Http\Request;
use App\Constants\Export;
use App\Constants\NotificationMessage;
use RBooks\Services\CheckTypeService;
use RBooks\Services\CheckBusinessService;
use RBooks\Services\EmployeeService;
use RBooks\Services\CheckEmployeeService;
use RBooks\Models\User;
use Illuminate\Support\Facades\Crypt;
use RBooks\Services\ApplicationRolesService;
use RBooks\Services\APIAdminService;

class UserController extends Controller
{
    public function __construct(UserService $service)
    {
        parent::__construct($service);
        $this->setViewPrefix('user-employees.user.');
        $this->setRoutePrefix('users-');

        $this->view->setHeading('home.Quản lý người dùng');
    }

    public function index(Request $request )
    {
        $searchValue = ($request->searchValue == null ? "" : $request->searchValue);
        $searchField = ($request->searchField == null ? "" : $request->searchField);
        $this->view->searchValue = $searchValue;
        $this->view->searchField = $searchField;        
                        
        //$this->authorize('user-list', User::class);
        $user = $request->sortedBy ? $request->sortedBy : 'asc';
        $field = $request->orderBy ? $request->orderBy : 'id';
        $this->view->collections = $this->main_service->getListUserBySearch($searchField, $searchValue)->paginate($this->view->filter['limit']);

        $this->view->applicationroles = app(ApplicationRolesService::class)->getAll();
        $this->view->accounttypes = config('rbooks.ACCOUNTTYPE');

        // Setup title
        $this->view->setSubHeading('home.Danh sách');
        return $this->view('user_account.index');
    }

    public function add()
    {
        $this->view->applicationroles = app(ApplicationRolesService::class)->getAll();
        $this->view->accounttypes = config('rbooks.ACCOUNTTYPE');
        
        $this->view->setSubHeading('Thêm mới tài khoản đăng nhập');
        return $this->view('user_account.add');
    }
    
    public function edit($id)
    {
        $this->view->model = $this->main_service->find($id);
        $this->view->applicationroles = app(ApplicationRolesService::class)->getAll();
        $this->view->accounttypes = config('rbooks.ACCOUNTTYPE');

        // Setup title
        $this->view->setSubHeading('home.Chỉnh sửa');
        return $this->view('user_account.edit');
    }

    public function store(UserStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $model = $this->main_service->update($request, $id);

        if (!$model) {
            return redirect()
                ->route($this->route_prefix . 'index')
                ->withErrors(NotificationMessage::UPDATE_ERROR);
        }

        if ($request->continue) {
            return redirect()
                ->route($this->route_prefix . 'edit', ['id' => $id, 'applicationroles' => $applicationroles])
                ->with(NotificationMessage::UPDATE_SUCCESS);
        }

        return redirect()
            ->route($this->route_prefix . 'index')
            ->with(NotificationMessage::UPDATE_SUCCESS);
    }

    public function detail($id)
    {
        $userid = Crypt::decrypt($id);
        $user = $this->main_service->find($userid);
         
        $employeeid = "";
        $this->view->setSubHeading('home.Chi tiết nhân viên');
        if ($user->employee()->first() == NULL){
            return redirect()->route('employees-add');
        }

        $employeeid = $user->employee()->first()->id;
        
        $this->view->detai_employee = app(EmployeeService::class)->getEmployee($employeeid);
        $this->view->parameter = Crypt::encrypt($this->view->detai_employee->id);

        $this->view->checktypes = app(CheckTypeService::class)->getAll();
        $this->view->checkbusiness = app(CheckBusinessService::class)->getAll();
        $this->view->birthdayInMonth = app(EmployeeService::class)->birthdayInMonth();
        $this->view->checkemplInDay = app(CheckEmployeeService::class)->checkemplInDay();
        $this->view->checkbusiInDay = app(CheckBusinessService::class)->checkbusiInDay();

        return $this->view('detail', ['parameter' => $this->view->parameter]);
    }

    public function checkemployee($id)
    {
        $course_id = Crypt::decrypt($id);

        $this->view->checkemployee_user = $this->main_service->find($course_id);
        $this->view->checktypes = app(CheckTypeService::class)->getAll();

        $this->view->setSubHeading('home.Danh sách nghỉ trong năm');

        return $this->view('checkemployeeInYear');
    }

    public function checkbusiness($id)
    {
        $course_id = Crypt::decrypt($id);
        $this->view->checkbusiness_user = $this->main_service->find($course_id);
        $this->view->checktypes = app(CheckTypeService::class)->getAll();

        $this->view->setSubHeading('home.Danh sách công tác trong năm');

        return $this->view('checkbusinessInYear');
    }

    public function showpayroll($id)
    {
        $this->view->payroll_user = $this->main_service->find($id);
        //$this->view->checktypes = app(CheckTypeService::class)->getAll();

        $this->view->setSubHeading('home.Lương');

        return $this->view('payroll.index');
    }

    public function showinsurance($id)
    {
        $this->view->insurance_user = $this->main_service->find($id);
        //$this->view->checktypes = app(CheckTypeService::class)->getAll();

        $this->view->setSubHeading('home.Bảo hiểm xã hội');

        return $this->view('insurances.index');
    }
}
