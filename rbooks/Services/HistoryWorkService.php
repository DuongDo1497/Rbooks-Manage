<?php

namespace RBooks\Services;

use RBooks\Repositories\HistoryWorkRepository;
use \Auth;
use \DB;
use Carbon\Carbon;
use RBooks\Models\Employee;
use Illuminate\Support\Facades\Crypt;

class HistoryWorkService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(HistoryWorkRepository::class);
    }

    public function create($request)
    {

        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);
        $employee_id = quote_smart($employeeid_decrypt);        
        $employee = app(Employee::class)->find($employeeid_decrypt);

        $department_id = quote_smart($request->department_id);
        $position_id = quote_smart($request->position_id);
        $nummonths = quote_smart($request->nummonths);
        $fromdate = quote_smart($request->fromdate);
        $todate = quote_smart($request->todate);
        $description = quote_smart($request->description);
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'employee_id' => $employeeid_decrypt,
            'department_id' => $department_id,
            'position_id' => $position_id,
            'nummonths' => $nummonths,
            'fromdate' => $fromdate,
            'todate' => $todate,
            'description' => $description,
            'created_user_id' => $created_user_id,
            'updated_user_id' => $updated_user_id,
        ];

        return $this->repository->create($data);
    }

    public function update($request, $id)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $department_id = quote_smart($request->department_id);
        $position_id = quote_smart($request->position_id);
        $nummonths = quote_smart($request->nummonths);
        $fromdate = quote_smart($request->fromdate);
        $todate = quote_smart($request->todate);
        $description = quote_smart($request->description);
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'department_id' => $department_id,
            'position_id' => $position_id,
            'nummonths' => $nummonths,
            'fromdate' => $fromdate,
            'todate' => $todate,
            'description' => $description,
            'updated_user_id' => $updated_user_id,
        ];

        return $this->repository->update($data, $id);
    }

        
    public function getHistoryWorks($id)
    {
        $collections = $this->repository->findByField('employee_id', $id); 
        return $collections;    
    }    
}
