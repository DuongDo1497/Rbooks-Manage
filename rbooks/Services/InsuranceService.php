<?php

namespace RBooks\Services;

use RBooks\Repositories\InsuranceRepository;
use \Auth;
use \DB;
use Carbon\Carbon;
use RBooks\Models\Employee;
use Illuminate\Support\Facades\Crypt;

class InsuranceService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(InsuranceRepository::class);
    }

    public function create($request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $employee_id = quote_smart($employeeid_decrypt);        
        $employee = app(Employee::class)->find($employeeid_decrypt);

        $department_id = quote_smart($employee->department()->first()->id);

        $salaryinsurance = (removeFormatNumber($request->salaryinsurance) == '' ? '0' : removeFormatNumber($request->salaryinsurance));
        $extrainsurance = (removeFormatNumber($request->extrainsurance) == '' ? '0' : removeFormatNumber($request->extrainsurance));
        $description = quote_smart($request->description);
        $active = ($request->active == '1' ? $request->active : '0');
        $effectdate = quote_smart($request->effectdate);
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'department_id' => $department_id,
            'employee_id' => $employeeid_decrypt,
            'salaryinsurance' => $salaryinsurance,
            'extrainsurance' => $extrainsurance,
            'description' => $description,
            'active' => $active,
            'effectdate' => $effectdate,
            'created_user_id' => $created_user_id,
            'updated_user_id' => $updated_user_id,
        ];

        if ($request->active == '1'){
            $this->updateActiveInsurances($employeeid_decrypt, 0);        	
        }

        return $this->repository->create($data);
    }

    public function update($request, $id)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $salaryinsurance = (removeFormatNumber($request->salaryinsurance) == '' ? '0' : removeFormatNumber($request->salaryinsurance));
        $extrainsurance = (removeFormatNumber($request->extrainsurance) == '' ? '0' : removeFormatNumber($request->extrainsurance));
        $description = quote_smart($request->description);
        $active = ($request->active == '1' ? $request->active : '0');
        $effectdate = quote_smart($request->effectdate);
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'salaryinsurance' => $salaryinsurance,
            'extrainsurance' => $extrainsurance,
            'description' => $description,
            'active' => $active,
            'effectdate' => $effectdate,
            'created_user_id' => $created_user_id,
            'updated_user_id' => $updated_user_id,
        ];

        if ($request->active == '1'){
            $this->updateActiveInsurances($employeeid_decrypt, 0);           
        }
        
        return $this->repository->update($data, $id);
    }
    
    public function updateActiveInsurances($employee_id, $activevalue)
    {
        \DB::table('ns_profileinsurances')
            ->where('employee_id', '=', $employee_id)
            ->update(['active' => $activevalue]);
    }

    public function getInsurances($id)
    {
        $collections = $this->repository->findByField('employee_id', $id); 
        return $collections;    
    }
        
}
