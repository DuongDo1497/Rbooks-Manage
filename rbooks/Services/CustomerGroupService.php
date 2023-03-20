<?php

namespace RBooks\Services;

use RBooks\Repositories\CustomerGroupRepository;
use \Auth;

class CustomerGroupService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(CustomerGroupRepository::class);
    }

    public function create($request)
    {
        $data =[
            'name' => $request->name,
            'code' => $request->code,
            'updated_user_id' => Auth::user()->id
        ];

        $customergroup = $this->repository->create($data);
        return $customergroup;
    }

    public function update($request, $id)
    {
        $data =[
            'name' => $request->name,
            'code' => $request->code,
            'updated_user_id' => Auth::user()->id
        ];

        $customergroup = $this->repository->update($data, $id);
        return $customergroup;
    }
}
