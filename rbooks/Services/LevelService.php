<?php

namespace RBooks\Services;

use RBooks\Repositories\LevelRepository;
use \Auth;

class LevelService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(LevelRepository::class);
    }
}
