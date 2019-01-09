<?php

namespace App\GraphQL\Query\Task;

use App\Models\Organization;
use App\Models\Task;
use Folklore\GraphQL\Support\Query;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;

class TasksQuery extends Query
{
    protected $attributes = [
        'name' => 'tasks',
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('Task'));
    }

    public function args()
    {
        return [
            'uuid'        => ['name' => 'uuid', 'type' => Type::string()],
            'description' => ['name' => 'description', 'type' => Type::string()],
            'eta'         => ['name' => 'eta', 'type' => Type::int()],
            'projectUuid' => ['name' => 'projectUuid', 'type' => Type::string()],
            'userUuid'   => ['name' => 'userUuid', 'type' => Type::string()],
            'organizationUuid' => ['name' => 'organizationUuid', 'type' => Type::string()],
            'date' => ['name' => 'date', 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = Task::query();

        $user = app('auth')->guard('api')->user();

        $query->where(function ($query) use ($args) {
            $query->whereDate('created_at', $args['date'])
                ->orWhereHas('timeEntries', function($sql) use($args) {
                    $sql->whereDate('start_time', $args['date']);
                });
        });

        if (isset($args['userUuid'])) {
            $query->where('user_uuid', $args['userUuid']);
        }

        if (isset($args['organizationUuid'])) {
            $query->whereHas('project', function($query) use ($args) {
                $query->getProjects(Organization::MORPH_NAME, $args['organizationUuid']);
            });
        } else {
            $query->where(function($query) use ($args) {
               $query->whereNull('project_uuid')
                   ->orWhereHas('project', function($query) use ($args) {
                       $query->where('owner_uuid', $args['userUuid']);
                   });
            });
        }

        return $query->get()
            ->load(['timeEntries' => function ($query) {
                $query->orderBy('start_time');
            }]);
    }
}