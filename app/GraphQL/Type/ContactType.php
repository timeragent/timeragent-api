<?php

namespace App\GraphQL\Type;

use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;
use GraphQL\Type\Definition\Type;
use App\Models\Contact;

class ContactType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Contact',
        'description' => 'Contact person of a client',
    ];

    /*
    * Uncomment following line to make the type input object.
    * http://graphql.org/learn/schema/#input-types
    */
    // protected $inputObject = true;

    public function fields()
    {
        return [
            'uuid'          => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The uuid of the contact person',
            ],
            'firstName'          => [
                'type'        => Type::string(),
                'description' => 'The first name of contact person',
                'resolve'     => function ($contact) {
                    return $contact->first_name;
                }
            ],
            'lastName' => [
                'type' => Type::string(),
                'description' => 'The last name of the contact person',
                'resolve'     => function ($contact) {
                    return $contact->last_name;
                }
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The full name of the contact person',
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email of the contact person',
            ],
            'telephone' => [
                'type' => Type::string(),
                'description' => 'The telephone of the contact person',
            ],
        ];
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    public function resolveNameField(Contact $contact, $args)
    {
        return $contact->first_name . " " . $contact->last_name;
    }
}