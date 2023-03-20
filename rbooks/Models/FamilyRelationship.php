<?php

namespace RBooks\Models;

class FamilyRelationship extends BaseModel
{
    protected $table = "ns_familyrelationships"; // Mối quan hệ nhân thân

    protected $fillable = ['employee_id', 'relation', 'fullname', 'birthday', 'address', 'work', 'created_user_id', 'updated_user_id'];

    public function employee()
    {
    	return $this->belongsTo(Employee::class, 'employee_id');
    }
}
