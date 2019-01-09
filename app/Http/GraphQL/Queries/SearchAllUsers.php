<?php

namespace App\Http\GraphQL\Queries;

use App\Models\User;

class SearchAllUsers
{
    public function resolve($rootValue, array $args)
    {
        return User::where('email', 'LIKE', "{$args['queryString']}%")->get();
    }
}
