<?php

namespace RBooks\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends BaseModel
{
	use SoftDeletes;
    protected $table = 'images';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'path', 'filename', 'order',
    ];
}
