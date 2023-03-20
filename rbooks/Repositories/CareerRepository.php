<?php

namespace RBooks\Repositories;

use RBooks\Models\Career;

class CareerRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'fullname',
    ];

    protected $modelName = Career::class;
}
