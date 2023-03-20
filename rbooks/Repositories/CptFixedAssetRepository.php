<?php

namespace RBooks\Repositories;

use RBooks\Models\CptFixedAsset;

class CptFixedAssetRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name', 'note',
    ];

    protected $modelName = CptFixedAsset::class;
}
