<?php

namespace RBooks\Repositories;

use RBooks\Models\MonthSalary;

class MonthSalaryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'month',
        'year',
    ];

    protected $modelName = MonthSalary::class;
}
