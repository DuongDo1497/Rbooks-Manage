<?php

namespace RBooks\Repositories;

use RBooks\Criteria\Task\TaskFilterByStatusCriteria;
use RBooks\Models\Task;

class TranslateOneRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'taskname' => 'like',
        'status' => 'like',
    ];

    protected $modelName = Task::class;

    protected $criterias = [
        TaskFilterByStatusCriteria::class,
    ];
}
