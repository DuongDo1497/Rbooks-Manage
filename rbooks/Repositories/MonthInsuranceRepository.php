<?php

namespace RBooks\Repositories;

use RBooks\Models\MonthInsurance;

class MonthInsuranceRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'month',
        'year',
    ];

    protected $modelName = MonthInsurance::class;
}
