<?php

namespace App\Http\GraphQL\Mutations;

use App\Models\Client;
use App\Models\Contact;

class ClientMutator
{
    public function createClient($rootValue, array $args)
    {
        $contact_data = $args['contact'];

        $contact             = new Contact();
        $contact->uuid       = $contact_data['uuid'];
        $contact->first_name = $contact_data['firstName'];
        $contact->last_name  = $contact_data['lastName'];
        $contact->email      = $contact_data['email'];
        $contact->telephone  = $contact_data['telephone'];
        $contact->save();

        $client_data = $args['client'];

        $client                    = new Client();
        $client->uuid              = $client_data['uuid'];
        $client->name              = $client_data['name'];
        $client->organization_uuid = $client_data['organizationUuid'];
        $client->invoice_prefix    = $client_data['invoicePrefix'];
        $client->address           = $client_data['address'];
        $client->contact_uuid      = $contact->uuid;
        $client->save();

        return $client;
    }

    public function updateClient($root, $args)
    {
        $contact = Contact::where('uuid', $args['contact']['uuid'])->first();

        $contact_data = $args['contact'];

        $contact->first_name = $contact_data['firstName'];
        $contact->last_name  = $contact_data['lastName'];
        $contact->email      = $contact_data['email'];
        $contact->telephone  = $contact_data['telephone'];
        $contact->save();

        $client = Client::where('uuid', $args['client']['uuid'])->first();

        $client_data = $args['client'];

        $client->name              = $client_data['name'];
        $client->organization_uuid = $client_data['organizationUuid'];
        $client->invoice_prefix    = $client_data['invoicePrefix'];
        $client->address           = $client_data['address'];
        $client->contact_uuid      = $contact->uuid;
        $client->save();

        return $client;
    }

    public function deleteClient($root, $args)
    {
        $client = Client::find($args['clientUuid']);

        $client->delete();

        $contact = Contact::find($args['contactUuid']);

        $contact->delete();

        return $client;
    }
}
