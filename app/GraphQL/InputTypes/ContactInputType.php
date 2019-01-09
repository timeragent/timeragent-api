<?php

namespace App\GraphQL\InputTypes;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\InputType;

class ContactInputType extends InputType
{
    protected $attributes = [
        'name'        => 'ContactInput',
        'description' => 'Contact person of a client',
    ];

    /*
    * Uncomment following line to make the type input object.
    * http://graphql.org/learn/schema/#input-types
    */
     protected $inputObject = true;

    public function fields()
    {
        return [
            'uuid'          => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The uuid of the contact person',
            ],
            'firstName'          => [
                'type'        => Type::string(),
                'description' => 'The first name of contact person',
            ],
            'lastName' => [
                'type' => Type::string(),
                'description' => 'The last name of the contact person',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The full name of the contact person',
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email of the contact person',
            ],
            'telephone' => [
                'type' => Type::string(),
                'description' => 'The telephone of the contact person',
            ]
        ];
    }
}