<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Http\Requests\CheckEmployeeMonthRequest;
use RBooks\Services\CheckEmployeeMonthService;

class CheckEmployeeMonthController extends Controller
{
    public function __construct(CheckEmployeeMonthService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('company-manage.checkemployeemonth.');
        $this->setRoutePrefix('checkemployeemonths-');

        $this->view->setHeading('home.Bảng tổng hợp chấm công');

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

        $ret = $this->main_service->checkEmployeeMonth($month, $year);
        $message = "";

        $lastday = getLastDayMonth($month, $year); //lay ngay cuoi thang
        $listdaymonth = getListDayMonth($month, $year); //lay thu va cac ngay trong thang
        $listchecktype = $this->main_service->getListCheckType('showtype', array('1','2'));//lay cac kieu du lieu cham cong
        
        //Lay du lieu bhxh can bo de in ra man hinh
        if ($typereport == "add"){

            if ($ret >= 0) {
                
                if ($ret == 0){
                    $message = "Bảng chấm công tháng $month/$year đã được lưu ! Để tạo mới lại bảng chấm công bạn cần xóa bảng chấm công đã lưu.";                	
                }elseif ($ret == 1){
                    $message = "Bảng chấm công tháng $month/$year đã được duyệt ! Nhấn nút Xem bảng chấm công đã lưu để xem lại bảng chấm công.";                	
                }

                $this->view->infor = $message;
                $this->view->setSubHeading('home.Tạo mới bảng chấm công');
                
                return $this->view('index');
            }
    
            $reportListFinish = array();
            $reportListFinish = $this->main_service->processCheckEmployeeMonth($month, $year);
            $reportList = $reportListFinish[0];
    
            $this->view->month = $month;
            $this->view->year = $year;
            $this->view->lastday = $lastday;
            $this->view->listdaymonth = $listdaymonth;            
            $this->view->listchecktype = $listchecktype;            
    
            $this->view->checkemployeemonths = $reportList;
    
            $this->view->setSubHeading('home.Tạo mới bảng chấm công');
            return $this->view('process');
        }else{

            //Xem lai du lieu da luu bang cham cong
            if ($ret == -1) {
                $message = "Bảng chấm công tháng $month/$year chưa được lưu ! Nhấn nút Tạo mới để tạo mới và Lưu bảng chấm công.";
                $this->view->infor = $message;
                $this->view->setSubHeading('home.Xem lại bảng chấm công');

                return $this->view('index');
            }

            $reportListFinish = array();
            $reportListFinish = $this->main_service->getCheckEmployeeMonth($month, $year);
            $reportList = $reportListFinish[0];
    
            $this->view->month = $month;
            $this->view->year = $year;
            $this->view->lastday = $lastday;
            $this->view->listdaymonth = $listdaymonth;            
            $this->view->listchecktype = $listchecktype;            
            $this->view->approved = $ret;            
    
            $this->view->checkemployeemonths = $reportList;
    
            $this->view->setSubHeading('home.Xem lại bảng chấm công');
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

        $result = $this->main_service->createCheckEmployeeMonth($month, $year);

        $message = "";
        if ($result){
            $message = "Bảng tổng hợp chấm công tháng $month/$year đã được lưu thành công !";
        }else{
            $message = "Bảng tổng hợp chấm công tháng $month/$year lỗi lưu dữ liệu !";
        }
        
        $this->view->month = $month;
        $this->view->year = $year;
        $this->view->infor = $message;

        $this->view->setSubHeading('home.Xem lại bảng chấm công');
        return $this->view('index');
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
        //Duyet bang ke cham cong       
        $typereport = $request->typereport;
        $month = $request->month;
        $year = $request->year;

        $message = "";
        if ($typereport == "delete"){
            $message = "Bảng tổng hợp công tháng $month/$year đã được xóa thành công !";
            $result = $this->main_service->deleteCheckEmployeeMonth($month, $year);            
        }else{
            if ($typereport == "approved"){
                $approved = '1';
                $message = "Bảng tổng hợp công tháng $month/$year đã được duyệt thành công !";
            }else{
                $approved = '0';
                $message = "Bảng tổng hợp công tháng $month/$year đã được bỏ duyệt thành công !";
            }
            $result = $this->main_service->approvedCheckEmployeeMonth($month, $year, $approved);
        }
        
        $this->view->month = $month;
        $this->view->year = $year;
        $this->view->infor = $message;
        
        $this->view->setSubHeading('home.Xem lại bảng tổng hợp công');        
        return $this->view('index');
    }
}
