<?php

namespace RBooks\Repositories;

use RBooks\Models\CtcpList;

class CtcpListRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name', 'note',
    ];

    protected $modelName = CtcpList::class;
}
