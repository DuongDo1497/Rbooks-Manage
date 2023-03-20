<?php

namespace RBooks\Repositories;

use RBooks\Models\Coupon;

class CouponRepository extends BaseRepository
{
    protected $fieldSearchable = ['key', 'percent', 'quantity', 'quantitied', 'description', 'status'];

    protected $modelName = Coupon::class;
}