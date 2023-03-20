<?php

namespace RBooks\Repositories;

use RBooks\Models\Level;

class LevelRepository extends BaseRepository
{
    protected $modelName = Level::class;

    protected $fieldSearchable = [
        'id',
        'code',
        'name'
    ];
}
