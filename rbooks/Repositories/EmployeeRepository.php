<?php

namespace RBooks\Repositories;

use RBooks\Models\Employee;

class EmployeeRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'id_staff',
        'fullname',
        'department_id',
    ];

    protected $modelName = Employee::class;
}
