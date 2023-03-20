<?php

namespace RBooks\Repositories;

use RBooks\Models\DiscipLine;

class DisciplineRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'employee_id',
        'disciplinenumber',
        'contentdiscipline',
        'checktype_id',
    ];

    protected $modelName = DiscipLine::class;
}