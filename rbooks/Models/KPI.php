<?php

namespace RBooks\Models;

class KPI extends BaseModel
{
    protected $table = "ns_kpis"; // Trình độ

    protected $fillable = ['fromdate', 'todate', 'department_id', 'position_id', 'employee_id', 'projects', 'fromdate_pj', 'todate_pj', 'completeddate_pj', 'jobs', 'status', 'kpi%', 'point', 'note', 'approved', 'approved_user_id', 'approved_at', 'created_user_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'department_id');
    }
}
