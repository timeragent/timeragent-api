<?php

namespace App\GraphQL\Mutation\Organization;

use App\Models\Organization;
use App\Validation\Rules\Unique;
use App\Validation\Rules\Uuid;
use Folklore\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UpdateOrganizationMutation extends Mutation
{
    protected $attributes = [
        'name'        => 'updateOrganization',
        'description' => 'Updates Organization',
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
            'organization.uuid'     => [
                'required',
                new Uuid(),
                'exists:organizations,uuid',
            ],
            'organization.email'    => [
                'required',
                (new Unique('organizations', 'email'))
                    ->ignore(
                        array_get(
                            app('request')->all(),
                            'variables.uuid'
                        ),
                        'uuid'
                    ),
            ],
            'organization.name'     => ['required'],
            'organization.owners'   => ['array'],
            'organization.owners.*' => [
                new Uuid(),
                'exists:users,uuid',
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $params             = collect($args['organization']);
        $targetOrganization = Organization::whereUuid($params->get('uuid'))->first();

        if (Gate::denies('update_organization', $targetOrganization)) {
            throw new AccessDeniedHttpException('You don\'t have permissions to complete this operation.');
        }

        $filteredParams = $params->only(
            [
                'email',
                'name',
                'address',
                'phone',
                'website',
            ]
        )
                                 ->toArray();

        $targetOrganization->update($filteredParams);

        if ( ! empty($filteredParams['owners'])) {
            $targetOrganization->owners()->sync($filteredParams['owners']);
        }

        $targetOrganization->fresh();

        return $targetOrganization;
    }
}
