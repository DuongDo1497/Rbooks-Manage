<?php

namespace RBooks\Services;

use RBooks\Repositories\CpttSellRepository;
use Carbon\Carbon;
//use RBooks\Services\ImportService;
use \Auth;
use \DB;

class CpttSellService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(CpttSellRepository::class);
        //$this->importservice = app(ImportService::class);
    }

    /**
     * Create new dept
     *
     * @param object $request
     * @return \App\Models\Dept
     */
    public function create($request)
    {

    }

    public function update($request, $id)
    {

    }
}
