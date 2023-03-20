<?php

namespace RBooks\Services;

use RBooks\Repositories\CheckEmployeeMonthRepository;
use \Auth;
use \DB;
use Carbon\Carbon;
use RBooks\Repositories\EmployeeRepository;
use RBooks\Repositories\CheckTypeRepository;
use RBooks\Repositories\HolidayRepository;
use RBooks\Repositories\CheckEmployeeRepository;
use RBooks\Repositories\EmplperdayRepository;
use RBooks\Models\Department;
use RBooks\Models\Position;
use RBooks\Models\Employee;
use RBooks\Models\CheckType;
use RBooks\Models\Holiday;
use RBooks\Models\CheckEmployee;
use RBooks\Models\EmployeePermissionday;

class CheckEmployeeMonthService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(CheckEmployeeMonthRepository::class);
    }

    /**
     * checkEmployeeMonth
     * 
     * @author  linh
     * @param   string $month
     * @param   string $year
     * @return  boolean
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function checkEmployeeMonth($month, $year)
    {
        $data = array('month'=>$month, 'year'=>$year);
        $ret = app(CheckEmployeeMonthRepository::class)->findWhere($data, ['approved']);

        $status = -1;//chua duoc luu
        if (count($ret) > 0){
            $status = $ret[0]->approved;//trang thai duyet hay chua duyet 0, 1            
        }

        return $status;
    }  

    /**
     * processCheckEmployeeMonth
     * 
     * @author  linh
     * @param   string $month
     * @param   string $year
     * @return  array
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function processCheckEmployeeMonth($month, $year)
    {

        $reportListFinish = array();
    
        $listEmployees = app(EmployeeRepository::class)->findByField('print', 3);

        $condition = array('1','2');
        $listCheckType = $this->getListCheckType('showtype', $condition);

        $lastday = getLastDayMonth($month, $year); //lay ngay cuoi thang
        $listdaymonth = getListDayMonth($month, $year); //lay thu va cac ngay trong thang

        $searchFromDate = Carbon::parse($year."/".$month."/01");
        $searchToDate = Carbon::parse($year."/".$month."/" . $lastday);

        //tinh tong so ngay lam viec thuc te trong thang
        $condition = array(['holiday','>=', $searchFromDate], ['holiday','<=', $searchToDate]);
        $retTemp = app(HolidayRepository::class)->findWhere($condition, ['salary']);
        $sumWorkDay = $retTemp->sum('salary'); 

        
        $reportList = array();

        foreach($listEmployees as $employee){
            $employee_id = $employee->id;
            $department_name = app(Department::class)->find($employee->department_id)->name;
            $position_name = app(Position::class)->find($employee->position_id)->name;

            $dataArrayItem = array();
            $dataArrayItem = [
                'month' => $month,
                'year' => $year,
                'employee_id' => $employee->id,
                'id_staff' => $employee->id_staff,
                'fullname' => $employee->fullname,
                'department_id' => $employee->department_id,
                'department_name' => $department_name,
                'position_id' => $employee->position_id,
                'position_name' => $position_name,
                'print' => $employee->print,                
            ];


            foreach ($listCheckType as $checkType){
                $key = $checkType['signno'];
                $dataArrayItem[$key] = 0;
            }
            $dataArrayItem['+'] = 0;
            $dataArrayItem['NLV'] = 0;
            $dataArrayItem['NHL'] = 0;

            $searchDate = clone $searchFromDate;
            $fromDateTmp = clone $searchFromDate;
            $sSearchDate = $searchDate->toDateString();

            for($i=1; $i<=$lastday; $i++){
                $dateArray = $searchDate->toArray();
                $day = $dateArray['dayOfWeek']; 

                $indentCheckType = 0; $indentPlus = 0;
                $checkvalue = "+";            
                //kiem tra nghi le CN
                if ($day == 0){
                    $checkvalue = "//";
                }elseif ($day == 6){
                    $checkvalue = "0.5+";
                    $indentPlus = 0.5;
                }

                //kiem tra nghi le 30/4 , 1/5 , 2/9 , tet ...
                $condition = array(['checkholiday','=', '1'], ['dayname','<>', '0'], ['holiday','=', $sSearchDate]);
                $retTemp = app(HolidayRepository::class)->findWhere($condition, ['holiday','dayname','salary']);
                for($itemp=0; $itemp<count($retTemp); $itemp++){
                    $checkvalue = "//";
                }
                                
                //kiem tra nghi le phep trong nam: ngay nghi lam viec duoc lam bu
                $condition = array(['checkholiday','=', '1'], ['type','=', '0'], ['holiday','=', $sSearchDate]);
                $retTemp = app(HolidayRepository::class)->findWhere($condition, ['holiday','dayname','salary']);
                for($itemp=0; $itemp<count($retTemp); $itemp++){
                    $checkvalue = "+";
                }

                //kiem tra co nhap nghi cong tac, om, ...
                $condition = array(['employee_id','=', $employee_id], ['status','=', 1], ['fromdate','<=', $sSearchDate], ['todate','>=', $sSearchDate]);
                $retTemp = app(CheckEmployeeRepository::class)->findWhere($condition, ['checktype_id','fromdate','fromtime','todate','totime','numday','status']);
    
                $checktype = "+";
                $checkFULL = ""; $checkSA = ""; $checkCH = "";
                for($itemp=0; $itemp<count($retTemp); $itemp++){
                    $checktype_id = $retTemp[$itemp]->checktype_id;
                    $checktype = $retTemp[$itemp]->checktype()->find($checktype_id)->signno;    

                    $numday = $retTemp[$itemp]->numday;
                    $fromdate = $retTemp[$itemp]->fromdate->toDateString();
                    $fromtime = $retTemp[$itemp]->fromtime;
                    $todate = $retTemp[$itemp]->todate->toDateString();
                    $totime = $retTemp[$itemp]->totime;

                    $indentCheckType = 0; $indentPlus = 0;
                    if ($fromdate == $sSearchDate){//fromdate = searchdate  : ngay bat dau
                    	if ($fromtime == "FULL"){
                    		$checkFULL = $checktype;
                            $indentCheckType = 1;
                    	}elseif ($fromtime == "SA"){
                            $checkSA = "0.5" . $checktype;
                            $indentCheckType = 0.5;
                        }elseif ($fromtime == "CH"){
                            $checkCH = "0.5" . $checktype;
                            $indentCheckType = 0.5;
                        }
                        
                    }elseif ($todate == $sSearchDate){//todate = searchdate : ngay ket thuc
                        if ($totime == "FULL"){
                            $checkFULL = $checktype;
                            $indentCheckType = 1;
                        }elseif ($totime == "SA"){
                            $checkSA = "0.5" . $checktype;
                            $indentCheckType = 0.5;
                        }elseif ($totime == "CH"){
                            $checkCH = "0.5" . $checktype;
                            $indentCheckType = 0.5;
                        }
                    }else{//truong hop con lai o giua
                        $checkFULL = $checktype;
                        $indentCheckType = 1;                    	
                    }

                    $dataArrayItem[$checktype] += $indentCheckType;

                }  
                
                if ($checkSA != "" OR $checkCH != ""){
                    if ($checkSA != "" and $checkCH == ""){
                        //kiem tra nghi T7
                        if ($day == 6){
                            $checkCH = "";
                        }else{
                            $checkCH = "0.5+";
                            $indentPlus = 0.5;
                        }
                    }elseif ($checkSA == "" and $checkCH != ""){
                        $checkSA = "0.5+";
                        $indentPlus = 0.5;
                    }
                }elseif ($checkFULL == ""){
                	$checkFULL = $checkvalue;
                    
                    if (trim($checkvalue) == "+"){
                        $indentPlus = 1;                    	
                    }
                }

                $checkvalue = $checkFULL . " " . $checkSA . " " . $checkCH;                       
                $dataArrayItem[$i] = $checkvalue;//luu vao mang gia tri cham cong cua ngay i

                $dataArrayItem["+"] += doubleval($indentPlus);//luu vao mang gia tri cham cong ngay di lam +              	

                //tang them ngay ke tiep de tinh            
                $searchDate = $fromDateTmp->addDay(1);
                $sSearchDate = $searchDate->toDateString();

            }

        
            $dataArrayItem["NLV"] = $dataArrayItem["+"]; 

            //cong nhat ko tinh tien com trua => print=3
            $dataArrayItem["A/TR"] = ($dataArrayItem["print"] == "3" ? 0 : ceil($dataArrayItem["+"]+$dataArrayItem["H"]));
    
            $dataArrayItem["NHL"] = $sumWorkDay-($dataArrayItem["O"]+$dataArrayItem["TS"]+$dataArrayItem["TN"]+$dataArrayItem["Ro"]);                
            $dataArrayItem["NHL"] = ($dataArrayItem["NHL"] < 0 ? 0 : $dataArrayItem["NHL"]);
    
            if ($dataArrayItem["Ro"] >= $sumWorkDay OR $dataArrayItem["TS"] >= $sumWorkDay){
                $dataArrayItem["NHL"] = 0;          
            }

            $dataArrayItem["PCL"] = 0;
            //kiem tra ngay phep hien co, phep da nghi
            $permission_lastyear = 0; $permission_curryear = 0; $permission_leave = 0; $permission_left = 0;
            $condition = array(['employee_id','=', $employee_id], ['year','=', $year]);
            $retTemp = app(EmplperdayRepository::class)->findWhere($condition, ['permission_lastyear', 'permission_curryear', 'permission_leave', 'permission_left'])->first();
            if (isset($retTemp) and $retTemp != null){
                $permission_lastyear = $retTemp->permission_lastyear;
                $permission_curryear = $retTemp->permission_curryear;
                $permission_leave = $retTemp->permission_leave;
                $permission_left = $retTemp->permission_left;
            }
            $dataArrayItem["PCL"] = $permission_curryear + 1 - $dataArrayItem["P"];
            $dataArrayItem["permissionlastyear"] = $permission_curryear;
            $dataArrayItem["permissioncurryear"] = $dataArrayItem["PCL"];

            
            $reportList[] = $dataArrayItem;
        }

        $reportListFinish[] = $reportList;

        return $reportListFinish;
    } 

    /**
     * getListCheckType
     * 
     * @author  linh
     * @return  array
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function getListCheckType($field, $value)
    {
        $ret = app(CheckTypeRepository::class)->findWhereIn($field, $value);
        
        return $ret;
    }  

    /**
     * createCheckEmployeeMonth
     * 
     * @author  linh
     * @param   string $month
     * @param   string $year
     * @return  boolean
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function createCheckEmployeeMonth($month, $year)
    {
      
        $reportListFinish = array();
        $reportListFinish = $this->processCheckEmployeeMonth($month, $year);
        $reportList = $reportListFinish[0];
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $condition = array('1','2');
        $listCheckType = $this->getListCheckType('showtype', $condition);

        $lastday = getLastDayMonth($month, $year); //lay ngay cuoi thang

        //lay danh sach ten cac ngay trong thang 
        $dayofmonthfield = "";
        for($i=1; $i<=$lastday; $i++){
            $dayofmonthfield = $dayofmonthfield . "," . $i;
        }
        $dayofmonthfield = substr($dayofmonthfield, 1);

        //lay danh sach ten loai cham cong
        $checktypefield = "";
        foreach ($listCheckType as $checkType){
            $key = $checkType['signno'];
            $checktypefield = $checktypefield . "," . $key;
        }
        $checktypefield = substr($checktypefield, 1);

        for($i=0; $i<count($reportList); $i++){
            $item = $reportList[$i];

            //lay gia tri cac ngay trong thang
            $dayofmonthvalue = "";
            for($j=1; $j<=$lastday; $j++){
                $dayofmonthvalue = $dayofmonthvalue . "," . trim($item[$j]);
            }
            $dayofmonthvalue = substr($dayofmonthvalue, 1);      

            //lay gia tri cac loai cham cong trong thang
            $checktypevalue = "";
            foreach ($listCheckType as $checkType){
                $key = $checkType['signno'];
                $checktypevalue = $checktypevalue . "," . trim($item[$key]);
            }        
            $checktypevalue = substr($checktypevalue, 1);

            $workingday = $item['NLV'];
            $permissionday = $item['P'];
            $boardingday = $item['A/TR'];
            $salaryday = $item['NHL'];
            $permissionlastyear = $item['permissionlastyear'];
            $permissioncurryear = $item['permissioncurryear'];
            $approved = 0;
   
            $data = [
                'month' => $month,
                'year' => $year,
                'employee_id' => $item['employee_id'],
                'department_id' => $item['department_id'],
                'position_id' => $item['position_id'],
                'dayofmonthfield' => $dayofmonthfield,
                'dayofmonthvalue' => $dayofmonthvalue,
                'checktypefield' => $checktypefield,
                'checktypevalue' => $checktypevalue,
                'workingday' => $workingday,
                'permissionday' => $permissionday,
                'boardingday' => $boardingday,
                'salaryday' => $salaryday,
                'permissionlastyear' => $permissionlastyear,
                'permissioncurryear' => $permissioncurryear,
                'approved' => $approved,
                'created_user_id' => $created_user_id,
                'updated_user_id' => $updated_user_id
            ];

            $ret = $this->repository->create($data);
        }
        
        return true;
    }

    /**
     * getMonthSalary
     * 
     * @author  linh
     * @param   string $month
     * @param   string $year
     * @return  array
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function getCheckEmployeeMonth($month, $year)
    {

        $reportListFinish = array();
    
        $data = array('month'=>$month, 'year'=>$year);
        $listCheckEmployeeMonth = app(CheckEmployeeMonthRepository::class)->findWhere($data);

        $reportList = array();

        foreach($listCheckEmployeeMonth as $item)
        {
            $employee_id = $item->id;
            $employee = app(EmployeeRepository::class)->find($item['employee_id']);
            $department_name = app(Department::class)->find($item['department_id'])->name;
            $position_name = app(Position::class)->find($item['position_id'])->name;
            $approved = $item['approved']; 

            $dataArrayItem = [
                'month' => $month,
                'year' => $year,
                'employee_id' => $employee->id,
                'id_staff' => $employee->id_staff,
                'fullname' => $employee->fullname,
                'department_id' => $employee->department_id,
                'department_name' => $department_name,
                'position_id' => $employee->position_id,
                'position_name' => $position_name
            ];

            $dayofmonthfield = $item["dayofmonthfield"];
            $dayofmonthvalue = $item["dayofmonthvalue"];
            $checktypefield = $item["checktypefield"];
            $checktypevalue = $item["checktypevalue"];
    
            $dataArrayItem["NLV"] = $item["workingday"];
            $dataArrayItem["P"] = $item["permissionday"];                
            $dataArrayItem["A/TR"] = $item["boardingday"];
            $dataArrayItem["NHL"] = $item["salaryday"];
            $dataArrayItem["PCL"] = $item["permissioncurryear"];
            
            $date_array_field = explode(',',$dayofmonthfield);                
            $date_array_value = explode(',',$dayofmonthvalue);                
            for($i=0; $i<count($date_array_field); $i++){
                $dataArrayItem[$date_array_field[$i]] = $date_array_value[$i];
            }
    
            $date_array_field = explode(',',$checktypefield);                
            $date_array_value = explode(',',$checktypevalue);                
            for($i=0; $i<count($date_array_field); $i++){
                $dataArrayItem[$date_array_field[$i]] = $date_array_value[$i];
            }
    
            $reportList[] = $dataArrayItem; 
        }


        $reportListFinish[] = $reportList;

        return $reportListFinish;
    }
    
    /**
     * approvedCheckEmployeeMonth
     * 
     * @author  linh
     * @param   string $month
     * @param   string $year
     * @param   string $approved
     * @return  boolean
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function approvedCheckEmployeeMonth($month, $year, $approved)
    {
        $approved_user_id = quote_smart(Auth()->user()->id);
        $approved_at = Carbon::today()->toDateTimeString(); 

        \DB::table('ns_checkemployeemonths')
            ->where('month', '=', $month)
            ->where('year', '=', $year)
            ->update(['approved' => $approved, 'approved_user_id' => $approved_user_id, 'approved_at' => $approved_at]);

        return true;
    }    

    /**
     * deleteCheckEmployeeMonth
     * 
     * @author  linh
     * @param   string $month
     * @param   string $year
     * @return  boolean
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function deleteCheckEmployeeMonth($month, $year)
    {
        \DB::table('ns_checkemployeemonths')
            ->where('month', '=', $month)
            ->where('year', '=', $year)
            ->delete();

        return true;
    }    

}
