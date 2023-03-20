<?php

namespace RBooks\Repositories;

use RBooks\Models\CheckEmployee;

class CheckEmployeeRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'id',
        'employee_id',
        'department_id',
    ];

    protected $modelName = CheckEmployee::class;
}
