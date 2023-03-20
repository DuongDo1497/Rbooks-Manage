<?php

namespace RBooks\Repositories;

use RBooks\Models\MailScheduleHistory;

class MailScheduleHistoryRepository extends BaseRepository
{
    protected $fieldSearchable = ['order_date', 'sendmail_status'];

    protected $modelName = MailScheduleHistory::class;
}