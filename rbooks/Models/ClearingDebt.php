<?php

namespace RBooks\Models;

class ClearingDebt extends BaseModel
{
    protected $table = "dt_clearing_debt";

    protected $fillable = [
        'dt_revenue_id', 'clearing_vat', 'clearing_novat', 'sl_tralai', 'reason', 'note',
        'created_user_id', 'updated_user_id',
    ];

    public function grossRevenue()
    {
        return $this->belongsTo(GrossRevenue::class, 'dt_revenue_id');
    }
}
