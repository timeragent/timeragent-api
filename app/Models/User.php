<?php

namespace App\Models;

use App\Jobs\SendWelcomeEmail;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Queue;

/**
 * App\Models\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Organization[] $organizations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[]      $projects
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[]         $tasks
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[]  $tokens
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 * @mixin \Eloquent
 * @property string                                                                   $uuid
 * @property string                                                                   $first_name
 * @property string                                                                   $last_name
 * @property string|null                                                              $middle_name
 * @property int|null                                                                 $verified
 * @property string                                                                   $email
 * @property string                                                                   $password
 * @property string|null                                                              $remember_token
 * @property \Carbon\Carbon|null                                                      $created_at
 * @property \Carbon\Carbon|null                                                      $updated_at
 * @property string|null                                                              $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereVerified($value)
 */
class User extends BaseModel implements \Illuminate\Contracts\Auth\Authenticatable
{
    // use HasApiTokens, Notifiable, UserHasTeams, UserVerification;
    use SoftDeletes, HasApiTokens;

    const ADMIN_ROLE = 'ADMIN_USER';
    const BASIC_ROLE = 'BASIC_USER';
    const MORPH_NAME = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'middle_name',
        'verification_token',
        'admin',
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

    public static function boot()
    {
        parent::boot();

        static::creating(
            function (User $user) {
                $user->generateToken();
            }
        );

        static::created(
            function (User $user) {
                Queue::push(new SendWelcomeEmail($user));
            }
        );
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class)
                    ->withTimestamps()->withPivot('cost_rate', 'time_limit');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
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

    // GETTERS
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // HELPERS

    /**
     * Generate the verification token.
     *
     * @return string|bool
     */
    protected function generateToken()
    {
        return hash_hmac('sha256', $this->uuid, env('APP_KEY'));
    }
}
