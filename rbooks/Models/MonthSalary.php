<?php

namespace RBooks\Models;

class MonthSalary extends BaseModel
{

    protected $table = "ns_monthsalarys";

    protected $fillable = ['month','year','department_id','position_id','employee_id','worksalary','extrasalary','numworkday_salary','numworkday','totalsalary','bhxh','bhtnld_bnn','bhtn','bhyt','luongthuclinh','phucap','thucnhankynay','description','approved','approved_user_id','approved_at','created_user_id','created_at','updated_user_id','updated_at'];

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
