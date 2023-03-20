<?php

namespace RBooks\Repositories;

use RBooks\Models\Position;

class PositionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
    ];

    protected $modelName = Position::class;
}
