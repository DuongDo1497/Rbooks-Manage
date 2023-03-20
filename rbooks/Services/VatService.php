<?php

namespace RBooks\Services;

use RBooks\Repositories\VatRepository;
// use RBooks\Services\ImportService;
use \Auth;
use \DB;

class VatService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(VatRepository::class);
        // $this->importservice = app(ImportService::class);
    }

    /**
     * Create new dept
     *
     * @param object $request
     * @return \App\Models\Dept
     */

    public function getSortPage($field = 'id', $vat = 'desc', $limit = null, $columns = ['*'])
    {
        $repository = $this->getRepository();
        return $repository->orderBy($field, $vat)->paginate($limit, $columns);
    }
}
