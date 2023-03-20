<?php

namespace RBooks\Services;

use RBooks\Repositories\DisciplineRepository;
use \Auth;
use \DB;
use Carbon\Carbon;
use RBooks\Models\Employee;
use Illuminate\Support\Facades\Crypt;

class DisciplineService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(DisciplineRepository::class);
    }

    public function create($request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $employee_id = quote_smart($employeeid_decrypt);        
        $employee = app(Employee::class)->find($employeeid_decrypt);
        $department_id = quote_smart($employee->department()->first()->id);

        $fromdate = quote_smart($request->fromdate);
        $disciplinenumber = quote_smart($request->disciplinenumber);
        $contentdiscipline = quote_smart($request->contentdiscipline);
        $formdiscipline = quote_smart($request->formdiscipline);
        $description = quote_smart($request->description);
        $checktype_id = quote_smart($request->checktype_id);
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'employee_id' => $employeeid_decrypt,
            'fromdate' => $fromdate,
            'disciplinenumber' => $disciplinenumber,
            'contentdiscipline' => $contentdiscipline,
            'formdiscipline' => $formdiscipline,
            'description' => $description,
            'checktype_id' => $checktype_id,
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
        $disciplinenumber = quote_smart($request->disciplinenumber);
        $contentdiscipline = quote_smart($request->contentdiscipline);
        $formdiscipline = quote_smart($request->formdiscipline);
        $description = quote_smart($request->description);
        $checktype_id = quote_smart($request->checktype_id);
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'fromdate' => $fromdate,
            'disciplinenumber' => $disciplinenumber,
            'contentdiscipline' => $contentdiscipline,
            'formdiscipline' => $formdiscipline,
            'description' => $description,
            'checktype_id' => $checktype_id,
            'updated_user_id' => $updated_user_id,
        ];

        return $this->repository->update($data, $id);
    }

    public function getDisciplines($id)
    {
        $collections = $this->repository->findByField('employee_id', $id); 
        return $collections;    
    }    
}
