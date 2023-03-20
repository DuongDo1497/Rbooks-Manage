<?php

namespace RBooks\Repositories;

use RBooks\Models\EmployeePermissionday;

class EmplperdayRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'year',
        'employee_id',
    ];

    protected $modelName = EmployeePermissionday::class;
}
