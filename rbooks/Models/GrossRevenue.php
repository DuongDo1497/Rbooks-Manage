<?php

namespace RBooks\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrossRevenue extends BaseModel
{
    use SoftDeletes;
    protected $table = "dt_revenues";
    /**
     * Fillabled array for mass asign
     *
     * @var array
     */
    protected $fillable = [
        'itemcost_id', 'export_id', 'date_create', 'type_revenue', 'code_revenue', 'code_license',
        'start_date', 'end_date', 'method_revenue', 'code_customer', 'name_customer', 'phone', 'address',
        'notvat_revenue', 'vat_revenue', 'vat', 'dathu_notvat', 'dathu_vat', 'conlai_notvat', 'conlai_vat',
        'quantity', 'unit', 'file_revenue', 'content', 'creator_revenue', 'personin_revenue', 'status', 'note',
        'created_user_id', 'updated_user_id', 'sl_dathu', 'sl_chuathu', 'sl_tralai', 'sl_chuaban', 'sl_daban'
    ];

    /**
     * User association with customer
     *
     * @return QueryBuilder
     */
    public function mclist()
    {
        return $this->belongsTo(McList::class, 'itemcost_id');
    }

    public function grossReceipts()
    {
        return $this->hasMany(GrossStepReceipt::class, 'dt_revenue_id');
    }

    public function creatorEmployee()
    {
        return $this->belongsTo(Employee::class, 'creator_revenue');
    }

    public function personinEmployee()
    {
        return $this->belongsTo(Employee::class, 'personin_revenue');
    }

    public function clearingDebt() {
        return $this->hasMany(ClearingDebt::class, 'dt_revenue_id');
    }
}
