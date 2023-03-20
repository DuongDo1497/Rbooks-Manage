<?php

namespace RBooks\Repositories;

use RBooks\Models\DetailTask;

class DetailTaskRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'detailtaskname' => 'like',
    ];

    protected $modelName = DetailTask::class;
}
