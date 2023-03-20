<?php

namespace RBooks\Repositories;

use RBooks\Models\KPI;

class KPIRepository extends BaseRepository
{
    protected $modelName = KPI::class;

    protected $fieldSearchable = [
        'name'
    ];
}
