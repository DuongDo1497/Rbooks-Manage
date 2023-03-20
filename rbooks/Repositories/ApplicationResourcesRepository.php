<?php

namespace RBooks\Repositories;

use RBooks\Models\ApplicationResources;

class ApplicationResourcesRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'code',
    ];

    protected $modelName = ApplicationResources::class;
}
