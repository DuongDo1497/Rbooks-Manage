<?php

namespace RBooks\Repositories;

use RBooks\Models\Education;

class EducationRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'employee_id',
        'schoolname',
        'major',
    ];

    protected $modelName = Education::class;
}
