<?php

namespace App\GraphQL\Type;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use App\Models\Organization;
use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;
use GraphQL\Type\Definition\Type;

class TeamType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Team',
        'description' => 'A team',
    ];

    /*
    * Uncomment following line to make the type input object.
    * http://graphql.org/learn/schema/#input-types
    */
    // protected $inputObject = true;

    public function fields()
    {
        return [
            'uuid'       => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The uuid of the team',
            ],
            'name'       => [
                'type'        => Type::string(),
                'description' => 'The name of team',
            ],
            'ownerType'  => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Owner type of the team',
                'resolve'     => function ($team) {
                    return $team->owner_type;
                },
            ],
            'ownerUuid' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The uuid of the owner',
                'resolve'     => function ($team) {
                    return $team->owner_uuid;
                },
            ],
            'ownerName' => [
                'type'        => Type::string(),
                'description' => 'Name of the owner',
            ],
            'users'      => [
                'type'        => Type::listOf(GraphQL::type('ProjectUser')),
                'description' => 'Members of the team',
                'args'        => [
                    'project_uuid' => [
                        'type'        => Type::string(),
                        'description' => 'The uuid of the project',
                    ],
                ],
            ],
        ];
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    public function resolveOwnerNameField(Team $team, $args)
    {
        if ($team->owner_type === 'organization') {
            $organization = Organization::where('uuid', $team->owner_uuid)->first();

            return $organization->name;
        }
        $user = User::where('uuid', $team->owner_uuid)->first();

        return $user->first_name . " " . $user->last_name;
    }

    public function resolveUsersField(Team $team, $args)
    {
        if (isset($args['project_uuid'])) {
            return Project::where('uuid', $args['project_uuid'])
                          ->first()
                          ->users()
                          ->whereHas(
                              'teams', function ($query) use ($team) {
                              $query->where('uuid', $team->uuid);
                          }
                          )
                          ->withPivot('cost_rate', 'time_limit')
                          ->get();
        } else {
            return $team->users;
        }
    }
}
