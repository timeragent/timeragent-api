<?php

namespace App\GraphQL\Type;

use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;
use GraphQL\Type\Definition\Type;

class ClientType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Client',
        'description' => 'A client',
    ];

    /*
    * Uncomment following line to make the type input object.
    * http://graphql.org/learn/schema/#input-types
    */
    // protected $inputObject = true;

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
                'resolve'     => function ($client) {
                    return $client->organization_uuid;
                }
            ],
            'contactUuid'      => [
                'type'        => Type::string(),
                'description' => 'Uuid of contact person',
                'resolve'     => function ($client) {
                    return $client->contact_uuid;
                }
            ],
            'address'        => [
                'type'        => Type::string(),
                'description' => 'Client address',
            ],
            'invoicePrefix' => [
                'type'        => Type::string(),
                'description' => 'Invoice prefix',
                'resolve'     => function ($client) {
                    return $client->invoice_prefix;
                }
            ],
            'rate' => [
                'type'        => Type::float(),
                'description' => 'Rate provided by client',
            ],
            'contact' => [
                'type' => GraphQL::type('Contact'),
                'description' => 'Contact person data',
            ]
        ];
    }
}