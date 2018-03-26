<?php

namespace App\GraphQL\Query;

use App\Models\Organization;
use Folklore\GraphQL\Support\Query;
use GraphQL;
use GraphQL\Type\Definition\Type;

class OrganizationQuery extends Query
{
    protected $attributes = [
        'name' => 'organizations',
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('Organization'));
    }

    public function args()
    {
        return [
            'id'      => ['name' => 'id', 'type' => Type::string()],
            'email'   => ['name' => 'email', 'type' => Type::string()],
            'name'    => ['name' => 'name', 'type' => Type::string()],
            'address' => ['name' => 'address', 'type' => Type::string()],
            'phone'   => ['name' => 'phone', 'type' => Type::string()],
            'website' => ['name' => 'website', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        if (isset($args['id'])) {
            return Organization::where('id', $args['id'])->get();
        } else if (isset($args['email'])) {
            return Organization::where('email', $args['email'])->get();
        } else {
            return Organization::all();
        }
    }
}