<?php

namespace App\Http\GraphQL\Types;

use App\Models\Client;
use App\Models\Organization;
use App\Models\User;

class ClientType
{
    public function name(Client $client)
    {
        return $client->contact->first_name . ' ' . $client->contact->last_name;
    }

    public function organizationUuid(Client $client)
    {
        return $client->organization_uuid;
    }

    public function contactUuid(Client $client)
    {
        return $client->contact_uuid;
    }

    public function invoicePrefix(Client $client)
    {
        return $client->invoice_prefix;
    }
}
