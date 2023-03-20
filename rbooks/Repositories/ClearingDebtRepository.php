<?php

namespace RBooks\Repositories;

use RBooks\Models\ClearingDebt;

class ClearingDebtRepository extends BaseRepository
{
    protected $fieldSearchable = ['dt_renevue_id'];

    protected $modelName = ClearingDebt::class;
}
