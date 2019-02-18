<?php

namespace App\Http\GraphQL\Mutations;

use App\Models\Organization;
use App\Models\OrganizationInvite;
use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
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

    public function createOrganizationInvite($root, $args)
    {
        $emails = $args['emails'];
        $user = Auth::user();
        $organization = Organization::findOrFail($args['organizationUuid']);

        if ($organization->users->where('uuid', $user->uuid)->first()->pivot->status != 1) {
            throw new \Exception('Access denied');
        }

        $invites = [];

        foreach ($emails as $email) {
            $token = Password::getRepository()->createNewToken();
            $invite = new OrganizationInvite();
            $invite->organization_uuid = $organization->uuid;
            $invite->email = $email;
            $invite->token = $token;
            $invite->status = OrganizationInvite::STATUS_PENDING;
            $invite->save();

            $invites[] = $invite;

            Mail::send('organization.emails.invite', [
                'organization' => $organization,
                'user' => Auth::user(),
                'token' => $token,
            ],
                function ($message) use ($email, $organization) {
                    $message
                        ->to($email)
                        ->subject('Invitation to join organization ' . $organization->name);
                });
        }

        return $invites;
    }

    public function acceptInvite($root, $args)
    {
        $invite = OrganizationInvite::where('token', $args['token'])->first();

        $user = User::where('email', $invite->email)->first();

        $invite->organization->users()->attach(
            $user->uuid,
            [
                'status' => 2
            ]
        );

        $invite->status = OrganizationInvite::STATUS_ACCEPTED;
        $invite->save();

        return $invite->organization;
    }

    public function declineInvite($root, $args)
    {
        $invite = OrganizationInvite::where('token', $args['token'])->first();

        $invite->status = OrganizationInvite::STATUS_DECLINED;
        $invite->save();

        return null;
    }
}
