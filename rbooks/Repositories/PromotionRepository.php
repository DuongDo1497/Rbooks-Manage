<?php

namespace RBooks\Repositories;

use RBooks\Models\Promotion;

class PromotionRepository extends BaseRepository
{
    protected $fieldSearchable = ['key', 'percent', 'quantity', 'quantitied', 'description', 'status'];

    protected $modelName = Promotion::class;
}