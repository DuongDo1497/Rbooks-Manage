<?php

namespace RBooks\Repositories;

use RBooks\Criteria\Product\ProductFilterByStatusCriteria;
use RBooks\Models\Product;

class ProductRepository extends BaseRepository
{
    protected $modelName = Product::class;

    protected $fieldSearchable = [
        'name' => 'like',
        'id' => 'like',
        'sku' => 'like',
        'status' => 'like',
    ];

    protected $criterias = [
        ProductFilterByStatusCriteria::class,
    ];
}
