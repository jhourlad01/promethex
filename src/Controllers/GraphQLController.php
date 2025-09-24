<?php

namespace App\Controllers;

use Framework\Controller;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use App\GraphQL\Schema as GraphQLSchema;
use GraphQL\Error\DebugFlag;

class GraphQLController extends Controller
{
    public function query()
    {
        try {
            // Get the GraphQL query from the request
            $input = $this->request->getInput();
            $query = $input['query'] ?? null;
            $variables = $input['variables'] ?? null;
            $operationName = $input['operationName'] ?? null;

            if (!$query) {
                return $this->json([
                    'error' => 'No query provided'
                ], 400);
            }

            // Build the GraphQL schema
            $schema = GraphQLSchema::build();

            // Execute the query
            $result = GraphQL::executeQuery(
                $schema,
                $query,
                null,
                null,
                $variables,
                $operationName
            );

            // Enable debugging in development
            $debugFlag = DebugFlag::INCLUDE_DEBUG_MESSAGE | DebugFlag::INCLUDE_TRACE;
            
            return $this->json($result->toArray($debugFlag));

        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function playground()
    {
        // Simple GraphQL Playground HTML
        $html = '
<!DOCTYPE html>
<html>
<head>
    <title>GraphQL Playground</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/graphql-playground-react/build/static/css/index.css" />
    <link rel="shortcut icon" href="https://cdn.jsdelivr.net/npm/graphql-playground-react/build/favicon.png" />
    <script src="https://cdn.jsdelivr.net/npm/graphql-playground-react/build/static/js/middleware.js"></script>
</head>
<body>
    <div id="root">
        <style>
            body { margin: 0; font-family: Open Sans, sans-serif; overflow: hidden; }
            #root { width: 100vw; height: 100vh; }
        </style>
        <div style="display: flex; align-items: center; justify-content: center; height: 100vh; font-family: Open Sans, sans-serif;">
            <div>
                <h1>GraphQL Playground</h1>
                <p>GraphQL endpoint: <code>/graphql</code></p>
                <p>Try this query:</p>
                <pre style="background: #f5f5f5; padding: 10px; border-radius: 5px;">
{
  products(limit: 5) {
    id
    name
    price
    category {
      name
    }
  }
}
                </pre>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener("load", function (event) {
            GraphQLPlayground.init(document.getElementById("root"), {
                endpoint: "/graphql"
            });
        });
    </script>
</body>
</html>';

        return $this->response->setContent($html)->setHeader('Content-Type', 'text/html');
    }
}
