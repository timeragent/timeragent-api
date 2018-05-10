<?php

namespace App\GraphQL\Mutation\Client;

use App\Models\Contact;
use App\Validation\Rules\Uuid;
use App\Models\Client;
use Folklore\GraphQL\Support\Mutation;
use GraphQL;
use GraphQL\Type\Definition\Type;

class DeleteClientMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteClient',
    ];

    public function type()
    {
        return GraphQL::type('Client');
    }

    public function args()
    {
        return [
            'client_uuid' => ['name' => 'client_uuid', 'type' => Type::nonNull(Type::string())],
            'contact_uuid' => ['name' => 'contact_uuid', 'type' => Type::nonNull(Type::string())],
        ];
    }

    public function rules()
    {
        return [
            'client_uuid' => [
                'required',
                new Uuid(),
            ],
            'contact_uuid' => [
                'required',
                new Uuid(),
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $client = Client::find($args['client_uuid']);

        $client->delete();

        $contact = Contact::find($args['contact_uuid']);

        $contact->delete();
    }
}