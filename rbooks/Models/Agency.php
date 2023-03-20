<?php

namespace RBooks\Models;

class Agency  extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'address', 'phone', 'updated_user_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }
}
