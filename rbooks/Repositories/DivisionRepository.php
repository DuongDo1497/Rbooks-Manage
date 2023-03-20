<?php

namespace RBooks\Repositories;

use RBooks\Models\Division;

class DivisionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
    ];

    protected $modelName = Division::class;
}
