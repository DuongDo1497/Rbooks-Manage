<?php

namespace RBooks\Services;

use \Auth;
use \DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use RBooks\Repositories\ApplicationFunctionGroupsRepository;

class ApplicationFunctionGroupsService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(ApplicationFunctionGroupsRepository::class);
    }

    public function getApplicatinFunctionGroups($id)
    {
        $collections = $this->repository->findByField('applicationmoduleid', $id)->sortBy('displayorder'); 
        return $collections;    
    }  
    
    public function create($request)
    {

        $applicationmoduleid = quote_smart($request->applicationmoduleid);
        $name = quote_smart($request->name);
        $displayorder = $request->displayorder;
        $image = $request->image;
        $applicationresourceid = quote_smart($request->applicationresourceid);
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'applicationmoduleid' => $applicationmoduleid,
            'name' => $name,
            'displayorder' => $displayorder,
            'image' => $image,
            'applicationresourceid' => $applicationresourceid,
            'created_user_id' => $created_user_id,
            'updated_user_id' => $updated_user_id,
        ];

        return $this->repository->create($data);
    }

    public function update($request, $id)
    {

        $applicationmoduleid = quote_smart($request->applicationmoduleid);
        $name = quote_smart($request->name);
        $displayorder = $request->displayorder;
        $image = $request->image;
        $applicationresourceid = quote_smart($request->applicationresourceid);
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'applicationmoduleid' => $applicationmoduleid,
            'name' => $name,
            'displayorder' => $displayorder,
            'image' => $image,
            'applicationresourceid' => $applicationresourceid,
            'updated_user_id' => $updated_user_id,
        ];

        return $this->repository->update($data, $id);
    }

}
