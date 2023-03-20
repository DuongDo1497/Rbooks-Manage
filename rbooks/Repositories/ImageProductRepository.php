<?php

namespace RBooks\Repositories;

use RBooks\Models\Image_Product;

class ImageProductRepository extends BaseRepository
{
    /**
     * Model name
     *
     * @var string
     */
    protected $modelName = Image_Product::class;

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
