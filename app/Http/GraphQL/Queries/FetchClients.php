<?php

namespace App\Http\GraphQL\Queries;

use App\Models\Client;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class FetchClients
{
    public function resolve($rootValue, array $args)
    {
        return Client::where('organization_uuid', $args['organizationUuid'])->get();
    }
}
