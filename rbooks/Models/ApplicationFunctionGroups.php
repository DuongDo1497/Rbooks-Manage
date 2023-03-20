<?php

namespace RBooks\Models;

class ApplicationFunctionGroups extends BaseModel
{
    protected $forceDeleting = true;
    
    protected $table = "mn_applicationfunctiongroups";

    protected $fillable = ['applicationmoduleid', 'name', 'displayorder', 'image', 'applicationresourceid', 'created_user_id', 'created_at', 'updated_user_id', 'updated_at'];

    public function applicationresources()
    {
        return $this->belongsTo(ApplicationResources::class, 'applicationresourceid');
    }
}
