<?php

namespace RBooks\Repositories;

use RBooks\Models\Debt;

class DebtRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'supplier_id',
        'import_id',
        'note',
    ];

    protected $modelName = Debt::class;
}
