<?php

namespace RBooks\Services;

use \Auth;
use \DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use RBooks\Repositories\FunctionAssignmentRepository;

class FunctionAssignmentService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(FunctionAssignmentRepository::class);
    }

    public function getFunctionAssignment($id)
    {
        $collections = $this->repository->orderBy('displayorder')->findByField('applicationfunctiongroupid', $id); 
        return $collections;    
    }  
    
    public function create($request)
    {

        $applicationfunctiongroupid = quote_smart($request->applicationfunctiongroupid);
        $applicationresourceid = quote_smart($request->applicationresourceid);
        $displayorder = $request->displayorder;
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'applicationfunctiongroupid' => $applicationfunctiongroupid,
            'applicationresourceid' => $applicationresourceid,
            'displayorder' => $displayorder,
            'created_user_id' => $created_user_id,
            'updated_user_id' => $updated_user_id,
        ];

        return $this->repository->create($data);
    }

    public function update($request, $id)
    {

        $applicationfunctiongroupid = quote_smart($request->applicationfunctiongroupid);
        $applicationresourceid = quote_smart($request->applicationresourceid);
        $displayorder = $request->displayorder;
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'applicationfunctiongroupid' => $applicationfunctiongroupid,
            'applicationresourceid' => $applicationresourceid,
            'displayorder' => $displayorder,
            'updated_user_id' => $updated_user_id,
        ];

        return $this->repository->update($data, $id);
    }

}
