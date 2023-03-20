<?php

namespace RBooks\Repositories;

use RBooks\Criteria\CategoryFilterByStatusCriteria;
use RBooks\Criteria\CategorySortByLeftCriteria;
use RBooks\Criteria\CategoryWithDepthCriteria;
use RBooks\Models\Category;

class CategoryRepository extends BaseRepository
{
    /**
     * Model name
     *
     * @var string
     */
    protected $modelName = Category::class;

    /**
     * Searchable fields condition
     *
     * @var array
     */
    protected $fieldSearchable = [
        'name' => 'like',
        'description' => 'like',
    ];

    /**
     * Autoload criterias
     * TODO: later check
     *
     * @var array
     */
    protected $criterias = [
        CategorySortByLeftCriteria::class,
        CategoryWithDepthCriteria::class,
        CategoryFilterByStatusCriteria::class,
    ];
}
