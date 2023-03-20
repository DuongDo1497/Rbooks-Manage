<?php

namespace RBooks\Services;

use RBooks\Repositories\ApplicationModulesRepository;
use \Auth;
use \DB;

class ApplicationModulesService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(ApplicationModulesRepository::class);
    }

    public function getPaginate($limit = null, $columns = ['*'])
    {
        $repository = $this->getRepository();
        return $repository->orderBy('displayorder', 'asc')->paginate($limit, $columns);
    }
        
    public function create($request)
    {

        $code = quote_smart($request->code);
        $applicationmodulename = quote_smart($request->applicationmodulename);
        $displayorder = $request->displayorder;
        $hidden = ($request->hidden == '1' ? $request->hidden : '0');        
        $image = $request->image;
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'code' => $code,
            'applicationmodulename' => $applicationmodulename,
            'displayorder' => $displayorder,
            'hidden' => $hidden,
            'image' => $image,
            'created_user_id' => $created_user_id,
            'updated_user_id' => $updated_user_id,
        ];

        return $this->repository->create($data);
    }

    public function update($request, $id)
    {

        $code = quote_smart($request->code);
        $applicationmodulename = quote_smart($request->applicationmodulename);
        $displayorder = $request->displayorder;
        $hidden = ($request->hidden == '1' ? $request->hidden : '0');        
        $image = $request->image;
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'code' => $code,
            'applicationmodulename' => $applicationmodulename,
            'displayorder' => $displayorder,
            'hidden' => $hidden,
            'image' => $image,
            'updated_user_id' => $updated_user_id,
        ];

        return $this->repository->update($data, $id);
    }

}
