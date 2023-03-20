<?php

namespace RBooks\Repositories;

use RBooks\Models\ProcessTask;

class ProcessTaskRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'moduleid' => 'like',
        'taskid' => 'like'
    ];

    protected $modelName = ProcessTask::class;
}
