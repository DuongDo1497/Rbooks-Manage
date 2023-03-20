<?php

namespace RBooks\Models;

class ImageAvatar extends BaseModel
{
    protected $table = "ns_img_avatar";
    /**
     * Fillabled array for mass asign
     *
     * @var array
     */
    protected $fillable = [ 'path', 'employee_id'];

    /**
     * User association with customer
     *
     * @return QueryBuilder
     */
}
