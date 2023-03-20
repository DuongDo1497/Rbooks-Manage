<?php

namespace RBooks\Repositories;

use RBooks\Criteria\Task\TaskFilterByStatusCriteria;
use RBooks\Models\TaskWaitReceive;

class TaskWaitReceiveRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'taskname' => 'like',
    ];

    protected $modelName = TaskWaitReceive::class;

    protected $criterias = [
        TaskFilterByStatusCriteria::class,
    ];
}
