<?php

namespace RBooks\Models;

use Kalnoy\Nestedset\NodeTrait;

class Category extends BaseModel
{
    use NodeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','nameEnglish', 'slug', 'description', 'status',
    ];

    /**
     * Has many products
     *
     * @return Relationship
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
