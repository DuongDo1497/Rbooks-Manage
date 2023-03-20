<?php

namespace RBooks\Services;

use RBooks\Repositories\ExperienceRepository;
use \Auth;
use \DB;
use Carbon\Carbon;
use RBooks\Models\Employee;
use Illuminate\Support\Facades\Crypt;

class ExperienceService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(ExperienceRepository::class);
    }

    public function create($request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $employee_id = quote_smart($employeeid_decrypt);        
        $employee = app(Employee::class)->find($employeeid_decrypt);
        $department_id = quote_smart($employee->department()->first()->id);

        $fromdate = quote_smart($request->fromdate);
        $todate = quote_smart($request->todate);
        $companyname = quote_smart($request->companyname);
        $major = quote_smart($request->major);
        $description = quote_smart($request->description);
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'employee_id' => $employeeid_decrypt,
            'fromdate' => $fromdate,
            'todate' => $todate,
            'companyname' => $companyname,
            'major' => $major,
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

        $fromdate = quote_smart($request->fromdate);
        $todate = quote_smart($request->todate);
        $companyname = quote_smart($request->companyname);
        $major = quote_smart($request->major);
        $description = quote_smart($request->description);
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'fromdate' => $fromdate,
            'todate' => $todate,
            'companyname' => $companyname,
            'major' => $major,
            'description' => $description,
            'updated_user_id' => $updated_user_id,
        ];

        return $this->repository->update($data, $id);
    }

    public function getExperiences($id)
    {
        $collections = $this->repository->findByField('employee_id', $id); 
        return $collections;    
    }    
}
