<?php

namespace App\Http\GraphQL\Queries;

use App\Models\Organization;
use App\Models\OrganizationInvite;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class FetchOrganizationInvites
{
    /**
     * Return a value for the field.
     *
     * @param null $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param array $args The arguments that were passed into the field.
     * @param GraphQLContext|null $context Arbitrary data that is shared between all fields of a single query.
     * @param ResolveInfo $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     *
     * @return mixed
     */
    public function resolve($rootValue, array $args)
    {
        $organization = Organization::findOrFail($args['organizationUuid']);
        $user = Auth::user();

        if ($organization->users->where('uuid', $user->uuid)->first()->pivot->status != 1) {
            throw new \Exception('Access denied');
        }

        return $organization->invites()->where('status', OrganizationInvite::STATUS_PENDING)->get();
    }
}
