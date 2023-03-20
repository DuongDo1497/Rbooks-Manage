<?php

namespace RBooks\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class CptPaymentSlipList extends BaseModel
{
	//protected $connection = 'mysql2';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "ct_paymentslip_lists";
    use SoftDeletes;

    protected $fillable = [
        'ctcplist_id', 'date_cost', 'content', 'paided_cost_novat', 'paided_cost_vat', 'note', 'created_user_id', 'updated_user_id'
    ];

    public function CtcpList()
    {
        return $this->belongsTo(CtcpList::class, 'ctcplist_id');
    }
}
