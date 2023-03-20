<?php

namespace RBooks\Models;

class Debt extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_date', 'end_date', 'profit_percent', 'total', 'paymented_debt', 'outstanding_debt', 'status', 'note', 'supplier_id', 'import_id', 'updated_user_id'
    ];

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function imports()
    {
        return $this->belongsTo(Import::class, 'import_id');
    }
}
