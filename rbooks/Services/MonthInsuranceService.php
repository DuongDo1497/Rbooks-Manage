<?php

namespace RBooks\Services;

use \Auth;
use \DB;
use Carbon\Carbon;
use RBooks\Repositories\MonthInsuranceRepository;
use RBooks\Repositories\InsuranceConfigRepository;
use RBooks\Repositories\EmployeeRepository;
use RBooks\Models\MonthInsurance;
use RBooks\Models\Insurances;
use RBooks\Models\InsuranceConfig;
use RBooks\Models\Department;
use RBooks\Models\Position;
use RBooks\Models\Employee;
use RBooks\Services\InsuranceService;
use RBooks\Services\InsuranceConfigService;

class MonthInsuranceService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(MonthInsuranceRepository::class);
    }

    /**
     * createMonthInsurance
     * 
     * @author  linh
     * @param   string $month
     * @param   string $year
     * @return  boolean
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function createMonthInsurance($month, $year)
    {
        $reportListFinish = array();
        $reportListFinish = $this->processMonthInsurance($month, $year);
        $reportList = $reportListFinish[0];

        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);
        
        for($i=0; $i<count($reportList); $i++){
            $item = $reportList[$i];
    
            $data = [
                'month' => $month,
                'year' => $year,
                'department_id' => $item['department_id'],
                'position_id' => $item['position_id'],
                'employee_id' => $item['id'],
                'salaryinsurance' => $item['salary_insurance'],
                'bhxh' => $item['bhxh_nld'],
                'bhxh_cn' => $item['bhxh_ct'],
                'bhtnld_bnn' => $item['bhtnld_bnn_nld'],
                'bhtnld_bnn_cn' => $item['bhtnld_bnn_ct'],
                'bhyt' => $item['bhyt_nld'],
                'bhyt_cn' => $item['bhyt_ct'],
                'bhtn' => $item['bhtn_nld'],
                'bhtn_cn' => $item['bhtn_ct'],
                'created_user_id' => $created_user_id,
                'updated_user_id' => $updated_user_id,
                ];

            $ret = $this->repository->create($data);
        }
        
        return true;
    }

    /**
     * checkMonthInsurance
     * 
     * @author  linh
     * @param   string $month
     * @param   string $year
     * @return  boolean
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function checkMonthInsurance($month, $year)
    {
        $data = array('month'=>$month, 'year'=>$year);
        $ret = app(MonthInsuranceRepository::class)->findWhere($data, ['approved']);
        $status = -1;//chua duoc luu
        if (count($ret) > 0){
            $status = $ret[0]->approved;//trang thai duyet hay chua duyet 0, 1            
        }

        return $status;        
    }
    
    /**
     * processMonthInsurance
     * 
     * @author  linh
     * @param   string $month
     * @param   string $year
     * @return  array
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function processMonthInsurance($month, $year)
    {

        $reportListFinish = array();
    
        $insuranceConfig = app(InsuranceConfigRepository::class)->findByField('active', 1);

        $cfg_bhxh_nld = 0; $cfg_bhxh_ct = 0; $cfg_bhtnld_bnn_nld = 0; $cfg_bhtnld_bnn_ct = 0; $cfg_bhyt_nld = 0; $cfg_bhyt_ct = 0; $cfg_bhtn_nld = 0; $cfg_bhtn_ct = 0;         
        if (count($insuranceConfig) > 0){
            $cfg_bhxh_nld = $insuranceConfig[0]->bhxh_nld;
            $cfg_bhxh_ct = $insuranceConfig[0]->bhxh_ct;
            $cfg_bhtnld_bnn_nld = $insuranceConfig[0]->bhtnld_bnn_nld;
            $cfg_bhtnld_bnn_ct = $insuranceConfig[0]->bhtnld_bnn_ct;
            $cfg_bhyt_nld = $insuranceConfig[0]->bhyt_nld;
            $cfg_bhyt_ct = $insuranceConfig[0]->bhyt_ct;
            $cfg_bhtn_nld = $insuranceConfig[0]->bhtn_nld;
            $cfg_bhtn_ct = $insuranceConfig[0]->bhtn_ct;         
        }

        $listEmployees = app(EmployeeRepository::class)->findByField('print', 3);

        $reportList = array();
        $total_bhxh_nld = 0; $total_bhxh_ct = 0; $total_bhtnld_bnn_nld = 0; $total_bhtnld_bnn_ct = 0;
        $total_bhyt_nld = 0; $total_bhyt_ct = 0; $total_bhtn_nld = 0; $total_bhtn_ct = 0;         
        $total_salary_insurance = 0; $total_insurance = 0;

        foreach($listEmployees as $employee)
        {

            $department_name = app(Department::class)->find($employee->department_id)->name;
            $position_name = app(Position::class)->find($employee->position_id)->name;

            $insurances = app(Employee::class)->find($employee->id)->insurances()->where('active', 1)->get();
           
            $salary_insurance = 0;
            if ($insurances->count() > 0){
                $salaryinsurance = $insurances[0]->salaryinsurance;
                $extrainsurance = $insurances[0]->extrainsurance;
                $salary_insurance = $salaryinsurance + $extrainsurance;
            }

            $bhxh_nld = 0; $bhxh_ct = 0; $bhtnld_bnn_nld = 0; $bhtnld_bnn_ct = 0;
            $bhyt_nld = 0; $bhyt_ct = 0; $bhtn_nld = 0; $bhtn_ct = 0;         
            $sum_insurance = 0;
            
            $bhxh_nld = $salary_insurance*$cfg_bhxh_nld/100; 
            $bhxh_ct = $salary_insurance*$cfg_bhxh_ct/100; 
            $bhtnld_bnn_nld = $salary_insurance*$cfg_bhtnld_bnn_nld/100; 
            $bhtnld_bnn_ct = $salary_insurance*$cfg_bhtnld_bnn_ct/100;
            $bhyt_nld = $salary_insurance*$cfg_bhyt_nld/100; 
            $bhyt_ct = $salary_insurance*$cfg_bhyt_ct/100; 
            $bhtn_nld = $salary_insurance*$cfg_bhtn_nld/100; 
            $bhtn_ct = $salary_insurance*$cfg_bhtn_ct/100;         

            $sum_insurance = $bhxh_nld + $bhxh_ct 
                             + $bhtnld_bnn_nld + $bhtnld_bnn_ct 
                             + $bhyt_nld + $bhyt_ct 
                             + $bhtn_nld + $bhtn_ct;                             
            
            //sum tong tung can bo
            $total_bhxh_nld += $bhxh_nld; 
            $total_bhxh_ct += $bhxh_ct; 
            $total_bhtnld_bnn_nld += $bhtnld_bnn_nld; 
            $total_bhtnld_bnn_ct += $bhtnld_bnn_ct;
            $total_bhyt_nld += $bhyt_nld; 
            $total_bhyt_ct += $bhyt_ct; 
            $total_bhtn_nld += $bhtn_nld; 
            $total_bhtn_ct += $bhtn_ct;         

            $total_insurance += $sum_insurance;
            $total_salary_insurance += $salary_insurance;

            $dataArrayItem = [
                'month' => $month,
                'year' => $year,
                'id' => $employee->id,
                'fullname' => $employee->fullname,
                'department_id' => $employee->department_id,
                'department_name' => $department_name,
                'position_id' => $employee->position_id,
                'position_name' => $position_name,
                'salary_insurance' => $salary_insurance,
                'bhxh_nld' => $bhxh_nld,
                'bhxh_ct' => $bhxh_ct,
                'bhtnld_bnn_nld' => $bhtnld_bnn_nld,
                'bhtnld_bnn_ct' => $bhtnld_bnn_ct,
                'bhyt_nld' => $bhyt_nld,
                'bhyt_ct' => $bhyt_ct,
                'bhtn_nld' => $bhtn_nld,
                'bhtn_ct' => $bhtn_ct,
                'sum_insurance' => $sum_insurance
            ];
            
            
            $reportList[] = $dataArrayItem; 
        }

        $reportListSum = array (
            'salary_insurance' => $total_salary_insurance,
            'bhxh_nld' => $total_bhxh_nld,
            'bhxh_ct' => $total_bhxh_ct,
            'bhtnld_bnn_nld' => $total_bhtnld_bnn_nld,
            'bhtnld_bnn_ct' => $total_bhtnld_bnn_ct,
            'bhyt_nld' => $total_bhyt_nld,
            'bhyt_ct' => $total_bhyt_ct,
            'bhtn_nld' => $total_bhtn_nld,
            'bhtn_ct' => $total_bhtn_ct,
            'sum_insurance' => $total_insurance
        );


        $reportListFinish[] = $reportList;
        $reportListFinish[] = $insuranceConfig[0];       
        $reportListFinish[] = $reportListSum;       

        return $reportListFinish;
    }

    /**
     * getMonthInsurance
     * 
     * @author  linh
     * @param   string $month
     * @param   string $year
     * @return  array
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function getMonthInsurance($month, $year)
    {

        $reportListFinish = array();
    
        $insuranceConfig = app(InsuranceConfigRepository::class)->findByField('active', 1);

        $cfg_bhxh_nld = 0; $cfg_bhxh_ct = 0; $cfg_bhtnld_bnn_nld = 0; $cfg_bhtnld_bnn_ct = 0; $cfg_bhyt_nld = 0; $cfg_bhyt_ct = 0; $cfg_bhtn_nld = 0; $cfg_bhtn_ct = 0;         
        if (count($insuranceConfig) > 0){
            $cfg_bhxh_nld = $insuranceConfig[0]->bhxh_nld;
            $cfg_bhxh_ct = $insuranceConfig[0]->bhxh_ct;
            $cfg_bhtnld_bnn_nld = $insuranceConfig[0]->bhtnld_bnn_nld;
            $cfg_bhtnld_bnn_ct = $insuranceConfig[0]->bhtnld_bnn_ct;
            $cfg_bhyt_nld = $insuranceConfig[0]->bhyt_nld;
            $cfg_bhyt_ct = $insuranceConfig[0]->bhyt_ct;
            $cfg_bhtn_nld = $insuranceConfig[0]->bhtn_nld;
            $cfg_bhtn_ct = $insuranceConfig[0]->bhtn_ct;         
        }

        $data = array('month'=>$month, 'year'=>$year);
        $listMonthInsurance = app(MonthInsuranceRepository::class)->findWhere($data);

        $reportList = array(); $reportListSum = array();
        $total_bhxh_nld = 0; $total_bhxh_ct = 0; $total_bhtnld_bnn_nld = 0; $total_bhtnld_bnn_ct = 0;
        $total_bhyt_nld = 0; $total_bhyt_ct = 0; $total_bhtn_nld = 0; $total_bhtn_ct = 0;         
        $total_salary_insurance = 0; $total_insurance = 0;
        $approved = "0";

        foreach($listMonthInsurance as $item)
        {
            $employee_id = $item->id;
            $employee = app(EmployeeRepository::class)->find($item['employee_id']);
            $department_name = app(Department::class)->find($item['department_id'])->name;
            $position_name = app(Position::class)->find($item['position_id'])->name;
            $approved = $item['approved']; 

            $salary_insurance = $item['salaryinsurance']; 
            $bhxh_nld = $item['bhxh']; 
            $bhxh_ct = $item['bhxh_cn']; 
            $bhtnld_bnn_nld = $item['bhtnld_bnn']; 
            $bhtnld_bnn_ct = $item['bhtnld_bnn_cn'];
            $bhyt_nld = $item['bhyt']; 
            $bhyt_ct = $item['bhyt_cn']; 
            $bhtn_nld = $item['bhtn']; 
            $bhtn_ct = $item['bhtn_cn'];         

            $sum_insurance = $bhxh_nld + $bhxh_ct 
                             + $bhtnld_bnn_nld + $bhtnld_bnn_ct 
                             + $bhyt_nld + $bhyt_ct 
                             + $bhtn_nld + $bhtn_ct;                             
            
            //sum tong tung can bo
            $total_bhxh_nld += $bhxh_nld; 
            $total_bhxh_ct += $bhxh_ct; 
            $total_bhtnld_bnn_nld += $bhtnld_bnn_nld; 
            $total_bhtnld_bnn_ct += $bhtnld_bnn_ct;
            $total_bhyt_nld += $bhyt_nld; 
            $total_bhyt_ct += $bhyt_ct; 
            $total_bhtn_nld += $bhtn_nld; 
            $total_bhtn_ct += $bhtn_ct;         

            $total_insurance += $sum_insurance;
            $total_salary_insurance += $salary_insurance;

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
                'salary_insurance' => $salary_insurance,
                'bhxh_nld' => $bhxh_nld,
                'bhxh_ct' => $bhxh_ct,
                'bhtnld_bnn_nld' => $bhtnld_bnn_nld,
                'bhtnld_bnn_ct' => $bhtnld_bnn_ct,
                'bhyt_nld' => $bhyt_nld,
                'bhyt_ct' => $bhyt_ct,
                'bhtn_nld' => $bhtn_nld,
                'bhtn_ct' => $bhtn_ct,
                'sum_insurance' => $sum_insurance,
                'approved' => $approved
            ];           
            
            $reportList[] = $dataArrayItem; 
        }

        $reportListSum = array (
            'salary_insurance' => $total_salary_insurance,
            'bhxh_nld' => $total_bhxh_nld,
            'bhxh_ct' => $total_bhxh_ct,
            'bhtnld_bnn_nld' => $total_bhtnld_bnn_nld,
            'bhtnld_bnn_ct' => $total_bhtnld_bnn_ct,
            'bhyt_nld' => $total_bhyt_nld,
            'bhyt_ct' => $total_bhyt_ct,
            'bhtn_nld' => $total_bhtn_nld,
            'bhtn_ct' => $total_bhtn_ct,
            'sum_insurance' => $total_insurance
        );

  
        $reportListFinish[] = $reportList;
        $reportListFinish[] = $insuranceConfig[0];       
        $reportListFinish[] = $reportListSum;       

        return $reportListFinish;
    }

    /**
     * approvedMonthInsurance
     * 
     * @author  linh
     * @param   string $month
     * @param   string $year
     * @param   string $approved
     * @return  boolean
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function approvedMonthInsurance($month, $year, $approved)
    {
        $approved_user_id = quote_smart(Auth()->user()->id);
        $approved_at = Carbon::today()->toDateTimeString(); 

        \DB::table('ns_monthinsurances')
            ->where('month', '=', $month)
            ->where('year', '=', $year)
            ->update(['approved' => $approved, 'approved_user_id' => $approved_user_id, 'approved_at' => $approved_at]);

        return true;
    }

    /**
     * deleteMonthInsurance
     * 
     * @author  linh
     * @param   string $month
     * @param   string $year
     * @return  boolean
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function deleteMonthInsurance($month, $year)
    {
        \DB::table('ns_monthinsurances')
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

        $bhxh = (removeFormatNumber($request->bhxh) == '' ? '0' : removeFormatNumber($request->bhxh));
        $bhxh_cn = (removeFormatNumber($request->bhxh_cn) == '' ? '0' : removeFormatNumber($request->bhxh_cn));

        $bhtnld_bnn = (removeFormatNumber($request->bhtnld_bnn) == '' ? '0' : removeFormatNumber($request->bhtnld_bnn));
        $bhtnld_bnn_cn = (removeFormatNumber($request->bhtnld_bnn_cn) == '' ? '0' : removeFormatNumber($request->bhtnld_bnn_cn));

        $bhyt = (removeFormatNumber($request->bhyt) == '' ? '0' : removeFormatNumber($request->bhyt));
        $bhyt_cn = (removeFormatNumber($request->bhyt_cn) == '' ? '0' : removeFormatNumber($request->bhyt_cn));

        $bhtn = (removeFormatNumber($request->bhtn) == '' ? '0' : removeFormatNumber($request->bhtn));
        $bhtn_cn = (removeFormatNumber($request->bhtn_cn) == '' ? '0' : removeFormatNumber($request->bhtn_cn));


        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'bhxh' => $bhxh,
            'bhxh_cn' => $bhxh_cn,
            'bhtnld_bnn' => $bhtnld_bnn,
            'bhtnld_bnn_cn' => $bhtnld_bnn_cn,
            'bhyt' => $bhyt,
            'bhyt_cn' => $bhyt_cn,
            'bhtn' => $bhtn,
            'bhtn_cn' => $bhtn_cn,
            'updated_user_id' => $updated_user_id,
            ];
        
        return $this->repository->update($data, $id);
    }    
        
}
