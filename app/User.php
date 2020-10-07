<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;


class User extends Model implements Authenticatable
{
    use AuthenticableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public $timestamps = false;

    public function assigned()
    {
        return $this->hasMany('\App\User', 'leader_id');
    }

    public function isAssigned()
    {
        return isset($this->leader_id);
    }

    public function hasAssigned()
    {
        return $this->hasMany('\App\User', 'leader_id')->exists();
    }

    public function tasks()
    {
        return $this->hasMany('\App\Task', 'assigned_user_id');

    }

    public function getAvailableUsers()
    {
        return $this->assigned()->get()->push($this);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
