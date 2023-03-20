<?php

namespace RBooks\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Career extends BaseModel
{
    use SoftDeletes;
    /**
     * Fillabled array for mass asign
     *
     * @var array
     */
    protected $fillable = [
        'fullname', 'phone', 'email', 'gender', 'apply_position', 'file_cv', 'status', 'updated_user_id'
    ];

    /**
     * User association with customer
     *
     * @return QueryBuilder
     */

}
