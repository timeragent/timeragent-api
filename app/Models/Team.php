<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Mpociot\Teamwork\TeamworkTeam;

class Team extends TeamworkTeam
{
    protected $fillable = [
        'name',
        'owner_id',
        'organization_id',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'projects_teams', 'team_id', 'project_id');
    }

    public function scopeIManage($query, $user_id = null)
    {
        return $query->where('owner_id', $user_id ?: Auth::id());
    }
}
