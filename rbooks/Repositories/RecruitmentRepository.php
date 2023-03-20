<?php

namespace RBooks\Repositories;

use RBooks\Models\Recruitment;

class RecruitmentRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'fullname',
    ];

    protected $modelName = Recruitment::class;
}
