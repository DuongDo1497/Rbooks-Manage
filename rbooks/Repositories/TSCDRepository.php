<?php

namespace RBooks\Repositories;

use RBooks\Models\QlTSCD;

class TSCDRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'fullname',
    ];

    protected $modelName = QlTSCD::class;
}
