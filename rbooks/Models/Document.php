<?php

namespace RBooks\Models;

class Document extends BaseModel
{
    protected $table = "documents";
    protected $fillable = ['name', 'filename', 'note', 'created_user_id', 'updated_user_id'];
}
