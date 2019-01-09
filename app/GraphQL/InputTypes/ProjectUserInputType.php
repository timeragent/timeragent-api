<?php

namespace App\GraphQL\InputTypes;

use GraphQL;

class ProjectUserInputType extends UserInputType
{
    protected $attributes = [
        'name'        => 'ProjectUserInput',
        'description' => 'A user in project',
    ];

    protected $inputObject = true;

    public function fields()
    {
        $fields = parent::fields();
        return array_merge($fields, [
            'options'     => [
                'type'        => GraphQL::type('ProjectUserOptionsInput'),
                'description' => 'User options in project'
            ]
        ]);
    }
}