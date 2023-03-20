<?php

namespace RBooks\Criteria\Task;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class TaskFilterByStatusCriteria implements CriteriaInterface
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
            $model = $model->where('filter_status', $status);
        }
        return $model;
    }
}
