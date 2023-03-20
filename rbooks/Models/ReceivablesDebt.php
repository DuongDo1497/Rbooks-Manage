<?php

namespace RBooks\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceivablesDebt extends BaseModel
{
    use SoftDeletes;

    /**
     * Fillabled array for mass asign
     *
     * @var array
     */
    protected $fillable = [
        'export_id', 'order_id', 'code_receivable', 'code_license', 'date_receivable', 'method_receivable', 'source_receivable','begin_day', 'end_day', 'method_receivable', 'side_paymee', 'code_customer', 'name_customer', 'phone', 'address', 'vat', 'receivable_notvat', 'receivable_vat', 'paided_notvat', 'paided_vat', 'residualdebt_notvat', 'residualdebt_vat', 'quantity', 'unit', 'file_receivable', 'description', 'people_receivable', 'staff_undertake', 'status', 'note', 'created_user_id', 'updated_user_id'
    ];

    /**
     * User association with customer
     *
     * @return QueryBuilder
     */

}
