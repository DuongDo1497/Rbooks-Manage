<?php

namespace RBooks\Repositories;

use RBooks\Models\Vat;

class VatRepository extends BaseRepository
{
    /**
     * Model name
     *
     * @var string
     */
    protected $modelName = Vat::class;

    /**
     * Searchable fields condition
     *
     * @var array
     */
    protected $fieldSearchable = [
        'name_company',
        'address_company',
        'code_vat',
        'created_at',
    ];
}
