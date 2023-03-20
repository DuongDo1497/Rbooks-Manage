<?php

namespace RBooks\Repositories;

use RBooks\Models\MailProduct;

class MailProductRepository extends BaseRepository
{
    protected $fieldSearchable = ['name', 'description'];

    protected $modelName = MailProduct::class;
}