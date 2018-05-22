<?php

namespace App\Models;

/**
 * App\Models\Project
 *
 * @property-read \App\Models\Client                                          $client
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[] $tasks
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Team[] $teams
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $usersWithoutTeam
 * @mixin \Eloquent
 */
class Project extends BaseModel
{
    protected $fillable = [
        'uuid',
        'name',
        'owner_type',
        'owner_uuid',
        'client_uuid'
    ];

    public function attachTeam($team_id)
    {
        $this->teams()->attach($team_id);

        return $this;
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function detachTeam($team_uuid)
    {
        $this->teams()->detach($team_uuid);

        return $this;
    }

    public function usersWithTeam()
    {
//        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id')
//                    ->wherePivot('team_id', $team_id)
//                    ->withPivot('billable_rate', 'cost_rate', 'team_id')
//                    ->withTimestamps();
    }

    public function usersWithoutTeam()
    {
        return $this->belongsToMany(User::class)
                    ->wherePivot('team_uuid', null)
                    ->withPivot('cost_rate', 'team_uuid')
                    ->withTimestamps();
    }

    public function attachUser($user_uuid, $pivot = [])
    {
        $this->users()->attach($user_uuid, $pivot);

        return $this;
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('cost_rate')
                    ->withTimestamps();
    }

    public function detachUser($user_uuid, $team_uuid)
    {
        $this->users()->wherePivot('team_uuid', $team_uuid)->detach($user_uuid);

        return $this;
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_uuid');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function scopeGetProjects($query, $owner_type, $owner_uuid)
    {
        return $query->where('owner_type', $owner_type)
            ->where('owner_uuid', $owner_uuid);
    }
}
