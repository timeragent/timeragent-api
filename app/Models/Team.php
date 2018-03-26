<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Team
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Team iManage($user_id = null)
 * @mixin \Eloquent
 */
class Team extends Model
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
