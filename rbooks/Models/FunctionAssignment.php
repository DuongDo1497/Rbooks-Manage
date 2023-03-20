<?php

namespace RBooks\Models;

class FunctionAssignment extends BaseModel
{
    protected $forceDeleting = true;
    
    protected $table = "mn_functionassignment";

    protected $fillable = ['applicationfunctiongroupid', 'applicationresourceid', 'displayorder', 'created_user_id', 'created_at', 'updated_user_id', 'updated_at'];

    public function applicationresources()
    {
        return $this->belongsTo(ApplicationResources::class, 'applicationresourceid');
    }

}
