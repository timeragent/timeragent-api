<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Organization
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Client[]  $clients
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Team[]    $teams
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[]    $users
 * @mixin \Eloquent
 * @property string                                                              $uuid
 * @property string                                                              $name
 * @property string|null                                                         $address
 * @property string|null                                                         $phone
 * @property string|null                                                         $email
 * @property string|null                                                         $website
 * @property \Carbon\Carbon|null                                                 $created_at
 * @property \Carbon\Carbon|null                                                 $updated_at
 * @property string|null                                                         $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organization whereWebsite($value)
 */
class Organization extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'phone',
        'address',
        'website',
    ];

    public function owners()
    {
        return $this->belongsToMany(User::class)
                    ->where('status', '=', 1);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function projects()
    {
        return $this->hasManyThrough(Project::class, Client::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
