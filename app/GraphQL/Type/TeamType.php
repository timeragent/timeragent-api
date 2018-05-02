<?php

namespace App\GraphQL\Type;

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
            'uuid'          => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The uuid of the team',
            ],
            'name'    => [
                'type'        => Type::string(),
                'description' => 'The name of team',
            ],
            'owner_type'    => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Owner type of the team',
            ],
            'owner_uuid'    => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The uuid of the owner',
            ],
            'owner_name'    => [
                'type'        => Type::string(),
                'description' => 'Name of the owner',
            ],
            'users'         => [
                'type'        => Type::listOf(GraphQL::type('User')),
                'description' => 'Members of the team',
            ]
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
}