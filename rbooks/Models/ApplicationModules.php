<?php

namespace RBooks\Models;

class ApplicationModules extends BaseModel
{
    protected $forceDeleting = true;
    
    protected $table = "mn_applicationmodules";

    protected $fillable = ['code', 'applicationmodulename', 'displayorder', 'sys', 'hidden', 'image', 'created_user_id', 'created_at', 'updated_user_id'];
}
