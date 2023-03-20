<?php

namespace RBooks\Services;

use \Auth;
use \DB;
use Carbon\Carbon;
use RBooks\Repositories\MonthSalaryRepository;
use RBooks\Repositories\MonthInsuranceRepository;
use RBooks\Repositories\EmployeeRepository;
use RBooks\Models\MonthSalary;
use RBooks\Models\Department;
use RBooks\Models\Position;
use RBooks\Models\Employee;
use RBooks\Services\HolidayService;

class MonthSalaryService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(MonthSalaryRepository::class);
    }

    /**
     * checkMonthSalary
     * 
     * @author  linh
     * @param   string $month
     * @param   string $year
     * @return  boolean
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function checkMonthSalary($month, $year)
    {
        $data = array('month'=>$month, 'year'=>$year);
        $ret = app(MonthSalaryRepository::class)->findWhere($data, ['approved']);

        $status = -1;//chua duoc luu
        if (count($ret) > 0){
            $status = $ret[0]->approved;//trang thai duyet hay chua duyet 0, 1            
        }

        return $status;           
    }  

    /**
     * processMonthSalary
     * 
     * @author  linh
     * @param   string $month
     * @param   string $year
     * @return  array
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function processMonthSalary($month, $year)
    {

        $reportListFinish = array();
    
        $listEmployees = app(EmployeeRepository::class)->findByField('print', 3);

        $reportList = array();
        $total_bhxh = 0; $total_bhtnld_bnn = 0; $total_bhyt = 0; $total_bhtn = 0;        
        $total_sum_salary = 0; $total_luongthuclinh = 0; $total_phucap = 0; $total_thucnhankynay = 0;

        foreach($listEmployees as $employee)
        {

            $department_name = app(Department::class)->find($employee->department_id)->name;
            $position_name = app(Position::class)->find($employee->position_id)->name;

            $payrolls = app(Employee::class)->find($employee->id)->payroll()->where('active', 1)->get();
            $data = array('month'=>$month, 'year'=>$year, 'employee_id'=>$employee->id);
            $listMonthInsurance = app(MonthInsuranceRepository::class)->findWhere($data);

            $bhxh = 0; $bhtnld_bnn = 0; $bhyt = 0; $bhtn = 0;         
            if ($listMonthInsurance->count() > 0){
                $bhxh = $listMonthInsurance[0]->bhxh; 
                $bhtnld_bnn = $listMonthInsurance[0]->bhtnld_bnn; 
                $bhyt = $listMonthInsurance[0]->bhyt; 
                $bhtn = $listMonthInsurance[0]->bhtn;          
            }
           
            $worksalary = 0; $extrasalary = 0;
            if ($payrolls->count() > 0){
                $worksalary = $payrolls[0]->worksalary;
                $extrasalary = $payrolls[0]->extrasalary;
            }

        
            $numworkday_salary = 0; $numworkday = 0; $sum_salary = 0;
            
            $numworkday_salary = app(HolidayService::class)->getNumworkDaySalary($month, $year);
            
            $numworkday = $numworkday_salary;//lay tu bang cham cong thang 

            if ($numworkday_salary > 0){
                $sum_salary = ($worksalary*$numworkday)/$numworkday_salary;            	
            }

            $luongthuclinh = $sum_salary - $bhxh - $bhtnld_bnn - $bhyt - $bhtn;  
            $phucap = $extrasalary;
            $thucnhankynay = $luongthuclinh + $phucap;
             
          
            //sum tong tung can bo
            $total_bhxh += $bhxh; 
            $total_bhtnld_bnn += $bhtnld_bnn; 
            $total_bhyt += $bhyt; 
            $total_bhtn += $bhtn; 

            $total_sum_salary += $sum_salary;
            $total_luongthuclinh += $luongthuclinh; 
            $total_phucap += $extrasalary;  
            $total_thucnhankynay += $thucnhankynay; 
            
            $dataArrayItem = [
                'month' => $month,
                'year' => $year,
                'id' => $employee->id,
                'fullname' => $employee->fullname,
                'department_id' => $employee->department_id,
                'department_name' => $department_name,
                'position_id' => $employee->position_id,
                'position_name' => $position_name,
                'worksalary' => $worksalary,
                'extrasalary' => $extrasalary,
                'numworkday_salary' => $numworkday_salary,
                'numworkday' => $numworkday,
                'bhxh' => $bhxh,
                'bhtnld_bnn' => $bhtnld_bnn,
                'bhyt' => $bhyt,
                'bhtn' => $bhtn,
                'sum_salary' => $sum_salary,
                'luongthuclinh' => $luongthuclinh,
                'phucap' => $phucap,
                'thucnhankynay' => $thucnhankynay
            ];
            
            
            $reportList[] = $dataArrayItem; 
        }

        $reportListSum = array (
                'bhxh' => $total_bhxh,
                'bhtnld_bnn' => $total_bhtnld_bnn,
                'bhyt' => $total_bhyt,
                'bhtn' => $total_bhtn,
                'sum_salary' => $total_sum_salary,
                'luongthuclinh' => $total_luongthuclinh,
                'phucap' => $total_phucap,
                'thucnhankynay' => $total_thucnhankynay
        );


        $reportListFinish[] = $reportList;
        $reportListFinish[] = $reportListSum;       

        return $reportListFinish;
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
    public function getMonthSalary($month, $year)
    {

        $reportListFinish = array();
    
        $data = array('month'=>$month, 'year'=>$year);
        $listMonthSalary = app(MonthSalaryRepository::class)->findWhere($data);

        $reportList = array(); $reportListSum = array();

        $total_bhxh = 0; $total_bhtnld_bnn = 0; $total_bhyt = 0; $total_bhtn = 0;        
        $total_sum_salary = 0; $total_luongthuclinh = 0; $total_phucap = 0; $total_thucnhankynay = 0;
        $approved = "0";

        foreach($listMonthSalary as $item)
        {
            $employee = app(EmployeeRepository::class)->find($item['employee_id']);
            $department_name = app(Department::class)->find($item['department_id'])->name;
            $position_name = app(Position::class)->find($item['position_id'])->name;
            $approved = $item['approved']; 

           
            $worksalary = $item['worksalary']; 
            $extrasalary = $item['extrasalary']; 
            $numworkday_salary = $item['numworkday_salary']; 
            $numworkday = $item['numworkday'];  
            $sum_salary = $item['totalsalary'];  
            $bhxh = $item['bhxh']; 
            $bhtnld_bnn = $item['bhtnld_bnn']; 
            $bhyt = $item['bhyt']; 
            $bhtn = $item['bhtn'];          
            $luongthuclinh = $item['luongthuclinh'];   
            $phucap = $item['phucap']; 
            $thucnhankynay = $item['thucnhankynay']; 
             
          
            $total_bhxh += $bhxh; 
            $total_bhtnld_bnn += $bhtnld_bnn; 
            $total_bhyt += $bhyt; 
            $total_bhtn += $bhtn; 

            $total_sum_salary += $sum_salary;
            $total_luongthuclinh += $luongthuclinh; 
            $total_phucap += $extrasalary;  
            $total_thucnhankynay += $thucnhankynay; 

            $dataArrayItem = [
                'id' => $item['id'],
                'month' => $month,
                'year' => $year,
                'employee_id' => $item['employee_id'],
                'fullname' => $employee->fullname,
                'department_id' => $item['department_id'],
                'department_name' => $department_name,
                'position_id' => $item['position_id'],
                'position_name' => $position_name,
                'worksalary' => $worksalary,
                'extrasalary' => $extrasalary,
                'numworkday_salary' => $numworkday_salary,
                'numworkday' => $numworkday,
                'bhxh' => $bhxh,
                'bhtnld_bnn' => $bhtnld_bnn,
                'bhyt' => $bhyt,
                'bhtn' => $bhtn,
                'sum_salary' => $sum_salary,
                'luongthuclinh' => $luongthuclinh,
                'phucap' => $phucap,
                'thucnhankynay' => $thucnhankynay,
                'approved' => $approved
            ];

           
            $reportList[] = $dataArrayItem; 
        }

        $reportListSum = array (
                'bhxh' => $total_bhxh,
                'bhtnld_bnn' => $total_bhtnld_bnn,
                'bhyt' => $total_bhyt,
                'bhtn' => $total_bhtn,
                'sum_salary' => $total_sum_salary,
                'luongthuclinh' => $total_luongthuclinh,
                'phucap' => $total_phucap,
                'thucnhankynay' => $total_thucnhankynay
        );


        $reportListFinish[] = $reportList;
        $reportListFinish[] = $reportListSum;       

        return $reportListFinish;
    }

    /**
     * createMonthSalary
     * 
     * @author  linh
     * @param   string $month
     * @param   string $year
     * @return  boolean
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function createMonthSalary($month, $year)
    {
      
        $reportListFinish = array();
        $reportListFinish = $this->processMonthSalary($month, $year);
        $reportList = $reportListFinish[0];
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);
        
        for($i=0; $i<count($reportList); $i++){
            $item = $reportList[$i];
            $worksalary = $item['worksalary']; 
            $extrasalary = $item['extrasalary']; 
            $numworkday_salary = $item['numworkday_salary']; 
            $numworkday = $item['numworkday'];  
            $sum_salary = $item['sum_salary'];  
            $bhxh = $item['bhxh']; 
            $bhtnld_bnn = $item['bhtnld_bnn']; 
            $bhyt = $item['bhyt']; 
            $bhtn = $item['bhtn'];          
            $luongthuclinh = $item['luongthuclinh'];   
            $phucap = $item['phucap']; 
            $thucnhankynay = $item['thucnhankynay']; 
    
            $data = [
                'month' => $month,
                'year' => $year,
                'employee_id' => $item['id'],
                'department_id' => $item['department_id'],
                'position_id' => $item['position_id'],
                'worksalary' => $worksalary,
                'extrasalary' => $extrasalary,
                'numworkday_salary' => $numworkday_salary,
                'numworkday' => $numworkday,
                'bhxh' => $bhxh,
                'bhtnld_bnn' => $bhtnld_bnn,
                'bhyt' => $bhyt,
                'bhtn' => $bhtn,
                'totalsalary' => $sum_salary,
                'luongthuclinh' => $luongthuclinh,
                'phucap' => $phucap,
                'thucnhankynay' => $thucnhankynay,
                'created_user_id' => $created_user_id,
                'updated_user_id' => $updated_user_id
            ];

            $ret = $this->repository->create($data);
        }
        
        return true;
    }

    /**
     * approvedMonthSalary
     * 
     * @author  linh
     * @param   string $month
     * @param   string $year
     * @param   string $approved
     * @return  boolean
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function approvedMonthSalary($month, $year, $approved)
    {
        $approved_user_id = quote_smart(Auth()->user()->id);
        $approved_at = Carbon::today()->toDateTimeString(); 

        \DB::table('ns_monthsalarys')
            ->where('month', '=', $month)
            ->where('year', '=', $year)
            ->update(['approved' => $approved, 'approved_user_id' => $approved_user_id, 'approved_at' => $approved_at]);

        return true;
    }

    /**
     * deleteMonthSalary
     * 
     * @author  linh
     * @param   string $month
     * @param   string $year
     * @return  boolean
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function deleteMonthSalary($month, $year)
    {
        \DB::table('ns_monthsalarys')
            ->where('month', '=', $month)
            ->where('year', '=', $year)
            ->delete();

        return true;
    }
    
    /**
     * update
     * 
     * @author  linh
     * @param   Request $request
     * @param   string $id
     * @param   string $approved
     * @return  boolean
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function update($request, $id)
    {

        $numworkday_salary = (removeFormatNumber($request->numworkday_salary) == '' ? '0' : removeFormatNumber($request->numworkday_salary));
        $numworkday = (removeFormatNumber($request->numworkday) == '' ? '0' : removeFormatNumber($request->numworkday));
        $totalsalary = (removeFormatNumber($request->totalsalary) == '' ? '0' : removeFormatNumber($request->totalsalary));
        $luongthuclinh = (removeFormatNumber($request->luongthuclinh) == '' ? '0' : removeFormatNumber($request->luongthuclinh));
        $phucap = (removeFormatNumber($request->phucap) == '' ? '0' : removeFormatNumber($request->phucap));
        $thucnhankynay = (removeFormatNumber($request->thucnhankynay) == '' ? '0' : removeFormatNumber($request->thucnhankynay));
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'numworkday_salary' => $numworkday_salary,
            'numworkday' => $numworkday,
            'totalsalary' => $totalsalary,
            'luongthuclinh' => $luongthuclinh,
            'phucap' => $phucap,
            'thucnhankynay' => $thucnhankynay,
            'updated_user_id' => $updated_user_id
        ];

        return $this->repository->update($data, $id);
    }                 
}
