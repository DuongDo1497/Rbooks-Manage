<?php

namespace RBooks\Repositories;

use RBooks\Models\LaborContract;

class LaborContractRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'employee_id',
        'description',
        'active',
    ];

    protected $modelName = LaborContract::class;
}
