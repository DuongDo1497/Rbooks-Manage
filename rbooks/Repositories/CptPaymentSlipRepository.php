<?php

namespace RBooks\Repositories;

use RBooks\Models\CptPaymentSlipList;

class CptPaymentSlipRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name', 'note',
    ];

    protected $modelName = CptPaymentSlipList::class;
}
