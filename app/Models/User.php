<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;

//use Mpociot\Teamwork\Traits\UserHasTeams;
//use Jrean\UserVerification\Traits\VerifiesUsers;
//use Jrean\UserVerification\Traits\UserVerification;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    // use HasApiTokens, Notifiable, UserHasTeams, UserVerification;
    use Authenticatable, Authorizable, SoftDeletes, HasApiTokens;

    const ADMIN_ROLE = 'ADMIN_USER';
    const BASIC_ROLE = 'BASIC_USER';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return (isset($this->role) ? $this->role : self::BASIC_ROLE) == self::ADMIN_ROLE;
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_user', 'user_id', 'project_id')
                    ->withTimestamps();
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class)
                    ->withPivot('status');
    }

    public function attachOrganization($organization_id, $pivot = [])
    {
        return $this->organizations()->attach($organization_id, $pivot);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
