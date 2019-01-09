<?php

namespace App\GraphQL\InputTypes;

use Folklore\GraphQL\Support\InputType;
use GraphQL\Type\Definition\Type;

class ProjectUserOptionsInputType extends InputType
{
    protected $attributes = [
        'name'        => 'ProjectUserOptionsInput',
        'description' => 'A user options in project',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'costRate'     => [
                'type'        => Type::float(),
                'description' => 'The cost rate of the user'
            ]
        ];
    }
}