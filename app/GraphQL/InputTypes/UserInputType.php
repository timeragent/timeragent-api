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

    /*
    * Uncomment following line to make the type input object.
    * http://graphql.org/learn/schema/#input-types
    */
    // protected $inputObject = true;

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

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveNameField($root, $args)
    {
        return $root->first_name . ' ' . $root->last_name;
    }
}