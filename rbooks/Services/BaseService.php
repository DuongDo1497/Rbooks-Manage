<?php

namespace RBooks\Services;

abstract class BaseService
{
    /**
     * Main repository
     */
    protected $repository;

    /**
     * With condition
     */
    protected $with = [];

    /**
     * Get current main repository
     */
    public function getRepository()
    {
        $repository = $this->repository;

        if(!empty($this->with) && is_array($this->with)) {
            $repository = $repository->with($this->with);
        }

        return $repository;
    }

    /**
     * Get all records
     */
    public function getAll()
    {
        $repository = $this->getRepository();
        return $repository->all();
    }

    public function getAllWithCriteria($criteria)
    {
        $repository = $this->getRepository();
        return $repository->getByCriteria($criteria);
    }

    /**
     * Get records with limit and columns
     */
    public function getPaginate($limit = null, $columns = ['*'])
    {
        $repository = $this->getRepository();
        return $repository->paginate($limit, $columns);
    }

    /**
     * Find a result
     */
    public function find($id)
    {
        $repository = $this->getRepository();

        if(count($this->with) > 0) {
            $repository = $repository->with($this->with);
        }

        if($model = $repository->find($id)) {
            return $model;
        }

        abort(500);
    }

    /**
     * Delete a record
     */
    public function delete($id)
    {
        $this->repository->delete($id);
    }

    /**
     * Set with condition
     */
    public function setWith($relation)
    {
        if(is_array($relation)) {
            $this->with = array_merge($this->with, $relation);
        } else {
            $this->with[] = $relation;
        }
    }
}
