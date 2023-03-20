<?php

namespace RBooks\Repositories;

use RBooks\Models\Holiday;

class HolidayRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'holiday',
    ];

    protected $modelName = Holiday::class;
}
