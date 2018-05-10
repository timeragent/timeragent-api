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
            'contact.first_name' => [
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

        $contactFilteredParams = $contactParams->only([
            'first_name',
            'last_name',
            'email',
            'telephone'
        ])
        ->toArray();

        $contact->update($contactFilteredParams);

        $client = Client::where('uuid', $args['client']['uuid'])->first();

        $clientParams = collect($args['client']);

        $clientFilteredParams = $clientParams->only([
            'name',
            'organization_uuid',
            'contact_uuid',
            'invoice_prefix',
            'address',
        ])
        ->toArray();

        $client->update($clientFilteredParams);

        return $client;
    }
}