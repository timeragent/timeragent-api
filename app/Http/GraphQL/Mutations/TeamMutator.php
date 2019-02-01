<?php

namespace App\Http\GraphQL\Mutations;

use App\Models\Team;
use App\Models\User;

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

        $team_users = collect($args['team']['users']);

        $team = Team::find($args['team']['uuid']);

        $team->name       = $team_data['name'];
        $team->owner_type = $team_data['ownerType'];
        $team->owner_uuid = $team_data['ownerUuid'];
        $team->save();

        $users_uuids = $team_users
            ->pluck('uuid')
            ->toArray();

        $diff_users = array_merge(
            $team->users->pluck('uuid')->diff($users_uuids)->toArray(),
            collect($users_uuids)->diff($team->users->pluck('uuid'))->toArray()
        );

        // Detach old users from team projects, attach new users to team projects
        foreach ($team->projects as $project) {
            foreach ($diff_users as $uuid) {
                $user = User::find($uuid);

                if ($user->projects()->where('uuid', $project->uuid)->first()) {
                    $project->users()->detach($user->uuid);
                } else {
                    $project->users()->attach([
                        $user->uuid => [
                            'team_uuid' => $team->uuid,
                        ]
                    ]);
                }
            }
        }

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
