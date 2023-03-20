<?php

namespace RBooks\Services;

use RBooks\Repositories\CheckTypeRepository;
use \Auth;

class CheckTypeService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(CheckTypeRepository::class);
    }
}
