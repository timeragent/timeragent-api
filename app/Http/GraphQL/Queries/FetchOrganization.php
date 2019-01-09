<?php

namespace App\Http\GraphQL\Queries;

use App\Models\Organization;

class FetchOrganization
{
    public function resolve($rootValue, array $args)
    {
        return Organization::find($args['uuid']);
    }
}
