<?php
/**
 * Author: Jonathan Nguyen
 * Date: 6/15/2026
 * File: MyAuthenticator.php
 * Description:
 */

namespace MusicAPI\Authentication;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use MusicAPI\Models\User;
class MyAuthenticator {
    public function __invoke(Request $request, RequestHandler $handler) : Response {
        if(!$request->hasHeader('MusicAPI-Authorization')) {
            $results = ['Status' => 'MusicAPI-Authorization header not found.'];
            return AuthenticationHelper::withJson($results, 401);
        }
        //Retrieve the header.
        $auth = $request->getHeader('MusicAPI-Authorization');
        $apikey = $auth[0];
        list($username, $password) = explode(':', $auth[0]);
        $auth = $request->getHeader('MusicAPI-Authorization');
        list($username, $password) = explode(':', $auth[0]);
        if(!User::authenticateUser($username, $password)) {
            $results = ['Status' => 'Authentication failed.'];
            return AuthenticationHelper::withJson($results, 403);
        }
        return $handler->handle($request);
    }


}