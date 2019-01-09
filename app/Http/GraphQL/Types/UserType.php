<?php

namespace App\Http\GraphQL\Types;

use App\Models\User;

class UserType
{
    public function name(User $user)
    {
        return $user->first_name . ' ' . $user->last_name;
    }

    public function firstName(User $user)
    {
        return $user->first_name;
    }

    public function lastName(User $user)
    {
        return $user->last_name;
    }

    public function middleName(User $user)
    {
        return $user->middle_name;
    }

    public function costRate(User $user)
    {
        return $user->cost_rate;
    }

    public function options(User $user)
    {
        return [
            'costRate' => $user->pivot->cost_rate,
            'status' => $user->pivot->status,
        ];
    }

    public function createdAt(User $user)
    {
        return $user->created_at;
    }

    public function updatedAt(User $user)
    {
        return $user->updated_at;
    }

    public function statusInOrganization(User $user, $args)
    {
        if (isset($args['organizationUuid'])) {
            return $user->organizations()
                        ->where('uuid', $args['organizationUuid'])
                        ->first()->pivot->status;
        }
    }
}
