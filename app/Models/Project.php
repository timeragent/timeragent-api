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
    protected $fillable = ['name', 'owner_id', 'client_id'];

    public function attachTeam($team_id)
    {
        $this->teams()->attach($team_id);

        return $this;
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'projects_teams', 'project_id', 'team_id');
    }

    public function detachTeam($team_id)
    {
        $this->teams()->detach($team_id);

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
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id')
                    ->wherePivot('team_id', null)
                    ->withPivot('billable_rate', 'cost_rate', 'team_id')
                    ->withTimestamps();
    }

    public function attachUser($user_id, $pivot = [])
    {
        $this->users()->attach($user_id, $pivot);

        return $this;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id')
                    ->withPivot('billable_rate', 'billable_currency', 'cost_rate', 'cost_currency', 'team_id')
                    ->withTimestamps();
    }

    public function detachUser($user_id, $team_id)
    {
        $this->users()->wherePivot('team_id', $team_id)->detach($user_id);

        return $this;
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
