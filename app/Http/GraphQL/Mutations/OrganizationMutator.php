<?php

namespace App\Http\GraphQL\Mutations;

use App\Models\Organization;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class OrganizationMutator
{
    public function createOrganization($rootValue, array $args)
    {
        $organization_data = $args['organization'];

        $organization = new Organization();
        $organization->uuid = $organization_data['uuid'];
        $organization->email = $organization_data['email'];
        $organization->name = $organization_data['name'];
        $organization->address = $organization_data['address'];
        $organization->phone = $organization_data['phone'];
        $organization->website = $organization_data['website'];
        $organization->save();

        $organization->owners()->attach($args['userUuid'], ['status' => 1]);

        return $organization;
    }

    public function updateOrganization($root, $args)
    {
        $organization_data = $args['organization'];

        $organization = Organization::find($args['organization']['uuid']);

        $organization->email = $organization_data['email'];
        $organization->name = $organization_data['name'];
        $organization->address = $organization_data['address'];
        $organization->phone = $organization_data['phone'];
        $organization->website = $organization_data['website'];
        $organization->save();

        if ( ! empty($organization_data['owners'])) {
            $organization->owners()->sync($organization_data['owners']);
        }

        $organization->fresh();

        return $organization;
    }

    public function updateOrganizationMembers($root, $args)
    {
        $organization = Organization::find($args['organizationUuid']);

        $members = collect($args['members']);

        foreach ($members as $member) {
            $members_uuids[$member['uuid']] = [
                'status' => (isset($member['statusInOrganization'])) ? $member['statusInOrganization'] : 2,
            ];
        }
        $organization->users()->sync($members_uuids);

        return $organization->fresh('users')->users;
    }
}
