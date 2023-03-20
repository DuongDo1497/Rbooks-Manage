<?php

namespace RBooks\Repositories;

use RBooks\Models\Import;
use RBooks\Criteria\Import\ImportFilterByStatusCriteria;

class ImportRepository extends BaseRepository
{
    /**
     * Model name
     *
     * @var string
     */
    protected $modelName = Import::class;

    /**
     * Searchable fields condition
     *
     * @var array
     */
    protected $fieldSearchable = [
        'import_code' => 'like',
        'warehouse_import_code' => 'like',
        'import_date' => 'like',
    ];

    protected $criterias = [
        ImportFilterByStatusCriteria::class,
    ];
}
