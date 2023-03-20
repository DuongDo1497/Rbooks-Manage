<?php

namespace RBooks\Models;

class Education extends BaseModel
{
    protected $table = "ns_educations"; // Quá trình đào tạo

    protected $fillable = ['employee_id', 'fromdate', 'todate', 'schoolname', 'level', 'major', 'description', 'created_user_id', 'updated_user_id'];
}
