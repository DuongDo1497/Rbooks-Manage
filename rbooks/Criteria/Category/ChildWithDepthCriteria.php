<?php

namespace RBooks\Criteria\Category;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ChildWithDepthCriteria implements CriteriaInterface
{
    protected $parent_id;
    protected $depth;

    public function __construct($parent_id, $depth)
    {
        $this->parent_id = $parent_id;
        $this->depth = $depth;
    }

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
        return $model->withDepth()->having('depth', '=', $this->depth)->groupBy('id', 'depth');
    }
}
