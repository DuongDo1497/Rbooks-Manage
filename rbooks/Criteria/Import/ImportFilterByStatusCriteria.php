<?php

namespace RBooks\Criteria\Import;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ImportFilterByStatusCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $status = request('filter_status');

        if (!is_null($status)) {
            $model = $model->where('status', $status);
        }
        return $model;
    }
}
