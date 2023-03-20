<?php

namespace RBooks\Repositories;

use RBooks\Models\Supplier;

class SupplierRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'code',
        'address',
        'email',
        'phone',
        'discount',
    ];

    protected $modelName = Supplier::class;
}
