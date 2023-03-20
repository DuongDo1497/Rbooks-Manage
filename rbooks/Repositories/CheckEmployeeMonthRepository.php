<?php

namespace RBooks\Repositories;

use RBooks\Models\CheckEmployeeMonth;

class CheckEmployeeMonthRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'month',
    	'year'
    ];

    protected $modelName = CheckEmployeeMonth::class;
}
