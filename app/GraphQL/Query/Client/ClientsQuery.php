<?php

namespace App\GraphQL\Query\Client;

use App\Models\Client;
use App\Models\User;
use Folklore\GraphQL\Support\Query;
use GraphQL;
use GraphQL\Type\Definition\Type;

class ClientsQuery extends Query
{
    protected $attributes = [
        'name' => 'clients',
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('Client'));
    }

    public function args()
    {
        return [
            'uuid'        => ['name' => 'uuid', 'type' => Type::string()],
            'organization_uuid' => ['name' => 'organization_uuid', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        if (isset($args['uuid'])) {
            return Client::where('uuid', $args['uuid'])->get();
        } else if (isset($args['organization_uuid'])) {
            return Client::where('organization_uuid', $args['organization_uuid'])->get();
        } else {
            return Client::all();
        }
    }
}