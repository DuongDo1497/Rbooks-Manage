<?php

namespace RBooks\Repositories;

use RBooks\Models\GrossStepReceipt;

class GrossStepReceiptRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name', 'note',
    ];

    protected $modelName = GrossStepReceipt::class;
}
