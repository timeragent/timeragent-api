<?php

namespace App\Http\GraphQL\Types;

use App\Models\Client;
use App\Models\Contact;
use App\Models\Organization;
use App\Models\User;

class ContactType
{
    public function name(Contact $contact)
    {
        return $contact->first_name . ' ' . $contact->last_name;
    }

    public function firstName(Contact $contact)
    {
        return $contact->first_name;
    }

    public function lastName(Contact $contact)
    {
        return $contact->last_name;
    }
}
