<?php

namespace App\GraphQL\Type;

use App\Models\User;
use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;
use App\GraphQL\Type\UserType;
use GraphQL\Type\Definition\Type;

class ProjectUserType extends UserType
{
    protected $attributes = [
        'name'        => 'ProjectUser',
        'description' => 'A user in project',
    ];

    /*
    * Uncomment following line to make the type input object.
    * http://graphql.org/learn/schema/#input-types
    */
    // protected $inputObject = true;

    public function fields()
    {
        $fields = parent::fields();
        return array_merge($fields, [
            'options'         => [
                'type'        => GraphQL::type('ProjectUserOptions'),
                'description' => 'User options in project'
            ]
        ]);
    }

    public function resolveOptionsField(User $user, $args)
    {
        return $user->pivot;
    }

}