<?php

namespace RBooks\Repositories;

use RBooks\Models\ApplicationFunctionGroups;

class ApplicationFunctionGroupsRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'id',
    ];

    protected $modelName = ApplicationFunctionGroups::class;
}
