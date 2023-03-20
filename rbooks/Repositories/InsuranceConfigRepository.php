<?php

namespace RBooks\Repositories;

use RBooks\Models\InsuranceConfig;

class InsuranceConfigRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
    ];

    protected $modelName = InsuranceConfig::class;
}
