<?php

namespace RBooks\Models;

class Division extends BaseModel
{
    /**
     * Fillabled array for mass asign
     *
     * @var array
     */
    protected $fillable = [
        'code_division', 'name', 'department_id', 'updated_user_id'
    ];

    /**
     * User association with customer
     *
     * @return QueryBuilder
     */
    public function emloyees()
    {
        return $this->hasMany(Employee::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
