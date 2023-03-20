<?php

namespace RBooks\Models;

class Job_description extends BaseModel
{
    protected $table = "job_descriptions"; // Quá trình bhxh

    protected $fillable = [
        'introduction', 'benefit', 'address', 'salary', 'work_time', 'experience', 'requirements', 'orther_requirements', 'recruitment_id',
    ];

    public function recruitment()
    {
        return $this->belongsTo(Recruitment::class);
    }
}
