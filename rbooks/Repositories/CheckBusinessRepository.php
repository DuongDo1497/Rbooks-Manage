<?php

namespace RBooks\Repositories;

use RBooks\Models\CheckBusiness;

class CheckBusinessRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'id',
        'employee_id',
        'department_id',
    ];

    protected $modelName = CheckBusiness::class;
}
