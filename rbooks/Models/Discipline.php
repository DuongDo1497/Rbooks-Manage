<?php

namespace RBooks\Models;

class DiscipLine extends BaseModel
{
    protected $table = "ns_disciplines"; // Quá trình kỷ luật/khen thưởng

    protected $fillable = ['employee_id', 'fromdate', 'todate', 'disciplinenumber', 'contentdiscipline', 'description', 'checktype_id', 'formdiscipline', 'created_user_id', 'updated_user_id'];

    public function employee()
    {
    	return $this->belongsTo(Employee::class, 'employee_id');
    }
}
