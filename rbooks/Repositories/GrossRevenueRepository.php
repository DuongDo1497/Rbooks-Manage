<?php

namespace RBooks\Repositories;

use RBooks\Models\GrossRevenue;

class GrossRevenueRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'status',
        'note',
    ];

    protected $modelName = GrossRevenue::class;
}
