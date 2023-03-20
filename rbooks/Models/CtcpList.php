<?php

namespace RBooks\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtcpList extends BaseModel
{
	//protected $connection = 'mysql2';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "ctcp_lists";
    use SoftDeletes;

    protected $fillable = [
        'code', 'date_create', 'startday_cost', 'endday_cost', 'itemcost_id', 'method_cost', 'type_cost', 'supplier_code', 'supplier_name', 'supplier_phone', 'supplier_address', 'vat', 'novat_cost', 'vat_cost', 'paided_cost_vat', 'paided_cost_novat', 'remaining_cost_vat', 'remaining_cost_novat', 'quantity', 'unit', 'file_cost', 'content', 'note', 'status', 'creator_cost', 'personin_cost', 'import_id', 'cplist_id', 'created_user_id', 'updated_user_id'
    ];

    public function mclist()
    {
        return $this->belongsTo(McList::class, 'itemcost_id');
    }

    public function cptpaymentslips()
    {
        return $this->hasMany(CptPaymentSlipList::class, 'ctcplist_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'creator_cost');
    }

    public function personinEmployee()
    {
        return $this->belongsTo(Employee::class, 'personin_cost');
    }

    public function import()
    {
        return $this->belongsTo(Import::class, 'import_id');
    }
}
