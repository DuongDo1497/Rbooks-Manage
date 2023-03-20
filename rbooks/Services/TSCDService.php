<?php

namespace RBooks\Services;

use RBooks\Repositories\TSCDRepository;
use \Auth;
use \DB;

class TSCDService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(TSCDRepository::class);
    }

    /**
     * Create new dept
     *
     * @param object $request
     * @return \App\Models\Recruitment
     */
    public function create($request)
    {
        $data = [
            'code' => $request->code,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'position' => $request->position,
            'status' => 1,
            'note' => $request->note,
            'created_user_id' => Auth()->user()->id,
        ];
        $this->repository->create($data);
    }

    public function update($request, $id)
    {
        $tscd = $this->repository->find($id);
        $data = [
            'code' => $request->code,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'position' => $request->position,
            'status' => $request->status,
            'note' => $request->note,
            'updated_user_id' => Auth()->user()->id,
        ];
        $this->repository->update($data, $id);
    }
}
