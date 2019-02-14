<?php

namespace App\Http\GraphQL\Queries;

use App\Models\Client;

class FetchClient
{
    public function resolve($rootValue, array $args)
    {
        return Client::findOrFail($args['uuid']);
    }
}
