<?php

namespace RBooks\Repositories;

use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository as PrettusBaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

class Baserepository extends PrettusBaseRepository implements CacheableInterface
{
    use CacheableRepository;

    /**
     * Autoload cretias
     *
     * @var array
     */
    protected $criterias = [];

    /**
     * Boot repository when application boot
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->criterias as $criteria) {
            $this->pushCriteria(app($criteria));
        }

        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get the model class name
     *
     * @return void
     */
    public function model()
    {
        return $this->modelName;
    }
}
