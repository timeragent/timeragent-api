<?php

use App\GraphQL\InputTypes\OrganizationInputType;
use App\GraphQL\InputTypes\UserInputType;
use App\GraphQL\InputTypes\TeamInputType;
use App\GraphQL\InputTypes\ClientInputType;
use App\GraphQL\InputTypes\ContactInputType;
use App\GraphQL\InputTypes\ProjectInputType;
use App\GraphQL\InputTypes\ProjectUserInputType;
use App\GraphQL\InputTypes\ProjectUserOptionsInputType;

use App\GraphQL\Mutation\Organization\CreateOrganizationMutation;
use App\GraphQL\Mutation\Organization\UpdateOrganizationMutation;
use App\GraphQL\Mutation\User\CreateUserMutation;
use App\GraphQL\Mutation\User\UpdateUserMutation;
use App\GraphQL\Mutation\User\VerifyUserMutation;
use App\GraphQL\Mutation\Team\CreateTeamMutation;
use App\GraphQL\Mutation\Team\UpdateTeamMutation;
use App\GraphQL\Mutation\Team\DeleteTeamMutation;
use App\GraphQL\Mutation\Client\CreateClientMutation;
use App\GraphQL\Mutation\Client\UpdateClientMutation;
use App\GraphQL\Mutation\Client\DeleteClientMutation;
use App\GraphQL\Mutation\Project\CreateProjectMutation;
use App\GraphQL\Mutation\Project\UpdateProjectMutation;
use App\GraphQL\Mutation\Project\DeleteProjectMutation;

use App\GraphQL\Query\Organization\OrganizationQuery;
use App\GraphQL\Query\User\UsersQuery;
use App\GraphQL\Query\Team\TeamsQuery;
use App\GraphQL\Query\Client\ClientsQuery;
use App\GraphQL\Query\Project\ProjectsQuery;

use App\GraphQL\Type\OrganizationType;
use App\GraphQL\Type\UserType;
use App\GraphQL\Type\TeamType;
use App\GraphQL\Type\ClientType;
use App\GraphQL\Type\ContactType;
use App\GraphQL\Type\ProjectType;
use App\GraphQL\Type\ProjectUserType;
use App\GraphQL\Type\ProjectUserOptionsType;


return [

    /*
     * The prefix for routes
     */
    'prefix'                => '',

    /*
     * The domain for routes
     */
    'domain'                => env('API_URL'),

    /*
     * The routes to make GraphQL request. Either a string that will apply
     * to both query and mutation or an array containing the key 'query' and/or
     * 'mutation' with the according Route
     *
     * Example:
     *
     * Same route for both query and mutation
     *
     * 'routes' => [
     *     'query' => 'query/{graphql_schema?}',
     *     'mutation' => 'mutation/{graphql_schema?}',
     *      mutation' => 'graphiql'
     * ]
     *
     * you can also disable routes by setting routes to null
     *
     * 'routes' => null,
     */
    'routes'                => '{graphql_schema?}',

    /*
     * The controller to use in GraphQL requests. Either a string that will apply
     * to both query and mutation or an array containing the key 'query' and/or
     * 'mutation' with the according Controller and method
     *
     * Example:
     *
     * 'controllers' => [
     *     'query' => '\Folklore\GraphQL\GraphQLController@query',
     *     'mutation' => '\Folklore\GraphQL\GraphQLController@mutation'
     * ]
     */
    'controllers'           => \Folklore\GraphQL\GraphQLController::class . '@query',

    /*
     * The name of the input variable that contain variables when you query the
     * endpoint. Most libraries use "variables", you can change it here in case you need it.
     * In previous versions, the default used to be "params"
     */
    'variables_input_name'  => 'variables',

    /*
     * Any middleware for the 'graphql' route group
     */
    'middleware'            => [
        'auth:api',
    ],

    /**
     * Any middleware for a specific 'graphql' schema
     */
    'middleware_schema'     => [
        'default' => 'check_verification',
        // 'default' => 'check_verification|other_middleware|another_middleware:param1=value1:param2=value2',
    ],

    /*
     * Any headers that will be added to the response returned by the default controller
     */
    'headers'               => [],

    /*
     * Any JSON encoding options when returning a response from the default controller
     * See http://php.net/manual/function.json-encode.php for the full list of options
     */
    'json_encoding_options' => 0,

    /*
     * Config for GraphiQL (see (https://github.com/graphql/graphiql).
     * To disable GraphiQL, set this to null
     */
    'graphiql'              => [
        'routes'     => '/graphiql/{graphql_schema?}',
        'controller' => \Folklore\GraphQL\GraphQLController::class . '@graphiql',
        'middleware' => [],
        'view'       => 'graphql::graphiql',
        'composer'   => \Folklore\GraphQL\View\GraphiQLComposer::class,
    ],

    /*
     * The name of the default schema used when no arguments are provided
     * to GraphQL::schema() or when the route is used without the graphql_schema
     * parameter
     */
    'schema'                => 'default',

    /*
     * The schemas for query and/or mutation. It expects an array to provide
     * both the 'query' fields and the 'mutation' fields. You can also
     * provide an GraphQL\Type\Schema object directly.
     *
     * Example:
     *
     * 'schemas' => [
     *     'default' => new Schema($config)
     * ]
     *
     * or
     *
     * 'schemas' => [
     *     'default' => [
     *         'query' => [
     *              'users' => 'App\GraphQL\Query\UsersQuery'
     *          ],
     *          'mutation' => [
     *
     *          ]
     *     ]
     * ]
     */
    'schemas'               => [
        'default' => [
            'query'        => [
                UsersQuery::class,
                OrganizationQuery::class,
                TeamsQuery::class,
                ClientsQuery::class,
                ProjectsQuery::class,
            ],
            'mutation'     => [
                CreateUserMutation::class,
                UpdateUserMutation::class,
                VerifyUserMutation::class,

                CreateOrganizationMutation::class,
                UpdateOrganizationMutation::class,

                CreateTeamMutation::class,
                UpdateTeamMutation::class,
                DeleteTeamMutation::class,

                CreateClientMutation::class,
                UpdateClientMutation::class,
                DeleteClientMutation::class,

                CreateProjectMutation::class,
                UpdateProjectMutation::class,
                DeleteProjectMutation::class,
            ],
            'subscription' => [],
            'types'        => [],
        ],
    ],

    /*
     * Additional resolvers which can also be used with shorthand building of the schema
     * using \GraphQL\Utils::BuildSchema feature
     *
     * Example:
     *
     * 'resolvers' => [
     *     'default' => [
     *         'echo' => function ($root, $args, $context) {
     *              return 'Echo: ' . $args['message'];
     *          },
     *     ],
     * ],
     */
    'resolvers'             => [
        'default' => [
        ],
    ],

    /*
     * Overrides the default field resolver
     * Useful to setup default loading of eager relationships
     *
     * Example:
     *
     * 'defaultFieldResolver' => function ($root, $args, $context, $info) {
     *     // take a look at the defaultFieldResolver in
     *     // https://github.com/webonyx/graphql-php/blob/master/src/Executor/Executor.php
     * },
     */
    'defaultFieldResolver'  => null,

    /*
     * The types available in the application. You can access them from the
     * facade like this: GraphQL::type('user')
     *
     * Example:
     *
     * 'types' => [
     *     'user' => 'App\GraphQL\Type\UserType'
     * ]
     *
     * or without specifying a key (it will use the ->name property of your type)
     *
     * 'types' =>
     *     'App\GraphQL\Type\UserType'
     * ]
     */
    'types'                 => [
        // Generic Types
        UserType::class,
        OrganizationType::class,
        TeamType::class,
        ClientType::class,
        ContactType::class,
        ProjectType::class,
        ProjectUserType::class,
        ProjectUserOptionsType::class,

        // Input Types
        UserInputType::class,
        OrganizationInputType::class,
        TeamInputType::class,
        ClientInputType::class,
        ContactInputType::class,
        ProjectInputType::class,
        ProjectUserInputType::class,
        ProjectUserOptionsInputType::class,
    ],

    /*
     * This callable will receive all the Exception objects that are caught by GraphQL.
     * The method should return an array representing the error.
     *
     * Typically:
     *
     * [
     *     'message' => '',
     *     'locations' => []
     * ]
     */
    'error_formatter'       => [\Folklore\GraphQL\GraphQL::class, 'formatError'],

    /*
     * Options to limit the query complexity and depth. See the doc
     * @ https://github.com/webonyx/graphql-php#security
     * for details. Disabled by default.
     */
    'security'              => [
        'query_max_complexity'  => null,
        'query_max_depth'       => null,
        'disable_introspection' => false,
    ],
];
