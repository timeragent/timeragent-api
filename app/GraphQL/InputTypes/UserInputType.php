<?php

namespace App\GraphQL\InputTypes;

use Folklore\GraphQL\Support\InputType;
use GraphQL\Type\Definition\Type;

class UserInputType extends InputType
{
    protected $attributes = [
        'name'        => 'UserInput',
        'description' => 'A user',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'uuid'        => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The uuid of the user',
            ],
            'email'       => [
                'type'        => Type::string(),
                'description' => 'The email of user',
            ],
            'password'    => [
                'type'        => Type::string(),
                'description' => 'The password of user',
            ],
            'first_name'  => [
                'type'        => Type::string(),
                'description' => 'The first name of user',
            ],
            'last_name'   => [
                'type'        => Type::string(),
                'description' => 'The last name of user',
            ],
            'middle_name' => [
                'type'        => Type::string(),
                'description' => 'The middle name of user',
            ],
            'name'        => [
                'type'        => Type::string(),
                'description' => 'The name of user',
            ],
            'cost_rate'   => [
                'type'        => Type::float(),
                'description' => 'The cost rate of user',
            ]
        ];
    }
}