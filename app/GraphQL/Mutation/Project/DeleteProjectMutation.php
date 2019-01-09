<?php

namespace App\GraphQL\Mutation\Project;

use App\Validation\Rules\Uuid;
use App\Models\Team;
use App\Models\Project;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use GraphQL\Type\Definition\Type;

class DeleteProjectMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteProject',
    ];

    public function type()
    {
        return GraphQL::type('Project');
    }

    public function args()
    {
        return [
            'uuid' => ['name' => 'uuid', 'type' => Type::nonNull(Type::string())],
        ];
    }

    public function rules()
    {
        return [
            'uuid' => [
                'required',
                new Uuid(),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $project = Project::find($args['uuid']);

        return $project->delete();
    }
}