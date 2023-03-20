<?php

namespace RBooks\Models;

class Attribute extends BaseModel
{
    protected $table = 'attributes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'type', 'option', 'updated_user_id'
    ];

    /**
     * Products belongs to
     *
     * @return void
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
