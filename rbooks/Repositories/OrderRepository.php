<?php

namespace RBooks\Repositories;

use RBooks\Criteria\Order\OrderFilterByStatusCriteria;
use RBooks\Models\Order;

class OrderRepository extends BaseRepository
{
    /**
     * Model name
     *
     * @var string
     */
    protected $modelName = Order::class;

    /**
     * Searchable fields condition
     *
     * @var array
     */
    protected $fieldSearchable = [
        // 'date',
        // 'note',
        'id',
        'billingaddress.fullname' => 'like'
    ];

    protected $criterias = [
        OrderFilterByStatusCriteria::class,
    ];
}
