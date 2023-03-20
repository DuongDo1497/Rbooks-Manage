<?php

namespace RBooks\Repositories;

use RBooks\Models\CptSaleCost;

class CptSaleCostRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name', 'note',
    ];

    protected $modelName = CptSaleCost::class;
}
