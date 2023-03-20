<?php

namespace RBooks\Repositories;

use RBooks\Models\CheckType;

class CheckTypeRepository extends BaseRepository
{
    protected $modelName = CheckType::class;

    protected $fieldSearchable = [
        'id',
        'signno',
        'description'
    ];
}
