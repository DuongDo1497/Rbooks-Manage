<?php

namespace RBooks\Models;

class Insurances extends BaseModel
{
    protected $table = "ns_profileinsurances"; // Quá trình bhxh

    protected $fillable = ['department_id', 'employee_id', 'salaryinsurance', 'extrainsurance', 'description', 'active', 'effectdate', 'created_user_id', 'created_at', 'updated_user_id', 'updated_at'];

    public function emloyees()
    {
        return $this->belongsTo(Employee::class);
    }
}
