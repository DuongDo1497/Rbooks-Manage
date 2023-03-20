<?php

namespace RBooks\Repositories;

use RBooks\Models\NetRevenue;

class NetRevenueRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'status',
        'note',
    ];

    protected $modelName = NetRevenue::class;
}
