<?php

namespace RBooks\Repositories;

use RBooks\Models\Department;

class DepartmentRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
    ];

    protected $modelName = Department::class;
}
