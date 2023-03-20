<?php

namespace RBooks\Models;

class HistoryWork extends BaseModel
{
    protected $table = "ns_historyworks"; // Quá trình làm việc tại công ty

    protected $fillable = ['employee_id','department_id','position_id','nummonths','fromdate','todate','description','created_user_id','updated_user_id'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

}
