<?php

namespace RBooks\Services;

use RBooks\Repositories\EmployeeRepository;
use RBooks\Repositories\EmplperdayRepository;
use RBooks\Repositories\LaborContractRepository;
use RBooks\Repositories\EducationRepository;
use RBooks\Repositories\HistoryWorkRepository;
use RBooks\Repositories\CheckEmployeeRepository;
use RBooks\Repositories\CheckBusinessRepository;
use RBooks\Models\Department;
use RBooks\Models\Position;
use RBooks\Models\Division;
use RBooks\Models\CityProvince;
use RBooks\Models\Employee;
use RBooks\Models\CheckType;
use Carbon\Carbon;
use \Auth;
use \DB;

class EmployeeService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(EmployeeRepository::class);
        //$this->importservice = app(ImportService::class);
    }

    /**
     * Create new dept
     *
     * @param object $request
     * @return \App\Models\Dept
     */
    public function create($request)
    {
        $image = $request->file('fImages');
        if($image == null) {
            $imageN = 'staff/';
            $imageName = substr($imageN, 6);
        } else {
            $imageN = $image->getClientOriginalName();
            $imageName = 'staff/'.$imageN;
            $image->move(public_path('staff/'), $imageName);
        }

        $recordlast = $this->repository->get()->last();
        $temp = (int) substr($recordlast->id_staff, 4);
        $stt = sprintf("%04d", $temp + 1);
        $year = substr(Carbon::now()->year, 2);

        $months = (string) Carbon::now()->month;
        $month = strlen($months) == 1 ? "0".$months : $months;

        $id_staff = $year.$month.$stt;

        $data = [
            'avatar' => $imageName,
            'id_staff' => $id_staff,
            'fullname' => $request->fullname,
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'maritalstatus' => $request->maritalstatus,
            'address' => $request->address,
            'temporaryaddress' => $request->temporaryaddress,
            'level_id' => $request->level_id,
            'email' => $request->email,
            'localmail' => $request->localmail,
            'phone' => $request->phone,
            'phone_other' => $request->phone_other,
            'id_No' => $request->id_No,
            'identycarddate' => $request->identycarddate,
            'identycardplace_issue' => $request->identycardplace_issue,
            'hometown_id' => $request->hometown_id,
            'people' => $request->people,
            'begin_workday' => $request->begin_workdate,
            'begin_official_workday' => $request->begin_official_workday,
            'position_id' => $request->position_id,
            'department_id' => $request->department_id,
            'division_id' => $request->division_id == '0' ? 0 : $request->division_id,
            'account_No' => $request->account_No,
            'bankname' => $request->bankname,
            'beginlabordate' => $request->beginlabordate,
            'finishworkdate' => $request->finishworkdate,
            'print' => $request->print,
            'personaltaxcode' => $request->personaltaxcode,
            'salaryyear' => $request->salaryyear,
            'salaryincome' => $request->salaryincome,
            'status' => $request->status,
            'user_id' => $request->user_id,
            'created_user_id' => Auth::user()->id,
            'updated_user_id' => Auth::user()->id
        ];

        return $this->repository->create($data);
    }

    public function update($request, $course_id)
    {
        $employee = $this->repository->find($course_id);
        $image = $request->file('fImages');
        if($image == null) {
            $imageN = 'staff/'.$employee->avatar;
            $imageName = substr($imageN, 6);
        } else {
            $imageN = $image->getClientOriginalName();
            $imageName = 'staff/'.$imageN;
            $image->move(public_path('staff/'), $imageName);
        }
        $data = [
            'avatar' => $imageName,
            'id_staff' => $employee->id_staff,
            'fullname' => $request->fullname,
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'maritalstatus' => $request->maritalstatus,
            'address' => $request->address,
            'temporaryaddress' => $request->temporaryaddress,
            'level_id' => $request->level_id,
            'email' => $request->email,
            'localmail' => $request->localmail,
            'phone' => $request->phone,
            'phone_other' => $request->phone_other,
            'id_No' => $request->id_No,
            'identycarddate' => $request->identycarddate,
            'identycardplace_issue' => $request->identycardplace_issue,
            'hometown_id' => $request->hometown_id,
            'people' => $request->people,
            'begin_workday' => $request->begin_workdate,
            'begin_official_workday' => $request->begin_official_workday,
            'position_id' => $request->position_id,
            'department_id' => $request->department_id,
            'division_id' => $request->division_id == '0' ? 0 : $request->division_id,
            'account_No' => $request->account_No,
            'bankname' => $request->bankname,
            'beginlabordate' => $request->beginlabordate,
            'finishworkdate' => $request->finishworkdate,
            'finish' => $request->finish,
            'print' => $request->print,
            'personaltaxcode' => $request->personaltaxcode,
            'salaryyear' => $request->salaryyear,
            'salaryincome' => $request->salaryincome,
            'status' => $request->status,
            'user_id' => $request->user_id,
            'created_user_id' => $employee->created_user_id,
            'updated_user_id' => Auth::user()->id
        ];

        $this->repository->update($data, $course_id);
    }

    // public function staffDoing()
    // {
    //     return $this->repository->scopeQuery(function($query){
    //         return $query->where('status', '=', 1);
    //     })->all();
    // }

    // public function staffIncrease()
    // {
    //     return $this->repository->scopeQuery(function($query){
    //         $now = Carbon::now();
    //         $monthOfYear = $now->month;
    //         return $query->whereMonth('created_at', $monthOfYear);
    //     })->all();
    // }

    public function birthdayInMonth()
    {
        return $this->repository->scopeQuery(function($query){
            $now = Carbon::now();
            $monthOfYear = $now->month;
            return $query->whereMonth('birthday', $monthOfYear);
        })->all();
    }
    
    /**
     * getEmployee
     * 
     * @author  linh
     * @param   string $employeeid
     * @return  array
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function getEmployee($employeeid)
    {

        $year = Carbon::now()->year;
        $labortype = config('rbooks.LABORTYPE');
        $educationtype = config('rbooks.EDUCATIONTYPE');
        
        $dataArrayItem = $this->repository->find($employeeid);

        $department_name = ''; $position_name = ''; $division_name = ''; $cityprovince_name = '';
        if (isset($dataArrayItem->department_id) and $dataArrayItem->department_id != null){        
            $department_name = app(Department::class)->find($dataArrayItem->department_id)->name;
        }
        if (isset($dataArrayItem->position_id) and $dataArrayItem->position_id != null){        
            $position_name = app(Position::class)->find($dataArrayItem->position_id)->name;
        }
        if (isset($dataArrayItem->division_id) and $dataArrayItem->division_id != null){        
            $division_name = app(Division::class)->find($dataArrayItem->division_id)->name;
        }
        if (isset($dataArrayItem->hometown_id) and $dataArrayItem->hometown_id != null){        
            $cityprovince_name = app(CityProvince::class)->find($dataArrayItem->hometown_id)->name;
        }
        $dataArrayItem['department_name'] = $department_name;
        $dataArrayItem['position_name'] = $position_name;
        $dataArrayItem['division_name'] = $division_name;
        $dataArrayItem['cityprovince_name'] = $cityprovince_name;
        
        $data = array('employee_id'=>$employeeid, 'active'=>1);
        $laborcontract = app(LaborContractRepository::class)->findWhere($data)->first();
        
        $fromdate = ''; $todate = ''; $labortype = 0; $description = ''; 
        if (isset($laborcontract) and $laborcontract != null){
            $fromdate = $laborcontract->fromdate; 
            $todate = $laborcontract->todate; 
            $labortype = $labortype[$laborcontract->labortype];
            $description = $laborcontract->description;         
        }
        $dataArrayItem['laborcontractfromdate'] = $fromdate;
        $dataArrayItem['laborcontracttodate'] = $todate;
        $dataArrayItem['laborcontractlabortype'] = $labortype;
        $dataArrayItem['laborcontractdescription'] = $description;

        $data = array('employee_id'=>$employeeid);
        $education = app(EducationRepository::class)->findWhere($data)->first();
        
        $fromdate = ''; $todate = ''; $schoolname = ''; $level = ''; $major = ''; $description = '';
        if (isset($education) and $education != null){
            $fromdate = $education->fromdate; 
            $todate = $education->todate; 
            $schoolname = $education->schoolname;
            $level = $educationtype[$education->level];         
            $major = $education->major;         
            $description = $education->description;         
        }
        $dataArrayItem['educationfromdate'] = $fromdate;
        $dataArrayItem['educationtodate'] = $todate;
        $dataArrayItem['educationschoolname'] = $schoolname;
        $dataArrayItem['educationlevel'] = $level;
        $dataArrayItem['educationmajor'] = $major;
        $dataArrayItem['educationdescription'] = $description;

        $data = array('employee_id'=>$employeeid, 'year'=>$year);
        $employeepermissionday = app(EmplperdayRepository::class)->findWhere($data)->first();
        
        $permission_lastyear = 0; $permission_curryear = 0; $permission_leave = 0; $permission_left = 0; 
        if (isset($employeepermissionday) and $employeepermissionday != null){
            $permission_lastyear = $employeepermissionday->permission_lastyear; 
            $permission_curryear = $employeepermissionday->permission_curryear; 
            $permission_leave = $employeepermissionday->permission_leave;
            $permission_left = $employeepermissionday->permission_left;       	
        }
        $dataArrayItem['permission_lastyear'] = $permission_lastyear;
        $dataArrayItem['permission_curryear'] = $permission_curryear;
        $dataArrayItem['permission_leave'] = $permission_leave;
        $dataArrayItem['permission_left'] = $permission_left;

        $data = array('employee_id'=>$employeeid);
        $historywork = app(HistoryWorkRepository::class)->findWhere($data)->last();

        $fromdate = ''; $todate = ''; $nummonths = ''; $department_name = ''; $position_name = ''; $description = '';
        if (isset($historywork) and $historywork != null){
            $fromdate = $historywork->fromdate; 
            $todate = $historywork->todate; 
            $nummonths = $historywork->nummonths;
            $department_id = $historywork->department_id;         
            $position_id = $historywork->position_id;         
            $description = $historywork->description;         

            $department_name = app(Department::class)->find($department_id)->name;
            $position_name = app(Position::class)->find($position_id)->name;

        }
        $dataArrayItem['historyworkfromdate'] = $fromdate;
        $dataArrayItem['historyworktodate'] = $todate;
        $dataArrayItem['historyworknummonths'] = $nummonths;
        $dataArrayItem['historyworkdepartment_name'] = $department_name;
        $dataArrayItem['historyworkposition_name'] = $position_name;
        $dataArrayItem['historyworkdescription'] = $description;

       
        return $dataArrayItem;
    }

    /**
     * getCheckEmployee
     * 
     * @author  linh
     * @param   string $employeeid
     * @return  array
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function getCheckEmployee($employeeid)
    {

        $reportListFinish = array();
        
        $year = Carbon::now()->year;
        
        $dataArrayItem = $this->repository->find($employeeid);

        $department_name = ''; $position_name = ''; $division_name = ''; $cityprovince_name = '';
        if (isset($dataArrayItem->department_id) and $dataArrayItem->department_id != null){        
            $department_name = app(Department::class)->find($dataArrayItem->department_id)->name;
        }
        if (isset($dataArrayItem->position_id) and $dataArrayItem->position_id != null){        
            $position_name = app(Position::class)->find($dataArrayItem->position_id)->name;
        }
        if (isset($dataArrayItem->division_id) and $dataArrayItem->division_id != null){        
            $division_name = app(Division::class)->find($dataArrayItem->division_id)->name;
        }

        $dataArrayItem['department_name'] = $department_name;
        $dataArrayItem['position_name'] = $position_name;
        $dataArrayItem['division_name'] = $division_name;
        
        $data = array('employee_id'=>$employeeid, 'year'=>$year);
        $employeepermissionday = app(EmplperdayRepository::class)->findWhere($data)->first();
        
        $permission_lastyear = 0; $permission_curryear = 0; $permission_leave = 0; $permission_left = 0; 
        if (isset($employeepermissionday) and $employeepermissionday != null){
            $permission_lastyear = $employeepermissionday->permission_lastyear; 
            $permission_curryear = $employeepermissionday->permission_curryear; 
            $permission_leave = $employeepermissionday->permission_leave;
            $permission_left = $employeepermissionday->permission_left;         
        }
        $dataArrayItem['permission_lastyear'] = $permission_lastyear;
        $dataArrayItem['permission_curryear'] = $permission_curryear;
        $dataArrayItem['permission_leave'] = $permission_leave;
        $dataArrayItem['permission_left'] = $permission_left;

        $sfromdate = "$year/01/01"; $stodate = "$year/12/31";
        $condition = array(['employee_id','=', $employeeid], ['fromdate','>=', $sfromdate], ['fromdate','<=', $stodate]);
        $retTemp = app(CheckEmployeeRepository::class)->findWhere($condition);

        $reportList = array(); 
        for($itemp=0; $itemp<count($retTemp); $itemp++){
            $item = $retTemp[$itemp];            
            $id = $item['id']; 
            $checktype_id = $item['checktype_id']; 
            $fromdate = $item['fromdate']; 
            $fromtime = $item['fromtime']; 
            $todate = $item['todate']; 
            $totime = $item['totime']; 
            $numday = $item['numday']; 
            $place = $item['place']; 
            $description = $item['description']; 
            $status = $item['status']; 
            $approved_user_id = $item['approved_user_id']; 
            $approved_at = $item['approved_at']; 

            $approved_user_name = '';
            if (isset($approved_user_id) and $approved_user_id != ''){        
                $approved_user_name = app(Employee::class)->find($approved_user_id)->fullname;
            }

            $checktype_name = '';
            if (isset($checktype_id) and $checktype_id != ''){        
                $checktype_name = app(CheckType::class)->find($checktype_id)->description;
            }

            $datacheckemployee = [
                'id' => $id,
                'checktype_id' => $checktype_id,
                'checktype_name' => $checktype_name,
                'fromdate' => $fromdate,
                'fromtime' => $fromtime,
                'todate' => $todate,
                'totime' => $totime,
                'numday' => $numday,
                'place' => $place,
                'description' => $description,
                'status' => $status,
                'approved_user_id' => $approved_user_id,
                'approved_user_name' => $approved_user_name,
                'approved_at' => $approved_at
            ];
           
            $reportList[] = $datacheckemployee; 
        }

       
        $reportListFinish[] = $dataArrayItem;
        $reportListFinish[] = $reportList;       

        return $reportListFinish;

    }
    
    /**
     * getCheckBusiness
     * 
     * @author  linh
     * @param   string $employeeid
     * @return  array
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function getCheckBusiness($employeeid)
    {

        $reportListFinish = array();
        
        $year = Carbon::now()->year;
        
        $dataArrayItem = $this->repository->find($employeeid);

        $department_name = ''; $position_name = ''; $division_name = ''; $cityprovince_name = '';
        if (isset($dataArrayItem->department_id) and $dataArrayItem->department_id != null){        
            $department_name = app(Department::class)->find($dataArrayItem->department_id)->name;
        }
        if (isset($dataArrayItem->position_id) and $dataArrayItem->position_id != null){        
            $position_name = app(Position::class)->find($dataArrayItem->position_id)->name;
        }
        if (isset($dataArrayItem->division_id) and $dataArrayItem->division_id != null){        
            $division_name = app(Division::class)->find($dataArrayItem->division_id)->name;
        }

        $dataArrayItem['department_name'] = $department_name;
        $dataArrayItem['position_name'] = $position_name;
        $dataArrayItem['division_name'] = $division_name;
        
        $sfromdate = "$year/01/01"; $stodate = "$year/12/31";
        $condition = array(['employee_id','=', $employeeid], ['fromdate','>=', $sfromdate], ['fromdate','<=', $stodate]);
        $retTemp = app(CheckBusinessRepository::class)->findWhere($condition);

        $reportList = array(); 
        for($itemp=0; $itemp<count($retTemp); $itemp++){
            $item = $retTemp[$itemp];            
            $id = $item['id']; 
            $checktype_id = $item['checktype_id']; 
            $fromdate = $item['fromdate']; 
            $fromtime = $item['fromtime']; 
            $todate = $item['todate']; 
            $totime = $item['totime']; 
            $numday = $item['numday']; 
            $place = $item['place']; 
            $description = $item['description'];
            $transportation = $item['transportation'];  
            $status = $item['status']; 
            $approved_user_id = $item['approved_user_id']; 
            $approved_at = $item['approved_at']; 

            $approved_user_name = '';
            if (isset($approved_user_id) and $approved_user_id != ''){        
                $approved_user_name = app(Employee::class)->find($approved_user_id)->fullname;
            }

            $checktype_name = '';
            if (isset($checktype_id) and $checktype_id != ''){        
                $checktype_name = app(CheckType::class)->find($checktype_id)->description;
            }

            $datacheckemployee = [
                'id' => $id,
                'checktype_id' => $checktype_id,
                'checktype_name' => $checktype_name,
                'fromdate' => $fromdate,
                'fromtime' => $fromtime,
                'todate' => $todate,
                'totime' => $totime,
                'numday' => $numday,
                'place' => $place,
                'description' => $description,
                'transportation' => $transportation,
                'status' => $status,
                'approved_user_id' => $approved_user_id,
                'approved_user_name' => $approved_user_name,
                'approved_at' => $approved_at
            ];
           
            $reportList[] = $datacheckemployee; 
        }

       
        $reportListFinish[] = $dataArrayItem;
        $reportListFinish[] = $reportList;       

        return $reportListFinish;

    }         
}
