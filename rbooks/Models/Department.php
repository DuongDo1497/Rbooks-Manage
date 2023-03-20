<?php

namespace RBooks\Models;

class Department extends BaseModel
{
    protected $table = "ns_departments";
    /**
     * Fillabled array for mass asign
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'order_full', 'created_user_id', 'updated_user_id',
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

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function divisions()
    {
         return $this->hasMany(Division::class);
    }

    public function monthinsurance()
    {
         return $this->hasMany(MonthInsurance::class);
    }
}
