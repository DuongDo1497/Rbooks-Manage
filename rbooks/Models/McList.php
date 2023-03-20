<?php

namespace RBooks\Models;

class McList extends BaseModel
{
    protected $table = "mc_lists";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'group'];

}
