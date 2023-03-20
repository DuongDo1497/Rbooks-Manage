<?php

namespace RBooks\Repositories;

use RBooks\Models\Experience;

class ExperienceRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'employee_id',
        'description',
        'major',
    ];

    protected $modelName = Experience::class;
}
