<?php

namespace RBooks\Models;

class LaborContract extends BaseModel
{
    protected $table = "ns_laborcontracts"; // Hợp đồng lao động

    protected $fillable = ['employee_id', 'fromdate', 'todate','labortype', 'description','active', 'created_user_id', 'updated_user_id'];

    public function employee()
    {
    	return $this->belongsTo(Employee::class, 'employee_id');
    }
}
