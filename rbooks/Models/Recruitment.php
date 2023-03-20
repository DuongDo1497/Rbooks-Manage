<?php

namespace RBooks\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Recruitment extends BaseModel
{


    protected $table = 'recruitments';

    /**
     * Fillabled array for mass asign
     *
     * @var array
     */
    protected $fillable = [
        'title', 'vacancies', 'quantity', 'application_deadline', 'status',
    ];

    public function job_description()
    {
        return $this->hasOne(Job_description::class);
    }

    public function getStatusTextAttribute()
    {
        return $this->statusArr[$this->status];
    }

    protected $statusArr = [
        0 => 'Hết hạn',
        1 => 'Còn thời gian',
        2 => 'Sắp hết thời hạn',
    ];

    /**
     * User association with customer
     *
     * @return QueryBuilder
     */
}
