<?php

namespace RBooks\Services;

use RBooks\Repositories\LaborContractRepository;
use \Auth;
use \DB;
use Carbon\Carbon;
use RBooks\Models\Employee;
use Illuminate\Support\Facades\Crypt;

class LaborContractService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(LaborContractRepository::class);
    }

    public function create($request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $employee_id = quote_smart($employeeid_decrypt);        
        $employee = app(Employee::class)->find($employeeid_decrypt);
        $department_id = quote_smart($employee->department()->first()->id);

        $labortype = quote_smart($request->labortype);
        $fromdate = quote_smart($request->fromdate);
        $todate = quote_smart($request->todate);
        $description = quote_smart($request->description);
        $active = ($request->active == '1' ? $request->active : '0');        
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'employee_id' => $employeeid_decrypt,
            'labortype' => $labortype,
            'fromdate' => $fromdate,
            'todate' => $todate,
            'description' => $description,
            'active' => $active,            
            'created_user_id' => $created_user_id,
            'updated_user_id' => $updated_user_id,
        ];

        if ($request->active == '1'){
            $this->updateActiveLaborContracts($employeeid_decrypt, 0);          
        }

        return $this->repository->create($data);
    }

    public function update($request, $id)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $labortype = quote_smart($request->labortype);
        $fromdate = quote_smart($request->fromdate);
        $todate = quote_smart($request->todate);
        $description = quote_smart($request->description);
        $active = ($request->active == '1' ? $request->active : '0');        
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'labortype' => $labortype,
            'fromdate' => $fromdate,
            'todate' => $todate,
            'description' => $description,
            'active' => $active,
            'updated_user_id' => $updated_user_id,
        ];

        if ($request->active == '1'){
            $this->updateActiveLaborContracts($employeeid_decrypt, 0);          
        }

        return $this->repository->update($data, $id);
    }

    public function updateActiveLaborContracts($employee_id, $activevalue)
    {
        \DB::table('ns_laborcontracts')
            ->where('employee_id', '=', $employee_id)
            ->update(['active' => $activevalue]);
    }
        
    public function getLaborContracts($id)
    {
        $collections = $this->repository->findByField('employee_id', $id); 
        return $collections;    
    }    
}
