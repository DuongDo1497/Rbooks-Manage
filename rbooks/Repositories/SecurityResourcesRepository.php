<?php

namespace RBooks\Repositories;

use RBooks\Models\SecurityResources;

class SecurityResourcesRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'rolecode',
    ];

    protected $modelName = SecurityResources::class;
}
