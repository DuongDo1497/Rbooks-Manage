<?php

namespace RBooks\Services;

use RBooks\Repositories\DivisionRepository;
use \Auth;
use \DB;

class DivisionService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(DivisionRepository::class);
    }

    /**
     * Create new dept
     *
     * @param object $request
     * @return \App\Models\Division
     */
    public function create($request)
    {
        $data = [
            'code_division' => $request->code_division,
            'name' => $request->name,
            'department_id' => $request->department_id,
            'updated_user_id' => Auth::user()->id
        ];
        return $this->repository->create($data);
    }

    public function update($request, $id)
    {
        $data = [
            'code_division' => $request->code_division,
            'name' => $request->name,
            'department_id' => $request->department_id,
            'updated_user_id' => Auth::user()->id
        ];
        return $this->repository->update($data, $id);
    }
}
