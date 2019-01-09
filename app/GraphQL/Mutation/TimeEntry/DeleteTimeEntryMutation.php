<?php

namespace App\GraphQL\Mutation\TimeEntry;

use App\Validation\Rules\Uuid;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use App\Models\TimeEntry;
use GraphQL\Type\Definition\Type;

class DeleteTimeEntryMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteTimeEntry',
    ];

    public function type()
    {
        return GraphQL::type('TimeEntry');
    }

    public function args()
    {
        return [
            'uuid' => ['name' => 'uuid', 'type' => Type::string()],
        ];
    }

    public function rules()
    {
        return [
            'uuid'       => [
                'required',
                new Uuid(),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $timeEntry = TimeEntry::find($args['uuid']);

        $timeEntry->delete();
    }
}