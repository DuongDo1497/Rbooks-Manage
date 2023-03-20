<?php

namespace RBooks\Models;

class CheckEmployee extends BaseModel
{
    protected $table = "ns_checkemployees"; // Đăng ký nghỉ phép

    protected $fillable = ['department_id', 'employee_id', 'checktype_id', 'fromdate', 'fromtime', 'todate', 'totime', 'numday', 'place', 'description', 'status', 'approved_user_id', 'approved_at', 'approved_code', 'created_user_id', 'updated_user_id'];

    protected $dates  = ["fromdate", "todate"];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function users()
    {
        return $this->belongsTo(Employee::class, 'approved_user_id');
    }

    public function employee()
    {
    	return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function checktype()
    {
    	return $this->belongsTo(CheckType::class, 'checktype_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function permissionday()
    {
        return $this->hasMany(EmployeePermissionday::class, 'employee_id', 'employee_id');
    }
}
