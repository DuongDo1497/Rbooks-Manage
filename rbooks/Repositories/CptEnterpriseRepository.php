<?php

namespace RBooks\Repositories;

use RBooks\Models\CptEnterprise;

class CptEnterpriseRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name', 'note',
    ];

    protected $modelName = CptEnterprise::class;
}
