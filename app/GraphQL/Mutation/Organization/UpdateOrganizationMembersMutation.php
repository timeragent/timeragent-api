<?php

namespace App\GraphQL\Mutation\Organization;

use App\Models\Organization;
use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UpdateOrganizationMembersMutation extends Mutation
{
    protected $attributes = [
        'name'        => 'updateOrganizationMembers',
        'description' => 'A mutation',
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('User'));
    }

    public function args()
    {
        return [
            'organization_uuid' => ['name' => 'organization_uuid', 'type' => Type::string()],
            'members' => ['name' => 'members', 'type' => Type::listOf(GraphQL::type('UserInput'))],
        ];
    }

    public function rules()
    {
        return [
            'organization_uuid'  => [
                'required',
                'regex:/^[a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12}$/i',
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $organization = Organization::findOrFail($args['organizationUuid']);

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
