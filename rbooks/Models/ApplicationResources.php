<?php

namespace RBooks\Models;

class ApplicationResources extends BaseModel
{
    protected $forceDeleting = true;
    
    protected $table = "mn_applicationresources";

    protected $fillable = ['code', 'name', 'filename', 'pagesecurity', 'image', 'prefix', 'created_user_id', 'created_at', 'updated_user_id'];

    public function functionassignment()
    {
        return $this->hasMany(FunctionAssignment::class);
    }

    public function applicationfunctiongroups()
    {
        return $this->hasMany(ApplicationFunctionGroups::class);
    }    

    public function securityresources()
    {
        return $this->hasMany(SecurityResources::class, 'rolecode');
    }

}
