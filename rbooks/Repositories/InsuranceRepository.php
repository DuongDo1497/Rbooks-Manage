<?php

namespace RBooks\Repositories;

use RBooks\Models\Insurances;

class InsuranceRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'employee_id'
    ];

    protected $modelName = Insurances::class;
}
