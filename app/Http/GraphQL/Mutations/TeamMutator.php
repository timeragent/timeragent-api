<?php

namespace App\Http\GraphQL\Mutations;

use App\Models\Team;

class TeamMutator
{
    public function createTeam($rootValue, array $args)
    {
        $team_data = $args['team'];

        $team             = new Team();
        $team->uuid       = $team_data['uuid'];
        $team->name       = $team_data['name'];
        $team->owner_type = $team_data['ownerType'];
        $team->owner_uuid = $team_data['ownerUuid'];
        $team->save();

        $users_uuids = collect($args['team']['users'])
            ->pluck('uuid')
            ->toArray();

        $team->users()->sync($users_uuids);

        return $team;
    }

    public function updateTeam($root, $args)
    {
        $team_data = $args['team'];

        $team = Team::find($args['team']['uuid']);

        $team->name       = $team_data['name'];
        $team->owner_type = $team_data['ownerType'];
        $team->owner_uuid = $team_data['ownerUuid'];
        $team->save();

        $users_uuids = collect($args['team']['users'])
            ->pluck('uuid')
            ->toArray();

        $team->users()->sync($users_uuids);

        return $team;
    }

    public function deleteTeam($root, $args)
    {
        $team = Team::find($args['uuid']);

        $team->delete();

        return $team;
    }
}
