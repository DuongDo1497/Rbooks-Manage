<?php

namespace RBooks\Services;

use RBooks\Repositories\SecurityResourcesRepository;
use \Auth;
use \DB;
use Carbon\Carbon;
use RBooks\Models\Employee;
use Illuminate\Support\Facades\Crypt;

class SecurityResourcesService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(SecurityResourcesRepository::class);
    }

    public function getSecurityResources($id)
    {
        $collections = $this->repository->findByField('resourcecode', $id); 
        return $collections;    
    }  
    
    public function create($request)
    {

        $rolecode = quote_smart($request->rolecode);
        $resourcecode = quote_smart($request->resourcecode);
        $filename = quote_smart($request->filename);
        $cview = quote_smart($request->cview);
        $cadd = quote_smart($request->cadd);
        $cdelete = quote_smart($request->cdelete);
        $cupdate = quote_smart($request->cupdate);
        $capprove = quote_smart($request->capprove);

        $cuserview = $request->cuserview;
        if (isset($cuserview) and count($cuserview) > 0){
            $scuserview = implode(",", $cuserview);
        }else{
        	$scuserview = '';
        }
        $cuserview = quote_smart($scuserview);
        $description = quote_smart($request->description);
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'rolecode' => $rolecode,
            'resourcecode' => $resourcecode,
            'filename' => $filename,
            'cview' => $cview,
            'cadd' => $cadd,
            'cdelete' => $cdelete,
            'cupdate' => $cupdate,
            'capprove' => $capprove,
            'cuserview' => $cuserview,
            'description' => $description,
            'created_user_id' => $created_user_id,
            'updated_user_id' => $updated_user_id,
        ];

        return $this->repository->create($data);
    }

    public function update($request, $id)
    {

        $rolecode = quote_smart($request->rolecode);
        $resourcecode = quote_smart($request->resourcecode);
        $filename = quote_smart($request->filename);
        $cview = quote_smart($request->cview);
        $cadd = quote_smart($request->cadd);
        $cdelete = quote_smart($request->cdelete);
        $cupdate = quote_smart($request->cupdate);
        $capprove = quote_smart($request->capprove);

        $cuserview = $request->cuserview;
        if (isset($cuserview) and count($cuserview) > 0){
            $scuserview = implode(",", $cuserview);
        }else{
            $scuserview = '';
        }

        $cuserview = quote_smart($scuserview);
        $description = quote_smart($request->description);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'rolecode' => $rolecode,
            'resourcecode' => $resourcecode,
            'filename' => $filename,
            'cview' => $cview,
            'cadd' => $cadd,
            'cdelete' => $cdelete,
            'cupdate' => $cupdate,
            'capprove' => $capprove,
            'cuserview' => $cuserview,
            'description' => $description,
            'updated_user_id' => $updated_user_id,
        ];

        return $this->repository->update($data, $id);
    }

}
