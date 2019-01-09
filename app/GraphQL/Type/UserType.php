<?php

namespace App\GraphQL\Type;

use App\Models\User;
use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;
use GraphQL\Type\Definition\Type;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'User',
        'description' => 'A user',
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
                'description' => 'The uuid of the user',
            ],
            'email'       => [
                'type'        => Type::string(),
                'description' => 'The email of user',
            ],
            'firstName'    => [
                'type'        => Type::string(),
                'description' => 'The first name of user',
                'resolve' => function($user) {
                    return $user->first_name;
                }
            ],
            'lastName'     => [
                'type'        => Type::string(),
                'description' => 'The last name of user',
                'resolve' => function($user) {
                    return $user->last_name;
                }
            ],
            'middleName'   => [
                'type'        => Type::string(),
                'description' => 'The middle name of user',
                'resolve' => function($user) {
                    return $user->middle_name;
                }
            ],
            'name'          => [
                'type'        => Type::string(),
                'description' => 'The name of user',
            ],
            'organizations' => [
                'type'        => Type::listOf(GraphQL::type('Organization')),
                'description' => 'Organizations owned by user',
            ],
            'costRate'     => [
                'type'        => Type::float(),
                'description' => 'The cost rate of the user',
                'resolve' => function($user) {
                    return $user->cost_rate;
                }
            ],
            'statusInOrganization' => [
                'type'        => Type::int(),
                'description' => 'User status in organization',
                'args' => [
                    'organization_uuid' => [
                        'type'        => Type::string(),
                        'description' => 'Organization uuid',
                    ]
                ]
            ]
        ];
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveNameField(User $user, $args)
    {
        return $user->first_name . ' ' . $user->last_name;
    }

    protected function resolveStatusInOrganizationField(User $user, $args) {
        if (isset($args['organization_uuid'])) {
            return $user->organizations()
                ->where('uuid', $args['organization_uuid'])
                ->first()->pivot->status;
        }
    }
}