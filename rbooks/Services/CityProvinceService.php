<?php

namespace RBooks\Services;

use RBooks\Repositories\CityProvinceRepository;
use \Auth;

class CityProvinceService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(CityProvinceRepository::class);
    }
}
