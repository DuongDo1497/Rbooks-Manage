<?php

namespace RBooks\Repositories;

use RBooks\Models\Gift;

class GiftRepository extends BaseRepository
{
    /**
     * Model name
     *
     * @var string
     */
    protected $modelName = Gift::class;

    /**
     * Searchable fields condition
     *
     * @var array
     */
    protected $fieldSearchable = [
        'recipientName',
        'address',
        'phone',
        'message',
    ];
}
