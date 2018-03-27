<?php

namespace App\GraphQL\Mutation\Organization;

use App\Models\Organization;
use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CreateOrganizationMutation extends Mutation
{
    protected $attributes = [
        'name'        => 'CreateOrganizationMutation',
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
        // $user = app('auth')->guard('api')->user();
        if (Gate::denies('create-organization')) {
            throw new AccessDeniedHttpException('You don\'t have permissions to complete this operation.');
        }

        $params = collect($args['organization'])
            ->only(
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

        return Organization::create($params);
    }
}
