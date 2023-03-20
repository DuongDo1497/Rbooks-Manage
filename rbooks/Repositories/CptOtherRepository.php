<?php

namespace RBooks\Repositories;

use RBooks\Models\CptOther;

class CptOtherRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name', 'note',
    ];

    protected $modelName = CptOther::class;
}
