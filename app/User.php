<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','email', 'password','username','designation_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];



    public function profile()
    {
        return $this->hasOne('App\Profile'); 
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role','role_user');
    }

    public function ticket()
    {
        return $this->hasMany('App\Ticket'); 
    }

    public function assignedTicket()
    {
        return $this->belongsToMany('App\Ticket','assigned_tickets','task_id','user_id');
    }

    public function todo()
    {
        return $this->hasMany('App\Todo'); 
    }

    public function message()
    {
        return $this->hasMany('App\Message'); 
    }
}
