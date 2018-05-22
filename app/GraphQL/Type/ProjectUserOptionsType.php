<?php

namespace App\GraphQL\Type;

use App\Models\User;
use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;
use GraphQL\Type\Definition\Type;

class ProjectUserOptionsType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'ProjectUserOptions',
        'description' => 'User options in project',
    ];

    /*
    * Uncomment following line to make the type input object.
    * http://graphql.org/learn/schema/#input-types
    */
    // protected $inputObject = true;

    public function fields()
    {
        return [
            'cost_rate'     => [
                'type'        => Type::float(),
                'description' => 'The cost rate of the user',
            ]
        ];
    }
}