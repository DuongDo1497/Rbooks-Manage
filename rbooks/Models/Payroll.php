<?php

namespace RBooks\Models;

class Payroll extends BaseModel
{

    protected $table = "ns_profilesalarys"; // Quá trình lương

    protected $fillable = ['department_id', 'employee_id', 'code', 'level', 'worksalary', 'extrasalary', 'description', 'active', 'effectdate', 'created_user_id', 'created_at', 'updated_user_id', 'updated_at'];

}
