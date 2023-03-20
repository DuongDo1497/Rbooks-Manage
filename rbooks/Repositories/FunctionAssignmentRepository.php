<?php

namespace RBooks\Repositories;

use RBooks\Models\FunctionAssignment;

class FunctionAssignmentRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'id',
    ];

    protected $modelName = FunctionAssignment::class;
}
