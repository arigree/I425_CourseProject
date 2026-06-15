<?php
/**
 * Author: Arissa Green
 * Date: 6/15/2026
 * File: JWTAuthenticator.php
 * Description:
 */

namespace MusicAPI\Authentication;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use MusicAPI\Models\User;

class JWTAuthenticator
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        if (!$request->hasHeader('Authorization')) {
            return AuthenticationHelper::withJson(
                ['Status' => 'Authorization header not found.'],
                401
            );
        }

        $auth = $request->getHeader('Authorization')[0];
        list(, $jwt) = explode(' ', $auth, 2);

        if (!User::validateJWT($jwt)) {
            return AuthenticationHelper::withJson(
                ['Status' => 'Authentication failed.'],
                403
            );
        }

        return $handler->handle($request);
    }
}