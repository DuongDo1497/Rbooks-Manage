<?php

namespace RBooks\Repositories;

use RBooks\Models\Warehouse;

class WarehouseRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id' => 'like',
        'name' => 'like',
    ];

    protected $modelName = Warehouse::class;
}
