<?php

namespace RBooks\Services;

use \Auth;
use \DB;
use Carbon\Carbon;
use RBooks\Repositories\InsuranceConfigRepository;
use RBooks\Models\InsuranceConfig;

class InsuranceConfigService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(InsuranceConfigRepository::class);
    }



  
}
