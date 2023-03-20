<?php

namespace RBooks\Services;

use RBooks\Repositories\PayrollRepository;
use \Auth;
use \DB;
use Carbon\Carbon;
use RBooks\Models\Employee;
use Illuminate\Support\Facades\Crypt;

class PayrollService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(PayrollRepository::class);
    }

    public function create($request)
    {

        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $employee_id = quote_smart($employeeid_decrypt);        
        $employee = app(Employee::class)->find($employeeid_decrypt);
        $department_id = quote_smart($employee->department()->first()->id);

        $code = quote_smart($request->code);
        $level = quote_smart($request->level);
        $worksalary = (removeFormatNumber($request->worksalary) == '' ? '0' : removeFormatNumber($request->worksalary));
        $extrasalary = (removeFormatNumber($request->extrasalary) == '' ? '0' : removeFormatNumber($request->extrasalary));
        $description = quote_smart($request->description);
        $active = ($request->active == '1' ? $request->active : '0');
        $effectdate = quote_smart($request->effectdate);
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'department_id' => $department_id,
            'employee_id' => $employeeid_decrypt,
            'code' => $code,
            'level' => $level,
            'worksalary' => $worksalary,
            'extrasalary' => $extrasalary,
            'description' => $description,
            'active' => $active,
            'effectdate' => $effectdate,
            'created_user_id' => $created_user_id,
            'updated_user_id' => $updated_user_id,
        ];

        if ($request->active == '1'){
            $this->updateActivePayrolls($employeeid_decrypt, 0);         
        }

        return $this->repository->create($data);
    }

    public function update($request, $id)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $code = quote_smart($request->code);
        $level = quote_smart($request->level);
        $worksalary = (removeFormatNumber($request->worksalary) == '' ? '0' : removeFormatNumber($request->worksalary));
        $extrasalary = (removeFormatNumber($request->extrasalary) == '' ? '0' : removeFormatNumber($request->extrasalary));
        $description = quote_smart($request->description);
        $active = ($request->active == '1' ? $request->active : '0');
        $effectdate = quote_smart($request->effectdate);
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'code' => $code,
            'level' => $level,
            'worksalary' => $worksalary,
            'extrasalary' => $extrasalary,
            'description' => $description,
            'active' => $active,
            'effectdate' => $effectdate,
            'created_user_id' => $created_user_id,
            'updated_user_id' => $updated_user_id,
        ];

        if ($request->active == '1'){
            $this->updateActivePayrolls($employeeid_decrypt, 0);           
        }
        
        return $this->repository->update($data, $id);
    }
    
    public function updateActivePayrolls($employee_id, $activevalue)
    {
        \DB::table('ns_profilesalarys')
            ->Where('employee_id', '=', $employee_id)
            ->update(['active' => $activevalue]);
    }

    public function getPayrolls($id)
    {
        $collections = $this->repository->findByField('employee_id', $id); 
        return $collections;    
    }    
}
