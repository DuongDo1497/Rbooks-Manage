<?php

namespace RBooks\Services;

use RBooks\Repositories\DepartmentRepository;
use \Auth;
use \DB;

class DepartmentService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(DepartmentRepository::class);
    }

    /**
     * Create new dept
     *
     * @param object $request
     * @return \App\Models\Department
     */
    public function create($request)
    {
        $recordlast = $this->repository->get()->last();
        $recordlastt = (int) $recordlast->order_full + 1;
        $data = [
            'code' => $request->code,
            'name' => $request->name,
            'order_full' => $recordlastt,
            'created_user_id' => Auth::user()->id,
            'updated_user_id' => Auth::user()->id
        ];

        return $this->repository->create($data);
    }

    public function update($request, $id)
    {
        $order_full = $this->repository->find($id);
        $data = [
            'code' => $request->code,
            'name' => $request->name,
            'order_full' => $order_full->order_full,
            'created_user_id' => $order_full->created_user_id,
            'updated_user_id' => Auth::user()->id
        ];

        return $this->repository->update($data, $id);
    }
}
