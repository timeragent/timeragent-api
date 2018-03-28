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
        $uuidType = app('request')->get('operationName') === 'updateUser'
            ? Type::string()
            : Type::nonNull(Type::string());

        return [
            'uuid'        => [
                'type'        => $uuidType,
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
        ];
    }
}