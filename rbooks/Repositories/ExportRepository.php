<?php

namespace RBooks\Repositories;

use RBooks\Models\Export;
use RBooks\Criteria\Export\ExportFilterByStatusCriteria;

class ExportRepository extends BaseRepository
{
    /**
     * Model name
     *
     * @var string
     */
    protected $modelName = Export::class;

    /**
     * Searchable fields condition
     *
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'date',
        'note',
    ];

    protected $criterias = [
        ExportFilterByStatusCriteria::class,
    ];
}
