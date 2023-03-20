<?php

namespace RBooks\Repositories;

use RBooks\Models\ProductWarehouse;

class ProductWarehouseRepository extends BaseRepository
{
    /**
     * Model name
     *
     * @var string
     */
    protected $modelName = ProductWarehouse::class;

    /**
     * Searchable fields condition
     *
     * @var array
     */
    protected $fieldSearchable = [
        'name' => 'like',
        'data' => 'like',
    ];
}
