<?php

namespace RBooks\Repositories;

use RBooks\Models\OrderAddress;

class OrderAdressRepository extends BaseRepository
{
    /**
     * Model name
     *
     * @var string
     */
    protected $modelName = OrderAddress::class;

    /**
     * Searchable fields condition
     *
     * @var array
     */
    protected $fieldSearchable = [
        'fullname',
        'address',
        'city',
        'district',
        'note',
    ];
}
