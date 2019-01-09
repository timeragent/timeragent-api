<?php

namespace App\GraphQL\InputTypes;

use Folklore\GraphQL\Support\InputType;
use GraphQL\Type\Definition\Type;
use GraphQL;

class OrganizationInputType extends InputType
{
    protected $attributes = [
        'name'        => 'OrganizationInput',
        'description' => 'An organization',
    ];

    protected $inputObject = true;

    public function fields()
    {
        return [
            'uuid'    => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The uuid of the organization',
            ],
            'email'   => [
                'type'        => Type::string(),
                'description' => 'The email of organization',
            ],
            'name'    => [
                'type'        => Type::string(),
                'description' => 'The name of organization',
            ],
            'address' => [
                'type'        => Type::string(),
                'description' => 'The address of organization',
            ],
            'phone'   => [
                'type'        => Type::string(),
                'description' => 'The phone of organization',
            ],
            'website' => [
                'type'        => Type::string(),
                'description' => 'The website of organization',
            ],
            'owners'  => [
                'type'        => Type::listOf(Type::string()),
                'description' => 'Organization owners',
            ],
        ];
    }
}