<?php

namespace RBooks\Services;

use RBooks\Repositories\AttributeRepository;
use \Auth;

class AttributeService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(AttributeRepository::class);
    }

    public function create($request)
    {
        $data = [
            'name' => $request->name,
            'type' => $request->type,
            'option' => $request->option,
            'updated_user_id' => Auth::user()->id
        ];

        $attribute = $this->repository->create($data);

        return $attribute;
    }

    public function update($request, $id)
    {
        $data = [
            'name' => $request->name,
            'type' => $request->type,
            'option' => $request->option,
            'updated_user_id' => Auth::user()->id
        ];

        $attribute = $this->repository->update($data, $id);

        return $attribute;
    }
}

