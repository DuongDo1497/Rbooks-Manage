<?php

namespace RBooks\Models;

class InsuranceConfig extends BaseModel
{
    protected $table = "ns_insuranceconfig";

    protected $fillable = ['fromdate', 'todate', 'bhxh_nld', 'bhxh_ct', 'bhtnld_bnn_nld', 'bhtnld_bnn_ct', 'bhyt_nld', 'bhyt_ct', 'bhtn_nld', 'bhtn_ct', 'description', 'active', 'created_user_id', 'created_at', 'updated_user_id', 'updated_at'];
}
