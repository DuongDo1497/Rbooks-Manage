<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeStoreRequest;
use RBooks\Services\EmployeeService;
use RBooks\Services\DepartmentService;
use RBooks\Services\DivisionService;
use RBooks\Services\PositionService;
use RBooks\Services\UserService;
use RBooks\Services\LevelService;
use RBooks\Services\CityProvinceService;
use RBooks\Services\CheckTypeService;
use RBooks\Models\EmployeePermissionday;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class EmployeeController extends Controller
{
    public function __construct(EmployeeService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('company-manage.employee.');
        $this->setRoutePrefix('employees-');

        $this->view->employees = app(EmployeeService::class)->getAll();
        $this->view->departments = app(DepartmentService::class)->getAll();
        $this->view->divisions = app(DivisionService::class)->getAll();
        $this->view->positions = app(PositionService::class)->getAll();
        $this->view->users = app(UserService::class)->getAll();
        $this->view->levels = app(LevelService::class)->getAll();
        $this->view->cityprovinces = app(CityProvinceService::class)->getAll();

        $this->view->setHeading('home.Quản lý nhân viên');
    }

    public function store(EmployeeStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {
        $course_id = Crypt::decrypt($id);
        $this->view->employee = $this->main_service->find($course_id);
        $this->view->setSubHeading('Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(Request $request, $id)
    {
        $course_id = Crypt::decrypt($id);
        $parameter = $id;
        return $this->_update($request, $course_id);
    }

    public function detail($id)
    {
        $employeeid = Crypt::decrypt($id);
        $this->view->detai_employee = $this->main_service->getEmployee($employeeid);
        $this->view->parameter = Crypt::encrypt($this->view->detai_employee->id);
        $this->view->setSubHeading('home.Chi tiết nhân viên');

        return $this->view('detail', ['parameter' => $this->view->parameter]);
    }

    public function checkemployee($id)
    {
        $employeeid = $id;
        $employeeid_decrypt = Crypt::decrypt($id);
        
        $reportListFinish = array();
        $reportListFinish = $this->main_service->getCheckEmployee($employeeid_decrypt);
        $employee = $reportListFinish[0];
        $checkemployee = $reportListFinish[1];

        $this->view->employeeid = $id;        
        $this->view->employee = $employee;        
        $this->view->checkemployee = $checkemployee;        

        $this->view->checktypes = app(CheckTypeService::class)->getAll();
        $this->view->approvetype = config('rbooks.APPROVETYPE');
        $this->view->fromtimetype = config('rbooks.FROMTIMETYPE');
        $this->view->totimetype = config('rbooks.TOTIMETYPE');


        $this->view->setSubHeading('home.Danh sách nghỉ trong năm');

        return $this->view('checkemployeeInYear');
    }

    public function checkbusiness($id)
    {
        $employeeid = $id;
        $employeeid_decrypt = Crypt::decrypt($id);

        $reportListFinish = array();
        $reportListFinish = $this->main_service->getCheckBusiness($employeeid_decrypt);
        $employee = $reportListFinish[0];
        $checkemployee = $reportListFinish[1];

        $this->view->employeeid = $id;        
        $this->view->employee = $employee;        
        $this->view->checkbusiness = $checkemployee;        

        $this->view->checktypes = app(CheckTypeService::class)->getAll();
        $this->view->approvetype = config('rbooks.APPROVETYPE');
        $this->view->fromtimetype = config('rbooks.FROMTIMETYPE');
        $this->view->totimetype = config('rbooks.TOTIMETYPE');
        $this->view->transportationtype = config('rbooks.TRANSPORTATIONTYPE');
        
        $this->view->setSubHeading('home.Danh sách công tác trong năm');

        return $this->view('checkbusinessInYear');
    }

    public function info()
    {
        $staffDoing = app(EmployeeService::class)->staffDoing();
        $staffIncrease = app(EmployeeService::class)->staffIncrease();

        $this->view->staffIncrease = $staffIncrease;
        $this->view->staffDoing = $staffDoing;
        $this->view->setSubHeading('Thông tin chung');
        return $this->view('info');
    }

    public function signPermissionDay(Request $request, $employee_id)
    {
        dd($request->all());
        $now = Carbon::now();
        $year = $now->year;
        $data = [
            'year' => $year,
            'employee_id' => $employee_id,
        ];
    }

    public function getUpload($id)
    {
        $this->view->employee = $this->main_service->find($id);
        return $this->view('upload');
    }

    public function uploadImage(Request $request)
    {
        $product = $this->main_service->find($request->id);
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('products/'), $imageName);

        $imageUpload = [
            'name' => $product->slug,
            'slug' => $product->slug,
            'filename' => $imageName,
            'path' => 'products/' . $imageName,
        ];
        $img = Image::create($imageUpload);

        $product->images()->attach([
            'image_id' => $img->id
        ]);

        return response()->json(['success' => $imageName]);
    }
}
