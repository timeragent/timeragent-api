<?php

namespace App\GraphQL\InputTypes;

use Folklore\GraphQL\Support\InputType;
use GraphQL;
use GraphQL\Type\Definition\Type;

class MembersInputType extends InputType
{
    protected $attributes = [
        'name'        => 'MembersInput',
        'description' => 'A list of members',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'members' => [
                'type' => Type::listOf(GraphQL::type('UserInput')),
            ]
        ];
    }
}