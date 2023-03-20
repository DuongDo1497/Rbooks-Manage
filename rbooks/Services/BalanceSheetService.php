<?php

namespace RBooks\Services;

use RBooks\Repositories\BalanceSheetRepository;
use Carbon\Carbon;
use \Auth;
use \DB;

class BalanceSheetService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(BalanceSheetRepository::class);
        //$this->importservice = app(ImportService::class);
    }

    public function create($request)
    {

    }

    public function update($request, $id)
    {

    }

    public function getSortPage($limit = null, $columns = ['*'])
    {
        $repository = $this->getRepository();
        return $repository->paginate($limit, $columns);
    }
}
