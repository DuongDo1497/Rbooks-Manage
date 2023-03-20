<?php

namespace RBooks\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Foreign key for updated user references
     *
     * @var string
     */
    protected $updated_user_key = 'updated_user_id';

    /**
     * Updated user
     *
     * @return void
     */
    public function updated_user()
    {
        return $this->belongsTo(User::class, $this->updated_user_key);
    }
}
