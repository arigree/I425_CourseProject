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
use MusicAPI\Authentication\{MyAuthenticator};

return function (App $app) {
// Create app routes
    // Add an app route
    $app->get('/', function (Request $request, Response $response, array $args) {
        $response->getBody()->write('course project');
        return $response;
    });
// Add another route
    $app->get('/api/hello/{name}', function (Request $request, Response $response,
                                             array   $args) {
        $response->getBody()->write("Hello " . $args['name']);
        return $response;
    });

//Route group api/v1 pattern
    $app->group('/api/v1', function (RouteCollectorProxy $group) {

        $group->group('/artist', function (RouteCollectorProxy $group) {
            $group->get('/{id}', 'Artist:view');
            $group->get('', 'Artist:index');
            $group->get('/{id}/album', 'Artist:albums');
            $group->get('/{id}/song', 'Artist:songs');
            $group->post('', 'Artist:create');
            $group->delete('/{id}', 'Artist:delete');
            $group->put('/{id}', 'Artist:update');
        });
        $group->group('/song', function (RouteCollectorProxy $group) {
            $group->get('/{id}', 'Song:view');
            $group->get('', 'Song:index');
            $group->get('/{id}/artist', 'Song:artists');
            $group->post('', 'Song:create');
            $group->delete('/{id}', 'Song:delete');
            $group->put('/{id}', 'Song:update');
        });
        $group->group('/album', function (RouteCollectorProxy $group) {
            $group->get('/{id}', 'Album:view');
            $group->get('', 'Album:index');
            $group->post('', 'Album:create');
            $group->delete('/{id}', 'Album:delete');
            $group->put('/{id}', 'Album:update');
        });
    })->add(new MyAuthenticator());


// User route group
    $app->group('/api/v1/users', function (RouteCollectorProxy $group) {
        $group->get('', 'User:index');
        $group->get('/{id}', 'User:view');
        $group->post('', 'User:create');
        $group->put('/{id}', 'User:update');
        $group->delete('/{id}', 'User:delete');
    });

// Handle invalid routes
    $app->any('{route:.*}', function (Request $request, Response $response) {
        $response->getBody()->write("Page Not Found");
        return $response->withStatus(404);
    });


};
