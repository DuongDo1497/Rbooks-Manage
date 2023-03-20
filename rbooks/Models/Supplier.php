<?php

namespace RBooks\Models;

class Supplier extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'slug', 'address', 'phone', 'email', 'discount', 'updated_user_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }
}
