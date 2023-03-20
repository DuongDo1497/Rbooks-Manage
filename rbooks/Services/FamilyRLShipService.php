<?php

namespace RBooks\Services;

use RBooks\Repositories\FamilyRLShipRepository;
use \Auth;
use \DB;
use Carbon\Carbon;
use RBooks\Models\Employee;
use Illuminate\Support\Facades\Crypt;

class FamilyRLShipService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(FamilyRLShipRepository::class);
    }

    public function create($request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $employee_id = quote_smart($employeeid_decrypt);        
        $employee = app(Employee::class)->find($employeeid_decrypt);
        $department_id = quote_smart($employee->department()->first()->id);

        $relation = quote_smart($request->relation);
        $fullname = quote_smart($request->fullname);
        $birthday = quote_smart($request->birthday);
        $address = quote_smart($request->address);
        $work = quote_smart($request->work);
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'employee_id' => $employeeid_decrypt,
            'relation' => $relation,
            'fullname' => $fullname,
            'birthday' => $birthday,
            'address' => $address,
            'work' => $work,
            'created_user_id' => $created_user_id,
            'updated_user_id' => $updated_user_id,
        ];

        return $this->repository->create($data);
    }

    public function update($request, $id)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $relation = quote_smart($request->relation);
        $fullname = quote_smart($request->fullname);
        $birthday = quote_smart($request->birthday);
        $address = quote_smart($request->address);
        $work = quote_smart($request->work);
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'relation' => $relation,
            'fullname' => $fullname,            
            'birthday' => $birthday,
            'address' => $address,
            'work' => $work,
            'updated_user_id' => $updated_user_id,
        ];

        return $this->repository->update($data, $id);
    }

       
    public function getFamilyRLShips($id)
    {
        $collections = $this->repository->findByField('employee_id', $id); 
        return $collections;    
    }    
}
