<?php

namespace App\GraphQL\InputTypes;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\InputType;

class ClientInputType extends InputType
{
    protected $attributes = [
        'name'        => 'ClientInput',
        'description' => 'A client',
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
                'description' => 'The uuid of the client',
            ],
            'name'          => [
                'type'        => Type::string(),
                'description' => 'The name of client',
            ],
            'organizationUuid' => [
                'type'        => Type::string(),
                'description' => 'Uuid of owner organization',
            ],
            'contactUuid'      => [
                'type'        => Type::string(),
                'description' => 'Uuid of contact person',
            ],
            'address'        => [
                'type'        => Type::string(),
                'description' => 'Client address',
            ],
            'invoicePrefix' => [
                'type'        => Type::string(),
                'description' => 'Invoice prefix',
            ],
            'rate' => [
                'type'        => Type::float(),
                'description' => 'Rate provided by client',
            ],
            'contact' => [
                'type' => GraphQL::type('ContactInput'),
                'description' => 'Contact person data',
            ]
        ];
    }
}
