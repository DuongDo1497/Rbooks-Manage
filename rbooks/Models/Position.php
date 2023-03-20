<?php

namespace RBooks\Models;

class Position extends BaseModel
{
    protected $table = "ns_titles";
    /**
     * Fillabled array for mass asign
     *
     * @var array
     */
    protected $fillable = [
        'code_position', 'name', 'updated_user_id'
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

    public function monthinsurance()
    {
         return $this->hasMany(MonthInsurance::class);
    }
}
