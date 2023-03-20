<?php

namespace RBooks\Repositories;

use RBooks\Models\FamilyRelationship;

class FamilyRLShipRepository extends BaseRepository
{
    protected $fieldSearchable = [
    	'employee_id',
        'relation',
        'fullname',
    ];

    protected $modelName = FamilyRelationship::class;
}