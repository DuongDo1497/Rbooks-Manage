<?php

namespace RBooks\Repositories;

use RBooks\Models\ApplicationRoles;

class ApplicationRolesRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'code',
    ];

    protected $modelName = ApplicationRoles::class;
}
