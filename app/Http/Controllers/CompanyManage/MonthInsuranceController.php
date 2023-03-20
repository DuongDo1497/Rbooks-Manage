<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MonthInsuranceStoreRequest;
use RBooks\Services\MonthInsuranceService;
use RBooks\Services\EmployeeService;
use Carbon\Carbon;
use App\Constants\NotificationMessage;
use RBooks\Models\Department;
use RBooks\Models\Position;
use RBooks\Models\Employee;
use RBooks\Repositories\EmployeeRepository;

class MonthInsuranceController extends Controller
{
    public function __construct(MonthInsuranceService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('company-manage.monthinsurance.');
        $this->setRoutePrefix('monthinsurances-');

        $this->view->setHeading('home.Bảng tính bảo hiểm xã hội');

        $now = Carbon::now();
        $this->view->month = $now->month;
        $this->view->year = $now->year;

    }

    /**
     * process
     * 
     * @author  linh
     * @param   Request $request
     * @return  boolean
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function process(Request $request)
    {
        $typereport = $request->typereport;
        $month = $request->month;
        $year = $request->year;

        $ret = $this->main_service->checkMonthInsurance($month, $year);
        $message = "";
        
        //Lay du lieu bhxh can bo de in ra man hinh
        if ($typereport == "add"){

            if ($ret >= 0) {
                if ($ret == 0){
                    $message = "Bảng kê tính bảo hiểm xã hội tháng $month/$year đã được lưu ! Nhấn nút Xem bảng kê đã lưu để xem lại bảng kê.";
                }elseif ($ret == 1){
                    $message = "Bảng kê tính bảo hiểm xã hội tháng $month/$year đã được duyệt ! Nhấn nút Xem bảng kê đã lưu để xem lại bảng kê.";                   
                }
                $this->view->infor = $message;
                $this->view->setSubHeading('home.Tạo mới bảng tính bảo hiểm xã hội');

                return $this->view('index');
            }
    
            $reportListFinish = array();
            $reportListFinish = $this->main_service->processMonthInsurance($month, $year);
            $reportList = $reportListFinish[0];
            $reportListConfig = $reportListFinish[1];
            $reportListSum = $reportListFinish[2];
    
            $this->view->month = $month;
            $this->view->year = $year;
    
            $this->view->monthinsurances = $reportList;
            $this->view->configinsurances = $reportListConfig;
            $this->view->summonthinsurances = $reportListSum;

            $this->view->setSubHeading('home.Tạo mới bảng tính bảo hiểm xã hội');    
            return $this->view('process');
        }else{

            //Xem lai du lieu da luu bang tinh bhxh
            if ($ret == -1) {
                $message = "Bảng kê tính bảo hiểm xã hội tháng $month/$year chưa được lưu ! Nhấn nút Tạo mới để tạo mới bảng kê.";
                $this->view->infor = $message;
                $this->view->setSubHeading('home.Tạo mới bảng tính bảo hiểm xã hội');

                return $this->view('index');
            }

            $reportListFinish = array();
            $reportListFinish = $this->main_service->getMonthInsurance($month, $year);
            $reportList = $reportListFinish[0];
            $reportListConfig = $reportListFinish[1];
            $reportListSum = $reportListFinish[2];
    
            $this->view->month = $month;
            $this->view->year = $year;
    
            $this->view->monthinsurances = $reportList;
            $this->view->configinsurances = $reportListConfig;
            $this->view->summonthinsurances = $reportListSum;
            $this->view->approved = $ret;
                
            $this->view->setSubHeading('home.Xem lại bảng tính bảo hiểm xã hội');    
            return $this->view('search');        	

        }
    }

    /**
     * store
     * 
     * @author  linh
     * @param   Request $request
     * @return  boolean
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function store(Request $request)
    {

        $month = $request->month;
        $year = $request->year;

        $result = $this->main_service->createMonthInsurance($month, $year);

        $message = "";
        if ($result){
            $message = "Bảng kê tính bảo hiểm xã hội tháng $month/$year đã được lưu thành công !";
        }else{
            $message = "Bảng kê tính bảo hiểm xã hội tháng $month/$year lỗi lưu dữ liệu !";
        }
        
        $this->view->month = $month;
        $this->view->year = $year;
        $this->view->infor = $message;

        $this->view->setSubHeading('home.Xem lại bảng tính bảo hiểm xã hội');
        return $this->view('index');
    }

    /**
     * edit
     * 
     * @author  linh
     * @param   Request $request
     * @return  boolean
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function edit($id)
    {
        //Lay thong tin chinh sua bhxh cua tung can bo
        $monthinsurance = $this->main_service->find($id);
        $this->view->model = $monthinsurance;

        $department_name = app(Department::class)->find($monthinsurance->department_id)->name;
        $position_name = app(Position::class)->find($monthinsurance->position_id)->name;
        $employee = app(Employee::class)->find($monthinsurance->employee_id);
        $employee_name = "[" . $employee->id_staff . "] " . $employee->fullname;

        $this->view->department_name = $department_name;
        $this->view->position_name = $position_name;
        $this->view->employee_name = $employee_name;
        
        $this->view->setSubHeading('home.Chỉnh sửa');
        return $this->view('edit');
    }

    /**
     * update
     * 
     * @author  linh
     * @param   Request $request
     * @return  boolean
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function update(Request $request, $id)
    {
        //Cap nhat thong tin bhxh tung can bo
        $typereport = $request->typereport;
        $month = $request->month;
        $year = $request->year;
        
        $message = "";
        if ($typereport == "update"){
            $model = $this->main_service->update($request, $id);
            $message = "Thông tin chỉnh sửa được cập nhật thành công !";    
        }

        $ret = $this->main_service->checkMonthInsurance($month, $year);
        
        $reportListFinish = array();
        $reportListFinish = $this->main_service->getMonthInsurance($month, $year);
        $reportList = $reportListFinish[0];
        $reportListConfig = $reportListFinish[1];
        $reportListSum = $reportListFinish[2];

        $this->view->month = $month;
        $this->view->year = $year;
        $this->view->infor = $message;
        
        $this->view->monthinsurances = $reportList;
        $this->view->configinsurances = $reportListConfig;
        $this->view->summonthinsurances = $reportListSum;
        $this->view->approved = $ret;
            
        $this->view->setSubHeading('home.Xem lại bảng tính bảo hiểm xã hội');
        return $this->view('search');        	

        
    }

    /**
     * approved
     * 
     * @author  linh
     * @param   Request $request
     * @return  boolean
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function approved(Request $request)
    {
        //Duyet bang ke tinh bhxh       
        $typereport = $request->typereport;
        $month = $request->month;
        $year = $request->year;

        $message = "";
        if ($typereport == "delete"){
            $message = "Bảng kê tính bảo hiểm xã hội tháng $month/$year đã được xóa thành công !";
            $result = $this->main_service->deleteMonthInsurance($month, $year);            
        }else{
            if ($typereport == "approved"){
                $approved = '1';
                $message = "Bảng kê tính bảo hiểm xã hội tháng $month/$year đã được duyệt thành công !";
            }else{
                $approved = '0';
                $message = "Bảng kê tính bảo hiểm xã hội tháng $month/$year đã được bỏ duyệt thành công !";
            }
            $result = $this->main_service->approvedMonthInsurance($month, $year, $approved);
        }

        $this->view->month = $month;
        $this->view->year = $year;
        $this->view->infor = $message;
        
        $this->view->setSubHeading('home.Xem lại bảng tính bảo hiểm xã hội');        
        return $this->view('index');
    }


}
