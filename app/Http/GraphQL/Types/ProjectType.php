<?php

namespace App\Http\GraphQL\Types;

use App\Models\Organization;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class ProjectType
{
    public function clientUuid(Project $project)
    {
        return $project->client_uuid;
    }

    public function clientName(Project $project)
    {
        if ($project->owner_type == Organization::MORPH_NAME) {
            return $project->client->name;
        }
        return '';
    }

    public function ownerType(Project $project)
    {
        return $project->owner_type;
    }

    public function ownerUuid(Project $project)
    {
        return $project->owner_uuid;
    }

    public function ownerName(Project $project)
    {
        if ($project->owner_type === Organization::MORPH_NAME) {
            $organization = Organization::where('uuid', $project->owner_uuid)->first();
            return $organization->name;
        }
        $user = User::where('uuid', $project->owner_uuid)->first();
        return $user->first_name . " " . $user->last_name;
    }

    public function users(Project $project)
    {
        return $project->users()->whereNull('team_uuid')->get();
    }

    public function createdAt(Project $project)
    {
        return $project->created_at;
    }


}
