<?php

namespace Chat\Scenario\Api;

use \Chat\Http\Request;
use \Chat\Scenario;
use \GraphQL\GraphQL as Handler;
use \GraphQL\Type\Definition\ObjectType;
use \GraphQL\Type\Definition\Type;
use \GraphQL\Type\Schema;


/**
 * Implements scenario of GraphQL API endpoint.
 */
class Graphql implements Scenario
{
    /**
     * Runs scenario of GraphQL API endpoint.
     *
     * @param Request $req  HTTP request to GraphQL API endpoint.
     *
     * @throws \RuntimeException  If query does not exist.
     *
     * @return array  Result of GraphQL API endpoint scenario.
     */
    public function run(Request $req): array
    {
        if (!$req->JSON->exists('query')) {
            throw new \RuntimeException('Query does not exist.');
        }

        $query = $req->JSON->String('query');

        $schema = new Schema([
            'query' => new ObjectType([
                'name' => 'Query',
                'fields' => [
                    'test' => [
                        'type' => Type::string(),
                        'resolve' => function () {
                            return 'Hello, world!';
                        },
                    ],
                ],
            ]),
        ]);

        $result = Handler::executeQuery($schema, $query);
        return ['toJSON' => $result->toArray()];
    }
}
