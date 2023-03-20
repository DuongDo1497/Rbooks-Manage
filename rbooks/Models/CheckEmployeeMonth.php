<?php

namespace RBooks\Models;

class CheckEmployeeMonth extends BaseModel
{
    protected $table = "ns_checkemployeemonths";

    protected $fillable = ['month','year','department_id','position_id','employee_id','dayofmonthfield','dayofmonthvalue','checktypefield','checktypevalue','workingday','permissionday','boardingday','salaryday','permissionlastyear','permissioncurryear','approved','created_user_id','created_at','updated_user_id','updated_at'];

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
