<?php

namespace RBooks\Repositories;

use RBooks\Models\CityProvince;

class CityProvinceRepository extends BaseRepository
{
    protected $modelName = CityProvince::class;

    protected $fieldSearchable = [
        'id',
        'code',
        'name'
    ];
}
