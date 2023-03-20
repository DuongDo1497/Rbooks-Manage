<?php

namespace RBooks\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Balancesheet extends BaseModel
{
    use SoftDeletes;

    /**
     * Fillabled array for mass asign
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * User association with customer
     *
     * @return QueryBuilder
     */

}
