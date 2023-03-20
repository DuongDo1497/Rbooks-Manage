<?php

namespace RBooks\Repositories;

use RBooks\Models\Transfer;
use RBooks\Criteria\Transfer\TransferFilterByStatusCriteria;

class TransferRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'code_transfer' => 'like',
        'warehousefrom_id' => 'like',
        'warehouseto_id' => 'like',
        'status' => 'like',
    ];

    protected $modelName = Transfer::class;

    protected $criterias = [
        TransferFilterByStatusCriteria::class,
    ];
}
