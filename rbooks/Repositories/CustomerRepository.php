<?php

namespace RBooks\Repositories;

use RBooks\Models\Customer;

class CustomerRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'fullname',
        'phone',
        'email',
    ];

    protected $modelName = Customer::class;
}
