<?php

namespace RBooks\Repositories;

use RBooks\Models\Payroll;

class PayrollRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'worksalary',
    ];

    protected $modelName = Payroll::class;
}
