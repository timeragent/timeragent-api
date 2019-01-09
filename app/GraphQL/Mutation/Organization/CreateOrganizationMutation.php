<?php

namespace App\GraphQL\Mutation\Organization;

use App\Models\Organization;
use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CreateOrganizationMutation extends Mutation
{
    protected $attributes = [
        'name'        => 'createOrganization',
        'description' => 'A mutation',
    ];

    public function type()
    {
        return GraphQL::type('Organization');
    }

    public function args()
    {
        return [
            'organization' => ['name' => 'organization', 'type' => GraphQL::type('OrganizationInput')],
            'user_uuid' => ['name' => 'user_uuid', 'type' => Type::string()],
        ];
    }

    public function rules()
    {
        return [
            'organization.uuid'  => [
                'required',
                'regex:/^[a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12}$/i',
            ],
            'organization.email' => ['required', 'email'],
            'organization.name'  => ['required'],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $params = collect($args['organization']);

//        if (Gate::denies('create_organization')) {
//            throw new AccessDeniedHttpException('You don\'t have permissions to complete this operation.');
//        }

        $user = app('auth')->guard('api')->user();

        $filteredParams = $params->only(
            [
                'uuid',
                'email',
                'name',
                'address',
                'phone',
                'website',
            ]
        )
                                 ->toArray();

        $organization = Organization::create($filteredParams);
        $organization->owners()->attach($args['user_uuid'], ['status' => 1]);

        return $organization;
    }
}
