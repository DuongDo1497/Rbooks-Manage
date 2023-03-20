<?php

namespace RBooks\Services;

use RBooks\Repositories\EmplperdayRepository;
use \Auth;
use \DB;
use Carbon\Carbon;

class EmplperdayService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(EmplperdayRepository::class);
    }

    /**
     * Create new dept
     *
     * @param object $request
     * @return \App\Models\Dept
     */
    public function create($request)
    {
        $data = [
            'year' => Carbon::now()->year,
            'employee_id' => $request->employee_id,
            'permission_lastyear' => $request->permission_lastyear,
            'permission_curryear' => $request->permission_curryear,
            'permission_leave' => $request->permission_leave,
            'permission_left' => $request->permission_left,
            'created_user_id' => Auth()->user()->id,
            'updated_user_id' => Auth()->user()->id,
        ];

        return $this->repository->create($data);
    }

    public function update($request, $id)
    {
        $permissionday = $this->repository->find($id);
        $data = [
            'year' => Carbon::now()->year,
            'employee_id' => $request->employee_id,
            'permission_lastyear' => $request->permission_lastyear,
            'permission_curryear' => $request->permission_curryear,
            'permission_leave' => $request->permission_leave,
            'permission_left' => $request->permission_left,
            'created_user_id' => $permissionday->created_user_id,
            'updated_user_id' => Auth()->user()->id,
        ];

        return $this->repository->update($data, $id);
    }

    public function getPaginate($limit = null, $columns = ['*'])
    {
        $repository = $this->getRepository();
        return $repository->orderBy('id', 'desc')->paginate($limit, $columns);
    }

}
