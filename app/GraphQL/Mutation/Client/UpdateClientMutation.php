<?php

namespace App\GraphQL\Mutation\Client;

use App\Models\Contact;
use App\Validation\Rules\Uuid;
use App\Models\Client;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use GraphQL\Type\Definition\Type;

class UpdateClientMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateClient',
    ];

    public function type()
    {
        return GraphQL::type('Client');
    }

    public function args()
    {
        return [
            'client' => ['name' => 'client', 'type' => GraphQL::type('ClientInput')],
            'contact' => ['name' => 'contact', 'type' => GraphQL::type('ContactInput')],
        ];
    }

    public function rules()
    {
        return [
            'client.uuid' => [
                'required',
                new Uuid(),
            ],
            'client.name' => [
                'required',
            ],
            'contact.uuid' => [
                'required',
                new Uuid(),
            ],
            'contact.firstName' => [
                'required',
            ],
            'contact.email' => [
                'required',
                'email'
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $contact = Contact::where('uuid', $args['contact']['uuid'])->first();

        $contactParams = collect($args['contact']);

        $contact_data = [
            'first_name' => $contactParams['firstName'],
            'last_name' => $contactParams['lastName'],
            'email' => $contactParams['email'],
            'telephone' => $contactParams['telephone'],
        ];

        $contact->update($contact_data);

        $client = Client::where('uuid', $args['client']['uuid'])->first();

        $clientParams = collect($args['client']);

        $client_data = [
            'name' => $clientParams['name'],
            'organization_uuid' => $clientParams['organizationUuid'],
            'contact_uuid' => $clientParams['contactUuid'],
            'invoice_prefix' => $clientParams['invoicePrefix'],
            'address' => $clientParams['address'],
        ];
        $client->update($client_data);

        return $client;
    }
}