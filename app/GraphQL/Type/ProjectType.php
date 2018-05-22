<?php

namespace App\GraphQL\Type;

use App\Models\User;
use App\Models\Organization;
use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;
use GraphQL\Type\Definition\Type;
use App\Models\Project;

class ProjectType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Project',
        'description' => 'A project',
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
                'description' => 'The uuid of the project',
            ],
            'name'    => [
                'type'        => Type::string(),
                'description' => 'The name of project',
            ],
            'client_uuid' => [
                'type'        => Type::string(),
                'description' => 'The uuid of the client',
            ],
            'client_name' => [
                'type'        => Type::string(),
                'description' => 'The name of the client',
            ],
            'owner_type'    => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Owner type of the project',
            ],
            'owner_uuid'    => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The uuid of the owner',
            ],
            'owner_name'    => [
                'type'        => Type::string(),
                'description' => 'Name of the owner',
            ],
            'teams'         => [
                'type'        => Type::listOf(GraphQL::type('Team')),
                'description' => 'Teams of the project',
            ],
            'users'         => [
                'type'        => Type::listOf(GraphQL::type('ProjectUser')),
                'description' => 'Members of the project',
            ]
        ];
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    public function resolveOwnerNameField(Project $project, $args)
    {
        if ($project->owner_type === Organization::MORPH_NAME) {
            $organization = Organization::where('uuid', $project->owner_uuid)->first();
            return $organization->name;
        }
        $user = User::where('uuid', $project->owner_uuid)->first();
        return $user->first_name . " " . $user->last_name;
    }

    public function resolveClientNameField(Project $project, $args) {
        if ($project->owner_type == Organization::MORPH_NAME) {
            return $project->client->name;
        }
        return '';
    }
}