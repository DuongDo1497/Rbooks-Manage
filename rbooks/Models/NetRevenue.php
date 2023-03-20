<?php

namespace RBooks\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class NetRevenue extends BaseModel
{
    use SoftDeletes;
    /**
     * Fillabled array for mass asign
     *
     * @var array
     */
    protected $fillable = [
        'export_id', 'order_id', 'code_revenue', 'code_license', 'date_revenue', 'source_revenue', 'method_revenue', 'type_revenue', 'side_paymee', 'code_customer', 'name_customer', 'phone', 'address', 'revenue_notvat', 'revenue_vat', 'vat', 'quantity', 'unit', 'file_revenue', 'description', 'people_revenue', 'staff_undertake', 'status', 'note', 'created_user_id', 'updated_user_id'
    ];

    /**
     * User association with customer
     *
     * @return QueryBuilder
     */

}
