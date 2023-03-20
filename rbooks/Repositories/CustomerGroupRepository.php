<?php

namespace RBooks\Repositories;

use RBooks\Models\CustomerGroup;

class CustomerGroupRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name' => 'like',
        'code' => 'like',
    ];

    protected $modelName = CustomerGroup::class;
}
