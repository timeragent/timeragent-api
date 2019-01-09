<?php

namespace App\Http\GraphQL\Queries;

use App\Models\Organization;
use App\Models\Task;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class FetchTasks
{
    public function resolve($rootValue, array $args)
    {
        $query = Task::query();

        $user = Auth::user();

        $query->where(function ($query) use ($args) {
            $query->whereDate('created_at', $args['date'])
                  ->orWhereHas('timeEntries', function($sql) use($args) {
                      $sql->whereDate('start_time', $args['date']);
                  });
        });

        $query->where('user_uuid', $args['userUuid']);

        if (isset($args['organizationUuid'])) {
            $query->whereHas('project', function($query) use ($args) {
                $query->getProjects(Organization::MORPH_NAME, $args['organizationUuid'], $args['userUuid']);
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
