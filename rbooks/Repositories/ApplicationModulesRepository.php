<?php

namespace RBooks\Repositories;

use RBooks\Models\ApplicationModules;

class ApplicationModulesRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'code',
    ];

    protected $modelName = ApplicationModules::class;
}
