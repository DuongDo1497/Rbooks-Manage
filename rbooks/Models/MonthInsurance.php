<?php

namespace RBooks\Models;

class MonthInsurance extends BaseModel
{

    protected $table = "ns_monthinsurances";

    protected $fillable = ['month', 'year', 'department_id', 'position_id', 'employee_id', 'salaryinsurance', 'bhxh', 'bhtnld_bnn', 'bhtn', 'bhyt', 'bhxh_cn', 'bhtnld_bnn_cn', 'bhtn_cn', 'bhyt_cn', 'approved', 'approved_user_id', 'approved_at', 'created_user_id', 'created_at', 'updated_user_id', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
}
