<?php

namespace RBooks\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrossStepReceipt extends BaseModel
{
	//protected $connection = 'mysql2';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use SoftDeletes;
    protected $table = "dt_step_revenue";

    protected $fillable = [
        'dt_revenue_id', 'date_revenue', 'content', 'dathu_notvat', 'dathu_vat', 'quantity', 'note', 'created_user_id', 'updated_user_id'
    ];

    public function grossrevenue()
    {
        return $this->belongsTo(GrossRevenue::class, 'dt_revenue_id');
    }

}
