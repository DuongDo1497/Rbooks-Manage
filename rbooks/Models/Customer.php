<?php

namespace RBooks\Models;

class Customer extends BaseModel
{
    /**
     * Fillabled array for mass asign
     *
     * @var array
     */
    protected $fillable = [
        'fullname', 'gender', 'birthday', 'phone', 'email', 'slug', 'user_id', 'updated_user_id',
    ];

    /**
     * User association with customer
     *
     * @return QueryBuilder
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function groups()
    {
        return $this->belongsToMany(CustomerGroup::class);
    }

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
