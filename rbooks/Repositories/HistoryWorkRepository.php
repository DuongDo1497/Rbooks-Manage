<?php

namespace RBooks\Repositories;

use RBooks\Models\HistoryWork;

class HistoryWorkRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'employee_id',
        'description',
    ];

    protected $modelName = HistoryWork::class;
}
