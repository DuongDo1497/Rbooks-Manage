<?php

namespace RBooks\Services;

use RBooks\Repositories\CpcnCostSaleRepository;
use \Auth;
use \DB;

class CpcnCostSaleService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(CpcnCostSaleRepository::class);
    }

    /**
     * Create new dept
     *
     * @param object $request
     * @return \App\Models\OtherCost
     */
    public function create($request)
    {

    }

    public function update($request, $id)
    {

    }

    // public function getPaginate($limit = null, $columns = ['*'])
    // {
    //     $repository = $this->getRepository();
    //     return $repository->orderBy('id', 'desc')->paginate($limit, $columns);
    // }
}
