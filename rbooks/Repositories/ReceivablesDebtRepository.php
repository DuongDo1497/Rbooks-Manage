<?php

namespace RBooks\Repositories;

use RBooks\Models\ReceivablesDebt;

class ReceivablesDebtRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'export_id',
        'status',
        'note',
    ];

    protected $modelName = ReceivablesDebt::class;
}
