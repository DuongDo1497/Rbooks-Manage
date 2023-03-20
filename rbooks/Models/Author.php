<?php

namespace RBooks\Models;

class Author extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'description', 'image_id', 'updated_user_id',
    ];

    /**
     * Image avatar of author
     *
     * @return void
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }
}
