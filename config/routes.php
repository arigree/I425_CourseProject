<?php
/**
 * Author: Jonathan Nguyen
 * Date: 5/31/2026
 * File: routes.php
 * Description:
 */

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
// Create app routes
    // Add an app route
    $app->get('/', function (Request $request, Response $response, array $args) {
        $response->getBody()->write('course project');
        return $response;
    });
// Add another route
    $app->get('/api/hello/{name}', function (Request $request, Response $response,
                                             array $args) {
        $response->getBody()->write("Hello " . $args['name']);
        return $response;
    });

//Route group api/v1 pattern
    $app->group('/api/v1', function(RouteCollectorProxy $group) {

        $group->group('/artist', function (RouteCollectorProxy $group) {
            $group->get('/{id}', 'Artist:view');
            $group->get('', 'Artist:index');
        });
        $group->group('/song', function (RouteCollectorProxy $group) {
            $group->get('/{id}', 'Song:view');
            $group->get('', 'Song:index');
        });
        $group->group('/album', function (RouteCollectorProxy $group) {
            $group->get('/{id}', 'Album:view');
            $group->get('', 'Album:index');
        });
    });

// Handle invalid routes
    $app->any('{route:.*}', function(Request $request, Response $response) {
        $response->getBody()->write("Page Not Found");
        return $response->withStatus(404);
    });

};
