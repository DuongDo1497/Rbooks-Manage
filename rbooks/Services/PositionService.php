<?php

namespace RBooks\Services;

use RBooks\Repositories\PositionRepository;
use \Auth;
use \DB;

class PositionService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(PositionRepository::class);
    }

    /**
     * Create new dept
     *
     * @param object $request
     * @return \App\Models\Position
     */
    public function create($request)
    {
        $data = [
            'code_position' => $request->code_position,
            'name' => $request->name,
            'updated_user_id' => Auth::user()->id
        ];
        return $this->repository->create($data);
    }

    public function update($request, $id)
    {
        $data = [
            'code_position' => $request->code_position,
            'name' => $request->name,
            'updated_user_id' => Auth::user()->id
        ];
        return $this->repository->update($data, $id);
    }

}
