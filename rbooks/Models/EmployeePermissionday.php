<?php

namespace RBooks\Models;

class EmployeePermissionday extends BaseModel
{
    protected $table = "ns_employeepermissiondays"; // Đăng ký nghỉ phép

    protected $fillable = ['year', 'employee_id', 'permission_lastyear', 'permission_curryear', 'permission_leave', 'permission_left', 'created_user_id', 'updated_user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function employee()
    {
    	return $this->belongsTo(Employee::class, 'employee_id');
    }

}
