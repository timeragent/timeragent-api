<?php

namespace App\GraphQL\Mutation\Client;

use App\Models\Contact;
use App\Validation\Rules\Uuid;
use App\Models\Client;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use GraphQL\Type\Definition\Type;

class CreateClientMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createClient',
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
        $contactParams = collect($args['contact']);

        $contactFilteredParams = $contactParams->only([
            'uuid',
            'first_name',
            'last_name',
            'email',
            'telephone'
        ])
        ->toArray();

        $contact = Contact::create($contactFilteredParams);

        $clientParams = collect($args['client']);

        $clientFilteredParams = $clientParams->only([
            'uuid',
            'name',
            'organization_uuid',
            'invoice_prefix',
            'address',
        ])
        ->toArray();

        $clientFilteredParams['contact_uuid'] = $contact->uuid;

        $client = Client::create($clientFilteredParams);

        return $client;
    }
}