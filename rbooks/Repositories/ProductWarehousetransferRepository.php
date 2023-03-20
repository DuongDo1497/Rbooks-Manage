<?php

namespace RBooks\Repositories;

use RBooks\Models\ProductWarehousetransfer;

class ProductWarehousetransferRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'quantity',
        'product_id',
        'warehousestransfer_id',
    ];

    protected $modelName = ProductWarehousetransfer::class;
}