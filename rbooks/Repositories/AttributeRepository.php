<?php

namespace RBooks\Repositories;

use RBooks\Models\Attribute;

class AttributeRepository extends BaseRepository
{
    /**
     * Searchable fields
     *
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
    ];

    protected $modelName = Attribute::class;
}
