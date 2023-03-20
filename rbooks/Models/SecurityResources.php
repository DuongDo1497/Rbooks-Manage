<?php

namespace RBooks\Models;

class SecurityResources extends BaseModel
{
    protected $forceDeleting = true;
    
    protected $table = "mn_securityresources";

    protected $fillable = ['rolecode', 'resourcecode', 'filename', 'cview', 'cadd', 'cdelete', 'cupdate', 'capprove', 'cuserview', 'description', 'created_user_id', 'created_at', 'updated_user_id'];

    public function applicationresources()
    {
        return $this->belongsTo(ApplicationResources::class, 'resourcecode', 'code');
    }   
}
