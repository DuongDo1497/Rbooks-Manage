<?php

namespace RBooks\Models;

class ApplicationRoles extends BaseModel
{
    protected $forceDeleting = true;
    
    protected $table = "mn_applicationroles";

    protected $fillable = ['code', 'name', 'description', 'modulesallowed', 'code_cp', 'created_user_id', 'created_at', 'updated_user_id', 'updated_at', ];

    public function securityresources()
    {
        return $this->hasMany(SecurityResources::class, 'rolecode');
    }

}
