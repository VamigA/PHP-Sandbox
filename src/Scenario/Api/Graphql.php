<?php

namespace Chat\Scenario\Api;

use \Chat\Http\Request;
use \Chat\Scenario;


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
     * @return array  Result of GraphQL API endpoint scenario.
     */
    public function run(Request $req): array
    {
        return ['toJSON' => [
            'data' => 'Hello, World!',
        ]];
    }
}
