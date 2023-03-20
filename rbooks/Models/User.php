<?php

namespace RBooks\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;
    //use SoftDeletes;
    protected $table = 'users_admin';
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'customer_id', 'last_login_at', 'blocked', 'begin_at', 'finish_at', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
}
