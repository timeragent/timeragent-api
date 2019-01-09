<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Team
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Team iManage($user_id = null)
 * @mixin \Eloquent
 */
class Team extends BaseModel
{
    protected $fillable = [
        'uuid',
        'name',
        'owner_type',
        'owner_uuid',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function scopeIManage($query, $user_id = null)
    {
        return $query->where('owner_id', $user_id ?: Auth::id());
    }

    public function scopeGetTeams($query, $owner_type, $owner_uuid, $user_uuid = null)
    {
        return $query->where(function ($query) use ($owner_type, $owner_uuid, $user_uuid) {
            if ($user_uuid) {
                $query->where('owner_type', $owner_type);
                $query->where('owner_uuid', $owner_uuid);
            } else {
                $query->where('owner_type', $owner_type);
            }
        })
            ->where(function ($query) use ($owner_type, $owner_uuid, $user_uuid) {
                if ($user_uuid) {
                    $query->whereHas('users', function ($query) use ($user_uuid) {
                        $query->where('uuid', $user_uuid);
                    });
                } else {
                    $query->whereHas('users', function ($query) use ($owner_uuid) {
                        $query->where('uuid', $owner_uuid);
                    });
                }
            });

    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
